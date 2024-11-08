<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: /z5/sign_in.php');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	header('Location: /z5/spec/add_file.php');
	exit();
}

$user = $_SESSION['user'];
$uploadDir = "../uploads/$user/";
$maxFileSize = 5 * 1024 * 1024;
$allowedExtensions = ['pdf', 'doc', 'docx', 'txt', 'jpg', 'jpeg', 'png'];

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
    
    // Check if file was uploaded without errors
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

// Handle the upload if a file was submitted
if (!empty($_FILES['file'])) {
    $result = handleFileUpload($_FILES['file']);
    
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}
echo empty($_FILES['file']);
?>
