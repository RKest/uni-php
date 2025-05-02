<?php
session_start();
if (!isset($_SESSION['z11'])) {
	header('Location: /z11/sign_in');
	exit();
}

$x0 = $_POST['x0'];
$y0 = $_POST['y0'];
$x_delta = $_POST['x_delta'];
$y_delta = $_POST['y_delta'];
$begin_s = $_POST['begin_s'];
$diameter = $_POST['diameter'];
$time_s = $_POST['time_s'];
$color = $_POST['color'];

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z11');

if (!$conn) {
	echo "Errno: " . $conn->error;
	exit();
}

$stmt = $conn->prepare("INSERT INTO animations (x0, y0, x_delta, y_delta, begin_s, diameter, time_s, color) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("iiiiiiis", $x0, $y0, $x_delta, $y_delta, $begin_s, $diameter, $time_s, $color);

if (!$stmt->execute()) {
	echo "Error: " . $conn->error;
	$stmt->close();
	$conn->close();
	exit();
}

$stmt->close();
$conn->close();

header('Location: /z11/animations');
?>
