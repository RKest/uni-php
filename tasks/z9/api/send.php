<?php

require_once './common.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: /z5/home.php');
	exit();
}

session_start();
if (!isset($_SESSION['z9'])) {
	header('Location: /z9/sign_in');
	exit();
}


$user = $_SESSION["z9"];

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z9');

$uid1 = uid_of_user($conn, $user);
$uid2 = $_POST['uid'];
$message = htmlspecialchars($_POST["content"]);
$file = $_FILES['file'];

$rid = room_id($conn, $uid1, $uid2);

$uploadDir = "../uploads/";
$maxFileSize = 5 * 1024 * 1024;
function handleFileUpload($file) {
    global $uploadDir, $maxFileSize;

    $response = [
        'success' => false,
        'message' => '',
        'filepath' => ''
    ];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $response['message'] = 'Upload failed with error code: ' . $file['error'];
        return $response;
    }

    // Validate file size
    if ($file['size'] > $maxFileSize) {
        $response['message'] = 'File is too large. Maximum size is ' . ($maxFileSize / 1024 / 1024) . 'MB';
        return $response;
    }

    // Get file extension
    $fileInfo = pathinfo($file['name']);
    $extension = strtolower($fileInfo['extension']);

    // Generate unique filename
    $uploadPath = $uploadDir . $file['name'];

    // If file exsits error 
    if (file_exists($uploadPath)) {
            $response['message'] = 'File already exists';
            return $response;
    }

    // Move uploaded file to destination
	error_log("Move file to $uploadPath");
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $response['success'] = true;
        $response['message'] = 'File uploaded successfully';
        $response['filepath'] = $uploadPath;
    } else {
        $response['message'] = 'Failed to save file';
    }

    return $response;
}

$filename = null;
if ($file != null) {
	$filename = $file['name'];
	$res = handleFileUpload($file);
	if (!$res['success']) {
		error_log("File upload error: " . $res['message']);
		echo $res['message'];
		exit();
	}
}

error_log("Filename = $filename");
$stmt = $conn->prepare("INSERT INTO messages (uid, room_id, message, filename) VALUES (?, ?, ?, ?)");
$stmt->bind_param("iiss", $uid1, $rid, $message, $filename);
$stmt->execute();

$stmt->close();
$conn->close();
?>
