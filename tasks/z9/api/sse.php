<?php

session_start();
if (!isset($_SESSION['z9'])) {
	header('Location: /z9/sign_in');
	exit();
}

$user = $_SESSION["z9"];
$next_id = 0;

require (dirname(__DIR__).'/../../vendor/autoload.php');
use RedisClient\RedisClient;

$Redis = new RedisClient([
    'timeout' => 5 // wait 5 seconds for connection
]);

$Redis->subscribe('messages', function($type, $channel, $message) {
    if ($type === 'message') {
	global $next_id;
	$next_id += 1;
	sendSSE($next_id, $message);
    }
    return true;
});

// Set the appropriate headers for SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// Disable time limit for the script execution
set_time_limit(0);

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
