<?php
session_start();
if (!isset($_SESSION['z5'])) {
	header('Location: /z5/sign_in');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: /z5/home.php');
	exit();
}

require_once __DIR__ . '/common.php';

$user = $_SESSION['z5'];
$uploadDir = "../uploads/$user/";
$dir = $_POST['dir'];
if (!file_exists("$uploadDir/$dir")) {
    mkdir("$uploadDir/$dir", 0777, true);
} else {
    echo "Directory already exists";
    exit();
}

echo dirElem($dir);
?>
