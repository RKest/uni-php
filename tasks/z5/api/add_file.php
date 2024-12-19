<?php
session_start();
if (!isset($_SESSION['z5'])) {
	header('Location: /z5/sign_in');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: /z5/home.php');
	exit();
}

require_once __DIR__ . "/common.php";

$user = $_SESSION['z5'];
$dir = $_POST['dir'] ?? '';
$uploadDir = "../uploads/$user/$dir/";
$maxFileSize = 5 * 1024 * 1024;
$allowedExtensions = ['pdf', 'doc', 'docx', 'txt', 'jpg', 'jpeg', 'png', 'mp3'];

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

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

    // If file exsits error 
    if (file_exists($uploadDir . $file['name'])) {
            $response['message'] = 'File already exists';
            return $response;
    }
    
    // Generate unique filename
    $uploadPath = $uploadDir . $file['name'];
    
    // Move uploaded file to destination
    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        $response['success'] = true;
        $response['message'] = 'File uploaded successfully';
        $response['filepath'] = $uploadPath;
    } else {
        $response['message'] = 'Failed to save file';
    }
    
    return $response;
}

if (!empty($_FILES['file'])) {
    $fileName = $_FILES['file']['name'];
    $result = handleFileUpload($_FILES['file']);
    if ($result['success']) {
        echo fileElem($user, $dir, $fileName);
    } else {
        header("HTTP/1.1 500 Internal Server Error");
    }
    exit;
}
echo empty($_FILES['file']);
?>
