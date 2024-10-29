<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: /z3/sign_in.php');
	exit();
}
?>

<html lang="pl">
<head>
	<meta charset="UTF-8">
	<title>Ind</title>
	<?php require_once 'common_head.php' ?>
</head>
<body>

<?php require_once 'nav.php';?>

<ul>
	<li><a href="/z3/spec/phpinfo.php">Phpinfo</a></li>
	<li><a href="/z3/spec/whoami.php">Whoami</a></li>
	<li><a href="/z3/spec/top.php">Top</a></li>
	<li><a href="/z3/spec/ls.php">Ls</a></li>
	<li><a href="/z3/spec/get_dns_record.php">Get dns record</a></li>
	<li><a href="/z3/spec/get_host_by_name.php">Get host by name</a></li>
	<li><a href="/z3/spec/geoloc.php">Geoloc</a></li>
	<li><a href="/z3/spec/register_guest.php">Register guest</a></li>
	<li><a href="/z3/spec/guests_table.php">Guests table</a></li>
</ul>

</body>
</html>
