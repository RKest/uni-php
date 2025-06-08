<h2>Panel Pracownika</h2>

<h3>Wybierz zagadnienie do obsługi:</h3>
<p>
    <select name="topic_id"
            hx-get="/tasks/z16/api/unanswered_posts.php"
            hx-target="#unanswered_posts"
            hx-trigger="change">
        <?php
            $topicStmt = $conn->prepare("SELECT id, name FROM topics ORDER BY name ASC");
			if (!$topicStmt->execute()) {
				echo '<option value="">Błąd pobierania zagadnień</option>';
				exit();
			}
			$topics = $topicStmt->get_result();
            while ($topic = $topics->fetch_assoc()) {
                echo '<option value="' . $topic['id'] . '">' . htmlspecialchars($topic['name']) . '</option>';
            }
			$topicStmt->close();
        ?>
    </select>
</p>

<div id="unanswered_posts" style="border: 1px solid #ccc; padding: 15px; min-height: 200px; border-radius: 5px;">
    <p>Wybierz zagadnienie z listy powyżej, aby wyświetlić pytania do obsługi.</p>
</div>
