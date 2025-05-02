<?php
session_start();
if (!isset($_SESSION['z7a'])) {
	header('Location: /z7a/sign_in');
	exit();
}

$content = $_POST['content'];
if (empty($content)) {
	echo "Error: Content is empty.";
	exit();
}
$file_path = __DIR__ . "/file.json";
if (file_put_contents($file_path, $content) === false) {
	echo "Error: Unable to write to file.";
	exit();
}

?>
