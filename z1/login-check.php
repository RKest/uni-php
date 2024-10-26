<?php declare(strict_types=1);

session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: /z1/index.php');
    exit();
}

echo "You're logged in"

?>

<br><a href="/z1/logout.php">Log out</a>
