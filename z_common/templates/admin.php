<?php
session_start();

if (!isset($_SESSION[$znum])) {
    header("Location: /$znum/sign_in");
    exit();
}

$user = $_SESSION[$znum] ?? null;
if ($user !== "admin") {
    echo "Access denied";
    exit();
}   

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ind</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="h-100 d-flex align-items-center justify-content-center p-4 bg-body-tertiary">
<main class="form-signin w-100 m-auto" style="max-width: 330px">
<?php

$db_pass = getenv("MYSQL_PASSWD");
$conn = new mysqli('127.0.0.1', 'root', $db_pass, $znum);

$login_stmt = $conn->prepare("SELECT * FROM logins");
if (!$login_stmt->execute()) {
    echo "Error: " . $login_stmt->error;
    exit();
}

$login_res = $login_stmt->get_result();
echo '<table border=1>';
echo '<tr><th>UID</th><th>Login Time</th><th>Incorrect logins:</th></tr>';
while ($row = $login_res->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['uid'] . "</td>";
    echo "<td>" . $row['last_login'] . "</td>";
    echo "<td>" . $row['state'] . "</td>";
    echo "</tr>";
}
echo '</table>';
?>
</main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
