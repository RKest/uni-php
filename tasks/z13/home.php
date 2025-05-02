<?php
declare(strict_types=1);

require_once __DIR__ . '/api/common.php';

$user = $_SESSION["z13"];
$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z13');

if (!$conn) {
	echo "Error: " . $conn->connect_error;
	goto conn_close;
}

$uid = uid_of_user($conn, $user);

echo '
<form hx-post="/tasks/z13/api/add-task.php" hx-target="main" hx-swap="innerHTML">
	<input type="text" name="title" placeholder="New task title" required>
	<button type="submit">Add Task</button>
</form>
';

echo '<main>';
render($conn, $uid);
echo '</main>';

user_stmt_close:
conn_close:
$conn->close();
?>
