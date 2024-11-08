<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: /z5/sign_in.php');
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
	<li><a href="/z5/spec/filelist.php">List Files</a></li>
	<li><a href="/z5/spec/add_file.php">Add file</a></li>
</ul>

</body>
</html>

