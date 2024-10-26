<?php

$image_data = null;
$image_type = null;

if (!empty($_FILES['profile_image']['tmp_name'])) {
    $image_data = file_get_contents($_FILES['profile_image']['tmp_name']);
    $image_type = $_FILES['profile_image']['type'];
}

$user = htmlentities($_POST['user'], ENT_QUOTES, 'UTF-8');
$pass = htmlentities($_POST['pass'], ENT_QUOTES, 'UTF-8');

if ($user === "" || $pass === "") {
	echo "Error: Must provide username and password";
	exit();
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z2');

$stmt = $conn->prepare("INSERT INTO users (username, password, image_data, image_type) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $user, $pass, $image_data, $image_type);

if (!$stmt->execute()) {
    echo "Registration failed";
} else {
    session_start();
    $_SESSION['user'] = $user;
    header('Location: /z2/index.php');
}

$stmt->close();
$conn->close();

?>

