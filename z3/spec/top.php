<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: /z3/sign_in.php');
	exit();
}
?>
<?php require_once '../common_head.php'; ?>
<?php require_once '../nav.php'; ?>

<?php
	exec ('TERM=xterm /usr/bin/env top n 1 b i', $top, $error);
	echo nl2br(implode("\n",$top));
	if ($error){
	 exec ('TERM=xterm /usr/bin/env top n 1 b 2>&1', $error);
	 echo "Error: ";
	 exit ($error[0]);
	}
?>
