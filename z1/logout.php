<?php declare(strict_types=1);

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: /z1/index.php');
    exit();
}

session_unset();
session_destroy();
header('Location: /z1/login-check.php');
exit();

?>
