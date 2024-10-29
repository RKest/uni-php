<?php declare(strict_types=1);

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: /z3/index.php');
    exit();
}

session_unset();
session_destroy();
header('Location: /z3/index.php');
exit();

?>

