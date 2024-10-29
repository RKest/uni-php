<?php
	$host = 'fb.com';
	$port = '80';
	$errno = 0;
	{
	$fp = @fsockopen($host, $port, $errno, $errstr, 30);
	echo 'Host '.$host.':'.$port.' jest: ';
	if ($fp) { echo 'OK'; } else { echo 'Awaria'; }
	if (!$fp) { echo "$errstr ($errno)"; }
	}
?>
