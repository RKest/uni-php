<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ind</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="h-100 d-flex align-items-center justify-content-center p-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto" style="max-width: 330px">
        <form method="post" action="<?php echo $sign_up_uri; ?>" enctype="multipart/form-data">
            <h1 class="h3 mb-4 fw-normal text-center">Sign up</h1>
            
            <div class="form-floating mb-2">
                <input name="user" type="username" class="form-control rounded-bottom-0" id="floatingInput" required>
                <label for="floatingInput">Username</label>
            </div>
            
            <div class="form-floating mb-2">
                <input name="pass" type="password" class="form-control" id="floatingPassword" required>
                <label for="floatingPassword">Password</label>
            </div>
            
            <div class="mb-2">
                <input name="profile_image" type="file" class="form-control" accept="image/*" required>
            </div>
            
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
        </form>    
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>


