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
	$ipaddress = $_SERVER["REMOTE_ADDR"];
	$details = json_decode(file_get_contents("http://ipinfo.io/{$ipaddress}/geo"));
	if (isset($details->region)) {
		echo $details->region; echo '<BR />';
		echo $details->country; echo '<BR />';
		echo $details->city; echo '<BR />';
		echo $details->loc; echo '<BR />';
		echo $details->ip; echo '<BR />';
	} else {
		echo "Could not determine geolocation information";
	}
?>

