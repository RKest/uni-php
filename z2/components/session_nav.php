<?php

if (!isset($_SESSION["user"])) {
	require_once 'sign_in_nav.php';
} else {
	require_once 'logout_nav.php';
}

?>
