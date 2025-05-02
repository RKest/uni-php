<?php
session_start();
if (!isset($_SESSION['z7a'])) {
	header('Location: /z7a/sign_in');
	exit();
}

echo file_get_contents(__DIR__ . "/file.json");
?>
