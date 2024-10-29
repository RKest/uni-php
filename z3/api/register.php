<?php

$image = null;

if (!empty($_FILES['profile_image']['tmp_name'])) {
    $pimage = $_FILES['profile_image'];
    $contents = file_get_contents($pimage['tmp_name']);
    $image = "data:" . $pimage['type'] . ";base64," . base64_encode($contents);
}

$user = htmlentities($_POST['user'], ENT_QUOTES, 'UTF-8');
$pass = htmlentities($_POST['pass'], ENT_QUOTES, 'UTF-8');

if ($user === "" || $pass === "") {
	echo "Error: Must provide username and password";
	exit();
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z3');

$stmt = $conn->prepare("INSERT INTO users (username, password, image) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $pass, $image);

if (!$stmt->execute()) {
    echo "Registration failed";
} else {
    session_start();
    $_SESSION['user'] = $user;
    header('Location: /z3/index.php');
}

$stmt->close();
$conn->close();

?>

