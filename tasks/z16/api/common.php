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

function render_rating($rating) {
	echo '<strong>Twoja ocena:</strong> ';
	for ($i = 1; $i <= $rating; $i++) {
		echo '&#9733;'; // Star symbol
	}
	echo ' (' . $rating . ' gwiazdek)<br>';
}

function render_post($post) {
	echo '<div style="border: 1px solid #eee; padding: 10px; margin-bottom: 15px; border-radius: 5px;">';
	echo '<strong>Zagadnienie:</strong> ' . htmlspecialchars($post['topic_name']) . '<br>';
	echo '<strong>Twoje pytanie (' . $post['question_datetime'] . '):</strong> ' . htmlspecialchars($post['client_question']) . '<br>';

	if ($post['employee_answer']) {
		echo '<strong>Odpowiedź pracownika ' . htmlspecialchars($post['employee_name'] ?? 'N/A') . ' (' . $post['answer_datetime'] . '):</strong> ' . htmlspecialchars($post['employee_answer']) . '<br>';

		// Rating section
		echo '<div id="post_' . $post['id'] . '_rating_area">'; // HTMX target for rating updates
		if ($post['rating'] === null) {
			// Allow rating if not already rated
			?>
			<form hx-post="/tasks/z16/api/rate.php" hx-target="#post_<?php echo $post['id']; ?>_rating_area" hx-swap="innerHTML">
				<input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
				<label>Oceń obsługę (1-5 gwiazdek):</label>
				<select name="rating">
					<option value="1">&#9733;</option>
					<option value="2">&#9733;&#9733;</option>
					<option value="3">&#9733;&#9733;&#9733;</option>
					<option value="4">&#9733;&#9733;&#9733;&#9733;</option>
					<option value="5">&#9733;&#9733;&#9733;&#9733;&#9733;</option>
				</select>
				<input type="submit" value="Oceń">
			</form>
			<?php
		} else {
			render_rating($post['rating']);
		}
		echo '</div>'; // End #post_X_rating_area
	} else {
		echo '<p>Oczekiwanie na odpowiedź pracownika...</p>';
	}
	echo '</div>'; // End post div
}

function get_posts($conn, $uid) {
    $stmt = $conn->prepare("
        SELECT p.id, t.name AS topic_name, p.client_question, p.question_datetime,
               p.employee_answer, p.answer_datetime, p.rating, u.username AS employee_name
        FROM posts p
        JOIN topics t ON p.topic_id = t.id
        LEFT JOIN users u ON p.employee_id = u.id
        WHERE p.client_id = ?
        ORDER BY p.question_datetime DESC
    ");
	$stmt->bind_param("i", $uid);
    if (!$stmt->execute()) {
		echo '<div class="error">Błąd podczas pobierania pytań.</div>';
		exit();
	}
	$posts = $stmt->get_result();
	return $posts;
}

function get_post_by_id($conn, $id) {
    $stmt = $conn->prepare("
        SELECT p.id, t.name AS topic_name, p.client_question, p.question_datetime,
               p.employee_answer, p.answer_datetime, p.rating, u.username AS employee_name
        FROM posts p
        JOIN topics t ON p.topic_id = t.id
        LEFT JOIN users u ON p.employee_id = u.id
        WHERE p.id = ?
    ");
	$stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
		echo '<div class="error">Błąd podczas pobierania pytań.</div>';
		exit();
	}
	$posts = $stmt->get_result();
	return $posts->fetch_assoc();
}

?>
