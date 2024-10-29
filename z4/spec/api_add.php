<?php
session_start();
if (!isset($_SESSION['user'])) {
	echo "Error: Must log in";
	exit();
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z4');

if (!$conn) {
	echo "Errno: " . $conn->error;
	exit();
}

$stmt = $conn->prepare("INSERT INTO domains (host, port) VALUES (?, ?)");
$stmt->bind_param("si", $_POST['host'], $_POST['port']);
if (!$stmt->execute()) {
	echo "Error: " . $conn->error;
	$stmt->close();
	$conn->close();
	exit();
}

header('Location: /z4/spec/list.php');
?>
