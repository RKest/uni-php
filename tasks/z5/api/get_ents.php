<?php
session_start();
if (!isset($_SESSION['z5'])) {
	header('Location: /z5/sign_in');
	exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
	header("HTTP/1.1 405 Method Not Allowed");
	exit();
}

$user = $_SESSION['z5'];
$cwd = $_GET['dir'] ?? '';
$uploadDir = __DIR__ . "/../uploads/$user/$cwd";

if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($cwd === '') {
    echo '
	<form hx-post="/tasks/z5/api/add_dir.php" hx-target="ul" hx-swap="beforeend">
		<input type="text" name="dir" id="dir">
		<input type="submit" value="Add Directory" name="submit">
	</form>
    ';
} else {
    echo '
	<form hx-get="/tasks/z5/api/get_ents.php" hx-target="main" hx-swap="innerHTML">
	    <input type="submit" value="Go back">
	</form>
	<span>' . $cwd . '/</span>
    ';
}

echo '
    <form hx-post="/tasks/z5/api/add_file.php" hx-target="ul" hx-swap="afterbegin" hx-encoding="multipart/form-data">
	    <input type="file" name="file" id="file">
	    <input type="hidden" name="dir" value=' . $cwd .'>
	    <input type="submit" value="Upload File" name="submit">
    </form>
';

$files = scandir($uploadDir);
echo '<ul>';
foreach ($files as $file) {
	if ($file == '.' || $file == '..') {
		continue;
	}
	if (is_dir("$uploadDir/$file")) {
		echo "<li>
			<form style='margin: 0;' hx-get='/tasks/z5/api/get_ents.php' hx-target='main' hx-swap='innerHTML'>
				<input type='hidden' name='dir' value='$file'>
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
				' type='submit' value='$file/'>
			</form>
		</li>";
		continue;
	} else {
		echo "<li><a href='/tasks/z5/uploads/$user/$cwd/$file' download>$file</a></li>";
	}
}
echo '</ul>';
?>

