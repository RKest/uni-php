<?php declare(strict_types=1);

$user = htmlentities($_POST['user'], ENT_QUOTES, 'UTF-8');
$pass = htmlentities($_POST['pass'], ENT_QUOTES, 'UTF-8');
$link = mysqli_connect('localhost', 'db_user', 'db_password', 'db_name');

if (false == $link) {
    echo "Error: " . mysqli_connect_error();
    exit();
}

$result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'");
$record = mysqli_fetch_array($result);

if ($record && $record['password'] === $pass) {
    echo "Login successful";
} else {
    echo "Invalid login or password";
}
mysqli_close($link);

?>
