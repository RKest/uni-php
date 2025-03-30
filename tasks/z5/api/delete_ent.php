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

$user = $_SESSION['z5'];
$dir = $_POST['dir'] ?? '';
$uploadDir = "../uploads/$user/$dir/";
$toDelete = $_POST['to-delete'] ?? '';

if ($toDelete == '') {
        http_response_code(400);
        exit();
}

$toDelete = "$uploadDir/$toDelete";

if (!file_exists($toDelete)) {
        http_response_code(500);
        exit();
}

if (is_dir($toDelete)) {
        array_map('unlink', glob("$toDelete/*.*"));
        rmdir($toDelete);
} else {
        unlink($toDelete);
}

echo "";

?>
