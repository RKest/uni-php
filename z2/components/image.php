<?php

if (!isset($_SESSION['user'])) {
    echo '<img alt="profile" src=""></img>';
    exit();
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z2');

$user = $_SESSION['user'];
$stmt = $conn->prepare("SELECT image FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

$img_src = isset($result['image']) ? 
    $result['image'] :
    "data: image/png; base64,". base64_encode(file_get_contents("static/default.png"));
?>

<img height="50" width="50" src="<?php echo $img_src; ?>" class="img-fluid rounded" alt="Profile">
