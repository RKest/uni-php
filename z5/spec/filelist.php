<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: /z5/sign_in.php');
	exit();
}
?>

<?php require_once '../common_head.php'; ?>

<body>
<?php require_once '../nav.php'; ?>

<ul>
<?php
$user = $_SESSION['user'];
$files = scandir('../uploads/' . $user);
foreach ($files as $file) {
	if ($file == '.' || $file == '..') {
		continue;
	}
	echo "<li><a href='/z5/uploads/$user/$file' download>$file</a></li>";
}
?>
</ul>

</body>


