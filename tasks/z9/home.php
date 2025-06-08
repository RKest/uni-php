<body>
	<script>
	    let lastContent = "";
	    function compareAndSwap(event) {
			const xhr = event.detail.xhr;
			const newContent = xhr.responseText;
			event.detail.shouldSwap = lastContent !== newContent;
			lastContent = newContent;
	    }
	</script>
	<form hx-post="/tasks/z9/api/send.php" hx-vals='js:{"uid": document.getElementById("sel").value}' hx-swap="none" hx-encoding='multipart/form-data'>
		<input type="text" name="content" placeholder="Type your message here" required>
		<input type="file" name="file">
		<input type="submit" value="Send">
	</form>
	<select id="sel" hx-post="/tasks/z9/api/room.php" hx-vals='js:{"uid": event.target.value || "1"}' hx-trigger="load, change from:select" hx-target="#messages" hx-swap="innerHTML">
		<?php
			if (!isset($_SESSION['z9'])) {
				header('Location: /z9/sign_in');
				exit();
			}

			$user = $_SESSION["z9"];

			$db_pass = getenv("MYSQL_PASSWD");
			$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z9');

			if (!$conn) {
				echo "Errno: " . $conn->error;
				exit();
			}

			$stmt = $conn->prepare("SELECT id, username FROM users WHERE username != ? ORDER BY id ASC");
			$stmt->bind_param("s", $user);
			$stmt->execute();
			$result = $stmt->get_result();

			while ($row = $result->fetch_assoc()) {
				$username = htmlspecialchars($row['username']);
				$uid = htmlspecialchars($row['id']);
				echo "<option value=\"$uid\">$username</option>";
			}

			$stmt->close();
		?>
	</select>
	<div
		hx-post="/tasks/z9/api/sse.php"
		hx-trigger="load, every 1s"
		hx-target="this"
		hx-vals='js:{"uid": document.getElementById("sel").value || "1"}'
		hx-swap="innerHTML"
		hx-on:htmx:before-swap="compareAndSwap(event)"
	>
	</div>
</body>
