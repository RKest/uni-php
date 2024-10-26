<?php
declare(strict_types=1);
session_start();

?>
<html lang="pl">

<head>
<?php require_once 'common_head.php' ?>
</head>
<body style="height: 100%; display: flex; flex-direction: column">
<?php require_once 'nav.php'; ?>	

<main style="flex: 1; text-align: center; margin-top: 50px;">

<?php

if (!isset($_SESSION['user'])) {
	echo "Please log in";
} else {
	echo "Welcome to the site";
}

?>

</main>
<?php require_once 'footer.php'; ?>	
</body>
</html>
