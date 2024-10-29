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

$stmt = $conn->prepare("SELECT * FROM domains");
if (!$stmt->execute()) {
	echo "Error: " . $conn->error;
	$stmt->close();
	$conn->close();
	exit();
}

$id = 0;
$host = "";
$port = 0;
$open = false;
$errno = 0;

$stmt->bind_result($id, $host, $port);
echo '<table class="table">';
echo "<tr><th>id</th><th>host</th><th>port</th><th>open</th></tr>";
while ($stmt->fetch()) {
	echo "<tr>";

	echo "<td>$id</td>";
	echo "<td>$host</td>";
	echo "<td>$port</td>";
	$fp = @fsockopen($host, $port, $errno, $errstr, 30);
	if ($fp) {
		echo "<td>Open</td>";
		fclose($fp);
	} else {
		echo "<td>Closed</td>";
	}
	
	echo "</tr>";
}

echo "</table>";

$stmt->close();
$conn->close();
?>

