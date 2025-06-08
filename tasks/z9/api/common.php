<?php

function uid_of_user($conn,$user) {
	$users_stmt = $conn->prepare("SELECT id FROM users WHERE username=? LIMIT 1");
	$users_stmt->bind_param("s", $user);
	if (!$users_stmt->execute()) {
		echo "Error: " . $users_stmt->error;
		goto user_stmt_close;
	}
	$user_res = $users_stmt->get_result();
	if ($user_res->num_rows === 0) {
		echo "Invalid login or password";
		goto user_stmt_close;
	}
	$uid = $user_res->fetch_row()[0];
	user_stmt_close:
	$users_stmt->close();
	return $uid;
}

function username_of_uid($conn,$uid) {
	$users_stmt = $conn->prepare("SELECT username FROM users WHERE id=? LIMIT 1");
	$users_stmt->bind_param("i", $uid);
	if (!$users_stmt->execute()) {
		echo "Error: " . $users_stmt->error;
		goto user_stmt_close;
	}
	$user_res = $users_stmt->get_result();
	if ($user_res->num_rows === 0) {
		echo "Invalid login or password";
		goto user_stmt_close;
	}
	$username = $user_res->fetch_row()[0];
	user_stmt_close:
	$users_stmt->close();
	return $username;
}

function room_id($conn, $uid1, $uid2) {
    // Heck to prevent self-chatting on load lol
    if ($uid1 === $uid2) {
	if ($uid2 == 1) {
	    $uid2 = 2;
	} else {
	    $uid2 = 1;
	}
    }

    while (true) {
	$stmt = $conn->prepare("SELECT id FROM rooms WHERE (user1_id = ? AND user2_id = ?) OR (user1_id = ? AND user2_id = ?) LIMIT 1");
	$stmt->bind_param("iiii", $uid1, $uid2, $uid2, $uid1);
	if (!$stmt->execute()) {
	    echo "Error: " . $stmt->error;
	    exit();
	} 
	$result = $stmt->get_result();
	if ($result->num_rows == 0) {
	    $insstmt = $conn->prepare("INSERT INTO rooms (user1_id, user2_id) VALUES (?, ?)");
	    $insstmt->bind_param("ii", $uid1, $uid2);
	    if (!$insstmt->execute()) {
		    echo "Error: " . $insstmt->error;
		    exit();
	    }
	    $insstmt->close();
	} else {
	    $row = $result->fetch_assoc();
	    $stmt->close();
	    return $row['id'];
	}
	$stmt->close();
    }
}

function messages_for_room($conn, $rid) {
    $stmt = $conn->prepare("SELECT uid, message, filename FROM messages WHERE room_id = ?");
    $stmt->bind_param("i", $rid);
    if (!$stmt->execute()) {
	echo "Error: " . $stmt->error;
	exit();
    }
    if(!$stmt->execute()) {
	echo "Error: " . $stmt->error;
	exit();
    }
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
	echo "No messages found.";
	return;
    }
    while ($row = $result->fetch_assoc()) {
	$username = username_of_uid($conn, $row['uid']);
	echo '<div>';
	echo '<strong>' . htmlspecialchars($username) . ':</strong><br>';
	echo htmlspecialchars($row['message']);
	if ($row['filename'] === null || $row['filename'] === '') {
	    goto next_row;
	}
	$ext = pathinfo($row['filename'], PATHINFO_EXTENSION);
	if ($ext === 'jpg' || $ext === 'jpeg' || $ext === 'png' || $ext === 'gif') {
	    echo '<br><img src="/tasks/z9/uploads/' . htmlspecialchars($row['filename']) . '" alt="Image" style="max-width: 300px; max-height: 300px;">';
	} elseif ($ext === 'mp4' || $ext === 'webm') {
	    echo '<br><video controls style="max-width: 300px; max-height: 300px;"><source src="/tasks/z9/uploads/' . htmlspecialchars($row['filename']) . '" type="video/' . htmlspecialchars($ext) . '"></video>';
	} elseif ($ext === 'mp3' || $ext === 'wav') {
	    echo '<br><audio controls><source src="/tasks/z9/uploads/' . htmlspecialchars($row['filename']) . '" type="audio/' . htmlspecialchars($ext) . '"></audio>';
	} else {
	    echo ' <a href="/tasks/z9/uploads/' . htmlspecialchars($row['filename']) . '" target="_blank" download>' . htmlspecialchars($row['filename']) . '</a>';
	}

	next_row:
	echo '</div>';
    }
}

?>
