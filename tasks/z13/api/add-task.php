<?php

require __DIR__ . '/common.php';

session_start();
if (!isset($_SESSION['z13'])) {
	header('Location: /z13/sign_in');
	exit();
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z13');

if (!$conn) {
	echo "Errno: " . $conn->error;
	goto conn_close;
}

$user = $_SESSION["z13"];
$uid = uid_of_user($conn, $user);

$stmt = $conn->prepare("INSERT INTO tasks (uid, title) VALUES (?, ?)");
$stmt->bind_param("is", $uid, $_POST['title']);
if (!$stmt->execute()) {
	echo "Error: " . $stmt->error;
	goto stmt_close;
}

render($conn, $uid);

stmt_close:
$stmt->close();
conn_close:
$conn->close();
?>
