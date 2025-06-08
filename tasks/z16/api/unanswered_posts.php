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

$topic_id = $_GET['topic_id'];

$sql = "
    SELECT p.id, t.name AS topic_name, u_client.username AS client_name,
           p.client_question, p.question_datetime
    FROM posts p
    JOIN topics t ON p.topic_id = t.id
    JOIN users u_client ON p.client_id = u_client.id
    WHERE p.employee_answer IS NULL
    AND p.topic_id = ?
    ORDER BY p.question_datetime ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $topic_id);
if(!$stmt->execute()) {
    exit();
}

$result = $stmt->get_result();

if ($result->num_rows === 0) {
	echo '<p>Brak pytań do obsługi w wybranym zagadnieniu.</p>';
	exit();
}

echo '<h4>Pytania do obsługi:</h4>';
while ($post = $result->fetch_assoc()) {
    echo '<form 
	hx-post="/tasks/z16/api/answer_post.php" hx-swap="delete"
	style="border: 1px solid #ddd; padding: 8px; margin-bottom: 5px; border-radius: 3px;">
    ';
    echo '<strong>Klient:</strong> ' . htmlspecialchars($post['client_name']) . '<br>';
    echo '<strong>Pytanie:</strong> ' . htmlspecialchars($post['client_question']) . '<br>';
    echo '<em>Zadano: ' . $post['question_datetime'] . '</em><br>';
    echo '<input type="hidden" name="post_id" value="' . $post['id'] . '">';
    echo '<input type="text" name="employee_answer" placeholder="Twoja odpowiedź" required style="width: 100%; margin-top: 5px;"><br>';
    echo '<input type="submit" value="Odpowiedz">';
    echo '</form>';
}
?>
