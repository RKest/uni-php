<?php

if (!isset($_SESSION['user'])) {
    echo '<img alt="profile" src=""></img>';
    exit();
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z2');

$stmt = $conn->prepare("SELECT image_data, image_type FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

print_r($result);

$img_src = isset($result['image_data']) ? 
    "data:" . $result['image_type'] . ";base64," . base64_encode($result['image_data']) :
    "data: image/png; base64,". base64_encode(file_get_contents("static/default.png"));
?>

<img height="50" width="50" src="<?php echo $img_src; ?>" class="img-fluid rounded" alt="Profile">
