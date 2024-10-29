<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: /z3/sign_in.php');
	exit();
}
?>
<?php require_once '../common_head.php'; ?>
<?php require_once '../nav.php'; ?>

<script defer>

const params = {
	sw: window.screen.width,
	sh: window.screen.height,
	bw: window.innerWidth,
	bh: window.innerHeight,
	browser: navigator.userAgent,
	lang: navigator.language,
	colors: window.screen.colorDepth,
	cookies: navigator.cookieEnabled ? 1 : 0,
	java: navigator.javaEnabled() ? 1 : 0
};

const encodeGetParams = p =>
  Object.entries(p).map(kv => kv.map(encodeURIComponent).join("=")).join("&");

window.location.href = '/z3/spec/register_guest_p2.php?' + encodeGetParams(params);

</script>
