<ul>
<?php
$user = $_SESSION['z5'];
if (!file_exists(__DIR__.'/uploads/' . $user)) {
	echo "No files";
	exit();
}

$files = scandir(__DIR__.'/uploads/' . $user);
foreach ($files as $file) {
	if ($file == '.' || $file == '..') {
		continue;
	}
	echo "<li><a href='/tasks/z5/uploads/$user/$file' download>$file</a></li>";
}
?>
</ul>


