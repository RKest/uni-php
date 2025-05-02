<?php
session_start();
if (!isset($_SESSION['z11'])) {
	header('Location: /z11/sign_in');
	exit();
}

function anim($assoc) {
	$x0 = $assoc['x0'];
	$y0 = $assoc['y0'];
	$x_delta = $assoc['x_delta'];
	$y_delta = $assoc['y_delta'];
	$begin_s = $assoc['begin_s'];
	$diameter = $assoc['diameter'];
	$time_s = $assoc['time_s'];
	$color = $assoc['color'];

	$x1 = $x0 + $x_delta;
	$y1 = $y0 + $y_delta;

	echo "
		<div style='position: absolute; margin: 20;'>
			<svg xmlns='http://www.w3.org/2000/svg'>
				<circle cx='$x0' cy='$y0' r='$diameter' fill='$color'>
				<animate attributeName='cx' from='$x0' to='$x1' begin='0s' dur='".$time_s."s'repeatCount=indefinite keyTimes='0;1'/>
				<animate attributeName='cy' from='$y0' to='$y1' begin='" . $begin_s ."s' dur='".$time_s."s'repeatCount=indefinite keyTimes='0;1'/>
				</circle>
			</svg>
		</div>
	";
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z11');

if (!$conn) {
	echo "Errno: " . $conn->error;
	exit();
}

$stmt = $conn->prepare("SELECT x0, y0, x_delta, y_delta, begin_s, diameter, time_s, color FROM animations");
if (!$stmt->execute()) {
	echo "Error: " . $conn->error;
	$stmt->close();
	$conn->close();
	exit();
}

$result = $stmt->get_result();
while ($assoc = $result->fetch_assoc()) {
	anim($assoc);
}

$stmt->close();
$conn->close();

?>
