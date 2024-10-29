<?php

$user = htmlentities($_POST['user'], ENT_QUOTES, 'UTF-8');
$pass = htmlentities($_POST['pass'], ENT_QUOTES, 'UTF-8');
$db_pass = getenv("MYSQL_PASSWD");

$link = mysqli_connect('127.0.0.1', 'root', $db_pass, 'z3');

if (!$link) {
    echo "Error: " . mysqli_connect_error();
    exit();
}

$result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'");
$record = mysqli_fetch_array($result);

if ($record && $record['password'] === $pass) {
    session_start();
    $_SESSION['user'] = $user;
    header('Location: /z3/index.php');
} else {
    echo "Invalid login or password";
}

mysqli_close($link);

?>
