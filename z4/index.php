<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: /z4/sign_in.php');
	exit();
}
?>

<html lang="pl">
<head>
	<meta charset="UTF-8">
	<title>Ind</title>
</head>
<?php require_once 'common_head.php'; ?>
<body>

<?php
require_once 'nav.php';
?>

<ul>
	<li><a href="/z4/spec/list.php">List domains</a></li>
	<li><a href="/z4/spec/add.php">Add domain</a></li>
</ul>

</body>
</html>

