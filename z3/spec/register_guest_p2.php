<?php
	session_start();
	if (!isset($_SESSION['user'])) {
		header('Location: /z3/sign_in.php');
		exit();
	}

	$ipaddr = $_SERVER["HTTP_CLIENT_IP"] ?? $_SERVER["HTTP_X_FORWARDED_FOR"] ?? $_SERVER["REMOTE_ADDR"];

	$db_pass = getenv("MYSQL_PASSWD");
	$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z3');

	$browser = $_GET['browser'];
	$screen_resolution = $_GET['sw'] . "x" . $_GET['sh'];
	$browser_resolution = $_GET['bw'] . "x" . $_GET['bh'];
	$colors = intval($_GET['colors']);
	$cookies_allowed = intval($_GET['cookies']);
	$java_allowed = intval($_GET['java']);
	$language = $_GET['lang'];

	$stmt = $conn->prepare("INSERT IGNORE INTO guests (ipaddr, browser, screen_resolution, browser_resolution, colors, cookies_allowed, java_allowed, language) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssiiis", $ipaddr, $browser, $screen_resolution, $browser_resolution, $colors, $cookies_allowed, $java_allowed, $language);

	if (!$stmt->execute()) {
		echo "Error: " . $conn->error;
		$stmt->close();
		$conn->close();
		exit();
	}
	$stmt->close();
	$conn->close();
	header("Location: /z3/spec/guests_table.php");
?>

