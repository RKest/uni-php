<div 
	id="contact-search-input" contenteditable="true" style="display: inline-block; width: 100%"
	hx-post="/tasks/z7a/api/set_content.php"
    hx-push-url="false"
	hx-trigger="input delay:500ms from:#contact-search-input"
    hx-vals="javascript: content:htmx.find('#contact-search-input').innerHTML"
    hx-swap="none"
	>
<?php
echo file_get_contents(__DIR__ . "/api/file.json");
?>
</div>
