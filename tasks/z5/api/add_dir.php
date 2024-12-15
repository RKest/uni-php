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

$user = $_SESSION['z5'];
$uploadDir = "../uploads/$user/";
$dir = $_POST['dir'];
if (!file_exists("$uploadDir/$dir")) {
    mkdir("$uploadDir/$dir", 0777, true);
} else {
    echo "Directory already exists";
    exit();
}

echo "<li>
        <form hx-get='/tasks/z5/api/get_ents.php' hx-target='main' hx-swap='innerHTML'>
                <input type='hidden' name='dir' value='$dir'>
                <input style='
                  background: none!important;
                  border: none;
                  padding: 0!important;
                  /*optional*/
                  font-family: arial, sans-serif;
                  /*input has OS specific font-family*/
                  color: #069;
                  text-decoration: underline;
                  cursor: pointer;
                ' type='submit' value='$dir/'>
        </form>
</li>";
?>
