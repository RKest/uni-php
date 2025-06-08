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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $employee_answer = $_POST['employee_answer'];


    $stmt = $conn->prepare("UPDATE posts SET employee_id = ?, employee_answer = ?, answer_datetime = NOW() WHERE id = ?");
    $stmt->bind_param("isi", $uid, $employee_answer, $post_id);
    if (!$stmt->execute()) {
	echo '<div class="error">Błąd podczas aktualizacji pytania: ' . htmlspecialchars($stmt->error) . '</div>';
	exit();
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo '<div class="error">Ta strona obsługuje tylko żądania POST.</div>';
}
?>
