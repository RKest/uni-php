<?php
require_once './common.php';

session_start();
if (!isset($_SESSION['z16'])) {
    header('Location: /z16/sign_in');
    exit();
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z16');

if ($conn->connect_error) {
    http_response_code(500);
    error_log("Connection failed: " . $conn->connect_error);
    die('<div class="error">Błąd połączenia z bazą danych.</div>');
}

$user = $_SESSION['z16'];
$uid = uid_of_user($conn, $user);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'] ?? null;
    $rating = $_POST['rating'] ?? null;

    if ($post_id === null || $rating === null || !is_numeric($rating) || $rating < 1 || $rating > 5) {
        echo '<div class="error">Brakujące lub nieprawidłowe dane oceny.</div>';
        $conn->close();
        return;
    }

    $post_id = (int)$post_id;
    $rating = (int)$rating;

    try {
        $stmt = $conn->prepare("UPDATE posts SET rating = ? WHERE id = ? AND client_id = ? AND rating IS NULL");
        $stmt->bind_param("iii", $rating, $post_id, $uid);
        $stmt->execute();

	render_rating($rating);

        $stmt->close();
    } catch (Exception $e) {
        error_log("Error rating post: " . $e->getMessage());
        echo '<div class="error">Wystąpił błąd podczas zapisywania oceny. Spróbuj ponownie.</div>';
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo '<div class="error">Ta strona obsługuje tylko żądania POST.</div>';
}

$conn->close();
?>
