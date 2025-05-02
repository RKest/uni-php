<?php
session_start();
if (!isset($_SESSION['z7b'])) {
	header('Location: /z7b/sign_in');
	exit();
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z7b');

if (!$conn) {
	echo "Errno: " . $conn->error;
	exit();
}

$stmt = $conn->prepare("INSERT INTO measurements (x1, x2, x3, x4, x5) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ddddd", $_POST['x1'], $_POST['x2'], $_POST['x3'], $_POST['x4'], $_POST['x5']);
if (!$stmt->execute()) {
	echo "Error: " . $conn->error;
	$stmt->close();
	$conn->close();
	exit();
}
$stmt->close();
$conn->close();
header("Location: /z7b/add");
?>
