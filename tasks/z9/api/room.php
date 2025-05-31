<?php

require_once './common.php';

session_start();
if (!isset($_SESSION['z9'])) {
	header('Location: /z9/sign_in');
	exit();
}

$user = $_SESSION["z9"];

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z9');

$uid1 = uid_of_user($conn, $user);
$uid2 = $_POST['uid'];

$rid = room_id($conn, $uid1, $uid2);
messages_for_room($conn, $rid);

$conn->close();
?>
