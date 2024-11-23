<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ind</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="h-100 d-flex align-items-center justify-content-center p-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto" style="max-width: 330px">
        <form method="post" action="<?php echo $sign_in_uri ?>">
            <h1 class="h3 mb-4 fw-normal text-center">Sign in</h1>

            <div class="form-floating mb-2">
                <input name="user" type="username" class="form-control rounded-bottom-0" id="floatingInput" required>
                <label for="floatingInput">Username</label>
            </div>

            <div class="form-floating">
                <input name="pass" type="password" class="form-control rounded-top-0" id="floatingPassword" required>
                <label for="floatingPassword">Password</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary mt-3" type="submit">Sign in</button>
        </form>
        <div style="text-align: center">Or</div>
        <div>
            <a href="<?php echo $sign_up_uri; ?>" class="btn btn-lg btn-secondary w-100 mt-3">Sign up</a>
        </div>
</main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
