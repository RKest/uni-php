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
	$ip = gethostbyname('pbs.edu.pl');
	echo $ip . '<BR />';
	$ip = $_SERVER["REMOTE_ADDR"];
	echo $ip. '<BR />';
	$hostname = gethostbyaddr("8.8.8.8");
	echo $hostname. '<BR />';
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	echo $hostname;
?>