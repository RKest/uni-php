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

<form action="/z5/spec/add_file_api.php" method="POST" enctype="multipart/form-data">
	<input type="file" name="file" id="file">
	<input type="submit" value="Upload" name="submit">
</form>

</body>

