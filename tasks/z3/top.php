<?php
	exec ('TERM=xterm /usr/bin/env top n 1 b i', $top, $error);
	echo nl2br(implode("\n",$top));
	if ($error){
		exec('TERM=xterm /usr/bin/env top n 1 b 2>&1', $error);
		die("Error: " . implode("\n",$error));
	}
?>
