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
	echo exec("whoami");
?>
