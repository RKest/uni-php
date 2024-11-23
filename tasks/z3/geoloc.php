<?php
	$ipaddr = $_SERVER["HTTP_CLIENT_IP"] ?? $_SERVER["HTTP_X_REAL_IP"] ?? $_SERVER["HTTP_X_FORWARDED_FOR"] ?? $_SERVER["REMOTE_ADDR"];
	$details = json_decode(file_get_contents("http://ipinfo.io/$ipaddr/geo"));
	if (isset($details->region)) {
		echo $details->region; echo '<BR />';
		echo $details->country; echo '<BR />';
		echo $details->city; echo '<BR />';
		echo $details->loc; echo '<BR />';
		echo $details->ip; echo '<BR />';
	} else {
		echo "Could not determine geolocation information";
	}
?>

