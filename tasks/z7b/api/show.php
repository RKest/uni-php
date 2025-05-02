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

$stmt = $conn->prepare("SELECT x1, x2, x3, x4, x5, datetime FROM measurements ORDER BY id DESC LIMIT 1");
if (!$stmt->execute()) {
	echo "Error: " . $conn->error;
	$stmt->close();
	$conn->close();
	exit();
}

$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
	$x1 = $row['x1'];
	$x2 = $row['x2'];
	$x3 = $row['x3'];
	$x4 = $row['x4'];
	$x5 = $row['x5'];
	$timestamp = $row['datetime'];
}

echo ""
."<div>x1: $x1</div>"
."<div>x2: $x2</div>"
."<div>x3: $x3</div>"
."<div>x4: $x4</div>"
."<div>x5: $x5</div>"
."<div>Timestamp: $timestamp</div>";

$conn->close();
?>
