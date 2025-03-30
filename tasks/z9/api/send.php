<?php

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
$message = $_POST['content'];
$file = $_FILES['file'];

error_log(var_export($file, true));

$uploadDir = "../uploads/";
$maxFileSize = 5 * 1024 * 1024;
$allowedExtensions = ['pdf', 'doc', 'docx', 'txt', 'jpg', 'jpeg', 'png', 'mp3', 'yaml'];
function handleFileUpload($file) {
    global $uploadDir, $maxFileSize, $allowedExtensions;
    
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
    
    // Validate file extension
    if (!in_array($extension, $allowedExtensions)) {
        $response['message'] = 'Invalid file type. Allowed types: ' . implode(', ', $allowedExtensions);
        return $response;
    }

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
	error_log("File not empty");
	$filename = $file['name'];
	$res = handleFileUpload($file);
	if (!$res['success']) {
		error_log("File upload error: " . $res['message']);
		echo $res['message'];
		exit();
	}
}

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, 'z9');

if (!$conn) {
	error_log("Connection failed: " . $conn->connect_error);
	echo "Errno: " . $conn->error;
	exit();
}

error_log("Filename = $filename");
$stmt = $conn->prepare("INSERT INTO messages (username, content, file) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $message, $filename);
$stmt->execute();

$stmt->close();
$conn->close();
?>
