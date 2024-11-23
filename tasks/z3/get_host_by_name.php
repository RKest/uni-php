<?php
	$ip = gethostbyname('pbs.edu.pl');
	echo $ip . '<BR />';
	$ip = $_SERVER["HTTP_CLIENT_IP"] ?? $_SERVER["HTTP_X_REAL_IP"] ?? $_SERVER["HTTP_X_FORWARDED_FOR"] ?? $_SERVER["REMOTE_ADDR"];
	echo $ip. '<BR />';
	$hostname = gethostbyaddr("8.8.8.8");
	echo $hostname. '<BR />';
	$hostname = gethostbyaddr($ip);
	echo $hostname;
?>
