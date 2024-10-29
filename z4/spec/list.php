<?php
session_start();
if (!isset($_SESSION['user'])) {
	header('Location: /z4/sign_in.php');
	exit();
}
?>

<head>
<script src="https://unpkg.com/htmx.org@2.0.3"></script>
</head>
<?php require_once '../common_head.php'; ?>

<body>

<?php require_once '../nav.php'; ?>

<div
    hx-get="/z4/spec/api_list.php"
    hx-trigger="load, every 10s"
    hx-swap="innerHTML"
>
    Loading data...
</div>
</body>

