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
    $conn = new mysqli('127.0.0.1', 'root', $db_pass, $znum);
    if (!$conn) {
	    echo "Error: " . $conn->connect_error;
	    goto conn_close;
    }

    $user_stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $user_stmt->bind_param("s", $user);
    if (!$user_stmt->execute()) {
	    echo "Error: " . $user_stmt->error;
	    goto user_stmt_close;
    }
    $user_res = $user_stmt->get_result();
    if ($user_res->num_rows === 0) {
	echo "Invalid login or password";
	goto user_stmt_close;
    }
    $user_assoc = $user_res->fetch_assoc();

    $login_check_stmt = $conn->prepare("SELECT * FROM logins WHERE uid=? LIMIT 1");
    $login_check_stmt->bind_param("i", $user_assoc['id']);
    if (!$login_check_stmt->execute()) {
	    echo "Error: " . $login_check_stmt->error;
	    goto login_check_stmt_close;
    }
    $login_check_res = $login_check_stmt->get_result();
    
    $invalid_login_num = 0;
    $invalid_login_time = 0;
    if ($login_check_res->num_rows === 0) {
	$login_insert_stmt = $conn->prepare("INSERT INTO logins (uid, last_login, state) VALUES (?, NOW(), 0)");
	$login_insert_stmt->bind_param("i", $user_assoc['id']);
	if (!$login_insert_stmt->execute()) {
	    echo "Error: " . $login_insert_stmt->error;
	    $login_insert_stmt->close();
	    goto login_check_stmt_close;
	}
	$login_insert_stmt->close();
	$login_check = ["state" => 0];
    } else {
	$login_check = $login_check_res->fetch_assoc();
	$invalid_login_num = $login_check["state"];
	$invalid_login_time = strtotime($login_check["last_login"]);
    }

    $curr_time = strtotime($conn->query("SELECT NOW()")->fetch_row()[0]);
    $d = $curr_time - $invalid_login_time;

    if ($invalid_login_num >= 3 && $d < 60) {
	echo "Too many unsuccessful login attempts. Please wait " . (60 - $d) . " seconds.";
	goto login_check_stmt_close;
    }

    $login_update_stmt = $conn->prepare("UPDATE logins SET last_login=NOW(), state=? WHERE uid=?");

    $uid = $user_assoc['id'];
    $new_state = 0;
    if ($user_assoc['password'] === $pass) {
	    session_start();
	    $_SESSION[$znum] = $user;
	    if ($user == "admin") {
		header("Location: /$znum/view/admin");
	    } else {
		header("Location: /$znum/home");
	    }
    } else {
	    $new_state = $login_check["state"] + 1;
	    echo "Invalid login or password";
    }

    $login_update_stmt->bind_param("ii", $new_state, $uid);
    $login_update_stmt->execute();

    $login_update_stmt->close();
    login_check_stmt_close:
    $login_check_stmt->close();
    user_stmt_close:
    $user_stmt->close();
    conn_close:
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
