<?php

declare(strict_types=1);

$post_sign_up = function($znum) {
    $image = null;

    if (!empty($_FILES['profile_image']['tmp_name'])) {
	$pimage = $_FILES['profile_image'];
	$contents = file_get_contents($pimage['tmp_name']);
	$image = "data:" . $pimage['type'] . ";base64," . base64_encode($contents);
    }

    $user = htmlentities($_POST['user'], ENT_QUOTES, 'UTF-8');
    $pass = htmlentities($_POST['pass'], ENT_QUOTES, 'UTF-8');

    if ($user === "" || $pass === "") {
	    echo "Error: Must provide username and password";
	    exit();
    }

    $db_pass = getenv("MYSQL_PASSWD");
    $conn = new mysqli('127.0.0.1', 'root', $db_pass, $znum);

    $stmt = $conn->prepare("INSERT IGNORE INTO users (username, password, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $pass, $image);

    if (!$stmt->execute()) {
	echo "Registration failed";
    } else {
	session_start();
	$_SESSION[$znum] = $user;
	header("Location: /$znum/home");
    }

    $stmt->close();
    $conn->close();
};

$post_sign_in = function($znum) {
    $user = htmlentities($_POST['user'], ENT_QUOTES, 'UTF-8');
    $pass = htmlentities($_POST['pass'], ENT_QUOTES, 'UTF-8');
    $db_pass = getenv("MYSQL_PASSWD");

    $link = mysqli_connect('127.0.0.1', 'root', $db_pass, $znum);

    if (!$link) {
	echo "Error: " . mysqli_connect_error();
	exit();
    }

    $conn = new mysqli('127.0.0.1', 'root', $db_pass, $znum);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && $result['password'] === $pass) {
	session_start();
	$_SESSION[$znum] = $user;
	header("Location: /$znum/home");
    } else {
	echo "Invalid login or password";
    }

    $stmt->close();
    $conn->close();
};

$get_sign_out = function($znum) {
    session_start();
    if (!isset($_SESSION[$znum])) {
	header("Location: /$znum/home");
	exit();
    }

   session_unset();
   session_destroy();
   header("Location: /$znum/home");
   exit();
};

function sendBase64Image($base64String) {
    if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $matches)) {
        $imageType = strtolower($matches[1]); // Get image type (jpeg, png, etc)
        $base64String = substr($base64String, strpos($base64String, ',') + 1);
    } else {
	die("Could not determine image type");
    }

    $imageData = base64_decode($base64String);

    if ($imageData === false) {
        http_response_code(400);
        die('Invalid base64 string');
    }

    switch ($imageType) {
        case 'jpeg':
        case 'jpg':
            header('Content-Type: image/jpeg');
            break;
        case 'png':
            header('Content-Type: image/png');
            break;
        case 'gif':
            header('Content-Type: image/gif');
            break;
        case 'webp':
            header('Content-Type: image/webp');
            break;
        default:
            http_response_code(400);
            die('Unsupported image type');
    }

    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');

    echo $imageData;
    exit;
}

$get_profile_image = function($znum) {
    session_start();
    if (!isset($_SESSION[$znum])) {
	echo '';
	exit();
    }

    $db_pass = getenv("MYSQL_PASSWD");
    $conn = new mysqli('127.0.0.1', 'root', $db_pass, $znum);

    $user = $_SESSION[$znum];
    $stmt = $conn->prepare("SELECT image FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (isset($result['image'])) {
	sendBase64Image($result['image']);
    } else {
	header('Content-Type: image/png');
	header('Location: /z_common/static/default.png');
    }

    $stmt->close();
    $conn->close();
}

?>
