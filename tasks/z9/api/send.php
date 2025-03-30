<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: /z5/home.php');
	exit();
}

session_start();
if (!isset($_SESSION['z9'])) {
	header('Location: /z9/sign_in');
	exit();
}

$user = $_SESSION["z9"];
$message = $_POST['content'];

require (dirname(__DIR__).'/../../vendor/autoload.php');
use RedisClient\RedisClient;

$Redis = new RedisClient([
    'timeout' => 5 // wait 5 seconds for connection
]);

$Redis->publish('messages', $message);

?>
