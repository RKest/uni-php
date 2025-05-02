<?php
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

$subtask_id = $_POST["subtask_id"];
$state = $_POST["state"];

$stmt = $conn->prepare("UPDATE subtasks SET state = ? WHERE id = ?");
$stmt->bind_param("ii", $state, $subtask_id);
if (!$stmt->execute()) {
	echo "Error: " . $stmt->error;
	goto stmt_close;
}

stmt_close:
$stmt->close();
conn_close:
$conn->close();
