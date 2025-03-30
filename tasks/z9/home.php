<form hx-post="/tasks/z9/api/send.php" hx-swap="none">
	<input type="text" name="content">
	<input type="submit">
</form>

<body hx-ext="sse" sse-connect="/tasks/z9/api/sse.php">
	<div sse-swap="message"></div>
</body>
