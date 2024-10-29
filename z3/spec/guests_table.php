<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: /z3/sign_in.php');
	exit();
}
?>
<?php require_once '../common_head.php'; ?>
<?php require_once '../nav.php'; ?>

<?php
	function loc_anchor($ip) {
		$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/geo"));
		if (!isset($details->loc)) {
			return "";
		} else {
			$loc = $details->loc;
			return "<a href='https://www.google.pl/maps/place/$loc'>loc</a>";
		}
	}

	$db_pass = getenv("MYSQL_PASSWD");
	$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z3');

	$stmt = $conn->prepare("SELECT * FROM guests");
	if (!$stmt->execute()) {
		echo "Error: " . $conn->error;
		$stmt->close();
		$conn->close();
		exit();
	}

	$id = 0;
	$ipaddr = "";
	$browser = "";
	$screen_resolution = "";
	$browser_resolution = "";
	$colors = 0;
	$cookies_allowed = 0;
	$java_allowed = 0;
	$language = "";
	$first_login = "";
	$stmt->bind_result($id, $ipaddr, $browser, $screen_resolution, $browser_resolution, $colors, $cookies_allowed, $java_allowed, $language, $first_login);
	echo "<table border='1'>";
	echo "<tr><th>id</th><th>ipaddr</th><th>browser</th><th>screen_resolution</th><th>browser_resolution</th><th>colors</th><th>cookies_allowed</th><th>java_allowed</th><th>language</th><th>first_login</th><th>loc</th></tr>";
	while ($stmt->fetch()) {
		echo "<tr>";

		echo "<td>$id</td>";
		echo "<td>$ipaddr</td>";
		echo "<td>$browser</td>";
		echo "<td>$screen_resolution</td>";
		echo "<td>$browser_resolution</td>";
		echo "<td>$colors</td>";
		echo "<td>$cookies_allowed</td>";
		echo "<td>$java_allowed</td>";
		echo "<td>$language</td>";
		echo "<td>$first_login</td>";
		echo "<td>" . loc_anchor($ipaddr) . "</td>";

		echo "</tr>";
	}
	echo "</table>";
	$stmt->close();
	$conn->close();
?>
