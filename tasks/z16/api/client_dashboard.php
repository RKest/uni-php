<?php

// Ensure the 'view' parameter is specifically for client dashboard if needed,
// though this file's logic is now exclusively for client.
$view = $_GET['view'] ?? 'client'; // Default to client view if not specified

echo '<h2>Panel Klienta</h2>';
echo '<div id="client_dashboard_status"></div>'; // Area for HTMX messages (e.g., form submission success/error)

?>

<h3>Zadaj nowe pytanie</h3>
<form hx-post="/tasks/z16/api/make_post.php" hx-target="#posts" hx-swap="beforeend">
    <label for="topic_id">Wybierz zagadnienie:</label><br>
    <select id="topic_id" name="topic_id" required>
        <?php
		$topicsStmt = $conn->prepare("SELECT id, name FROM topics ORDER BY name ASC");
		if (!$topicsStmt->execute()) {
			echo '<option value="">Błąd pobierania zagadnień</option>';
			exit();
		}
		$topicsResult = $topicsStmt->get_result();
		while ($topic = $topicsResult->fetch_assoc()) {
			echo '<option value="' . $topic['id'] . '">' . htmlspecialchars($topic['name']) . '</option>';
		}
        ?>
    </select><br><br>
    <label for="client_question">Twoje pytanie:</label><br>
    <textarea id="client_question" name="client_question" rows="5" cols="50" required></textarea><br><br>
    <button type="submit">Wyślij pytanie</button>
</form>

<hr>

<h3>Moje pytania i odpowiedzi</h3>
<div id="posts">
<?php
	require_once './common.php';
	$posts = get_posts($conn, $uid);

    if ($posts->num_rows === 0) {
        echo '<p>Brak zadanych pytań.</p>';
    } else {
        while ($post = $posts->fetch_assoc()) {
			render_post($post);
        }
    }
?>
</div>
