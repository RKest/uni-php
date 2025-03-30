<form hx-post="/tasks/z9/api/send.php" hx-swap="none" hx-encoding='multipart/form-data'>
	<input type="text" name="content">
	<input type="file" name="file">
	<input type="submit">
</form>

<body>
	<div 
		hx-get="/tasks/z9/api/sse.php"
		hx-trigger="load, every 1s"
		hx-swap="innerHTML">
	</div>
</body>
