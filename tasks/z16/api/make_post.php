<?php

require_once './common.php';

session_start();
if (!isset($_SESSION['z16'])) {
	header('Location: /z16/sign_in');
	exit();
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z16');

$user = $_SESSION['z16'];
$uid = uid_of_user($conn, $user);

$stmt = $conn->prepare("SELECT user_type FROM users WHERE id=? LIMIT 1");
$stmt->bind_param("i", $uid);
if (!$stmt->execute()) {
	echo "Error: " . $stmt->error;
	exit();
}
$result = $stmt->get_result();
if ($result->num_rows === 0) {
	echo "Invalid user ID";
	exit();
}

$topic_id = $_POST['topic_id'];
$client_question = $_POST['client_question'];

$stmt = $conn->prepare("INSERT INTO posts (client_id, topic_id, client_question) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $uid, $topic_id, $client_question);

if (!$stmt->execute()) {
	echo "Error: " . $stmt->error;
	exit();
}

$post = get_post_by_id($conn, $stmt->insert_id);
render_post($post);

$stmt->close();
$conn->close();

?>
