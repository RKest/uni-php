<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ind</title>
    <script src="https://unpkg.com/htmx.org@2.0.3"></script>
    <script src="https://unpkg.com/htmx-ext-sse@2.2.2"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container">
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="nav-link" href='/'>Home</a>
                </div>
                <div class="navbar-nav me-auto mb-2 mb-lg-0">
                    <a class="nav-link" href='<?php echo "/$znum/home" ?>'>Nav</a>
                </div>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav me-auto mb-2 mb-lg-0"></div>
		<?php $session_nav_fn(); ?>
            </div>
        </div>
    </nav>

    <?php $content_fn(); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <footer class="page-footer mt-auto bg-light border-primary">   
        <div class="container-fluid">
            Footer content
        </div>
    </footer>	
</body>
</html>
