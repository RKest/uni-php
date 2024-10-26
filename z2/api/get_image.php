<?php

if (!isset($_SESSION['user'])) {
    echo "Error fetching image";
    exit();
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z2');

$stmt = $conn->prepare("SELECT image_data, image_type FROM users WHERE username = ?");
$stmt->bind_param("s", htmlentities($_SESSION['user']));
$stmt->execute();
$stmt->bind_result($image_data, $image_type);
$stmt->fetch();

if ($image_data === null) {
    // Default image path
    $image_data = file_get_contents('../static/default.png');
    $image_type = 'image/png';
}

header("Content-Type: " . $image_type);
echo $image_data;

$stmt->close();
$conn->close();
?>
