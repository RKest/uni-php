<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: /z4/sign_in.php');
	exit();
}
?>

<?php require_once '../common_head.php'; ?>

<body>
<?php require_once '../nav.php'; ?>

<form action="/z4/spec/api_add.php" method="POST">
	<label for="host">Host:</label>
	<input type="text" id="host" name="host" required>
	<label for="port">Port:</label>
	<input type="number" id="port" name="port" required>
	<input type="submit" value="Add">
</form>

</body>
