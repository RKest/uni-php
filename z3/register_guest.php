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

window.location.href = '/z3/register_guest_p2.php?' + encodeGetParams(params);

</script>
