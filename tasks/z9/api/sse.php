<?php

session_start();
if (!isset($_SESSION['z9'])) {
	header('Location: /z9/sign_in');
	exit();
}

$user = $_SESSION["z9"];

// Function to send an SSE event
function sendSSE($id, $data, $event = null) {
    echo "id: $id" . PHP_EOL;
    
    if ($event !== null) {
        echo "event: $event" . PHP_EOL;
    }
    
    echo "data: $data" . PHP_EOL . PHP_EOL;
    
    // Flush the output buffer to send data immediately
    ob_flush();
    flush();
}

// Function to get the latest messages from the database
// This function should be implemented to fetch messages from your database

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z9');

if (!$conn) {
	echo "Errno: " . $conn->error;
	exit();
}


$stmt = $conn->prepare("SELECT id, content, file FROM messages");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

// Log length
error_log("Log length: " . $result->num_rows);

while ($row = $result->fetch_assoc()) {
    formatResponse($user, $row['content'], $row['file']);
}

function formatResponse($user, $message, $filepath) {
    echo '<div>';
    echo '<strong>' . htmlspecialchars($user) . ':</strong> ';
    echo htmlspecialchars($message);
    if ($filepath) {
	echo '<a href="/tasks/z9/uploads/' . htmlspecialchars($filepath) . '" target="_blank" download>' . htmlspecialchars($filepath) . '</a>';
    }
    echo '</div>';
}

$conn->close();
