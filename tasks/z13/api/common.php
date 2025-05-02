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


function render($conn, $uid) {
	$tasks_stmt = $conn->prepare("SELECT id, title FROM tasks WHERE uid = ?");
	$tasks_stmt->bind_param("i", $uid);
	if (!$tasks_stmt->execute()) {
		echo "Error: " . $tasks_stmt->error;
		goto tasks_stmt_close;
	}

	$tasks = $tasks_stmt->get_result();

	$my_subtasks_stmt = $conn->prepare("
		SELECT t.title as parent_title, s.title, s.state, s.id
		FROM subtasks s
		JOIN tasks t ON s.task_id = t.id 
		WHERE s.uid = ?"
	);
	$my_subtasks_stmt->bind_param("i", $uid);
	if (!$my_subtasks_stmt->execute()) {
		echo "Error: " . $my_subtasks_stmt->error;
		goto my_tasks_stmt_close;
	}
	$my_subtasks = $my_subtasks_stmt->get_result();

	$users_stmt = $conn->prepare("SELECT id, username FROM users");
	if (!$users_stmt->execute()) {
		echo "Error: " . $users_stmt->error;
		goto users_stmt_close;
	}
	$users = $users_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

	echo '<h1>My tasks:</h1>';
	while ($task = $tasks->fetch_assoc()) {
		$subtasks = subtasks_for_task($conn, $task['id']);
		echo '
		<div class="task">
			<h2>' . htmlentities($task['title']) . '</h2>';
		while ($sub = $subtasks->fetch_assoc()) {
			echo '<div ' . color_style($sub['state']) . '>';
			echo '<p>' . htmlentities($sub['title']) . '</p>';
			echo '<input 
				hx-post="/tasks/z13/api/update-progress.php"
				hx-swap="none"
				hx-trigger="change, delay:500ms"
				hx-vals=\'js:{
					"subtask_id": "' . $sub["id"] . '",
					"state": event.target.value
				}\'
				type="range" min="0" max="100" 
				value="'. $sub["state"] .'"
			>';
			echo '</div>';
		}
		echo '<form 
			hx-post="/tasks/z13/api/add-subtask.php" 
			hx-target="main" 
			hx-swap="innerHTML"
			>
			<input type="text" name="title" placeholder="New subtask title" required>
			<input type="hidden" name="task_id" value="' . $task['id'] . '">
			<select name="uid" required>';
			foreach ($users as $user) {
				echo '<option value="'. $user["id"] .'">' . $user["username"] . '</option>';
			}
		    echo '</select>
			<button type="submit">Add Subtask</button>
		</form>';
		echo '</div>';
	}
	echo '<h1>My subtasks:</h1>';
	while ($sub = $my_subtasks->fetch_assoc()) {
		echo '<div ' . color_style($sub['state']) . '>';
		echo '<p>' . 
			htmlentities($sub['parent_title']) . " -> " . 
			htmlentities($sub['title']) . ": " . $sub['state'] . '% done</p>';
		echo '</div>';
	}
	users_stmt_close:
	$users_stmt->close();
	my_tasks_stmt_close:
	$my_subtasks_stmt->close();
	tasks_stmt_close:
	$tasks_stmt->close();
}

function subtasks_for_task($conn, $task_id) {
	$subtasks_stmt = $conn->prepare("SELECT id, title, state FROM subtasks WHERE task_id = ?");
	$subtasks_stmt->bind_param("i", $task_id);
	if (!$subtasks_stmt->execute()) {
		echo "Error: " . $subtasks_stmt->error;
		return [];
	}
	$subtasks = $subtasks_stmt->get_result();
	$subtasks_stmt->close();
	return $subtasks;
}

function color_style($state) {
	if ($state == 0) {
		return 'style="color: red;"';
	} elseif ($state == 100) {
		return 'style="color: green;"';
	} else {
		return 'style="color: black;"';
	} 
}
?>
