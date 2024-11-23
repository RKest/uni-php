<?php

function session_nav_fn_impl($znum) {
    echo "
        <div class='me-2 nav-item'>
            <a class='nav-link' href='/$znum/api/sign_out'>Logout<i class='fa fa-sign-out'></i></a>
        </div>
        <div>
            <img height='50' width='50' src='/$znum/api/profile_image' class='img-fluid rounded' alt='Profile'>
        </div>
    ";
};

$content_view = function($file) {
    return function($znum) use ($file) {
        session_start();
        if (!isset($_SESSION[$znum])) {
            header("Location: /$znum/view/sign_in");
            exit();
        }

        $session_nav_fn = function() use ($znum) {
            session_nav_fn_impl($znum);
        };

        $content_fn = function() use ($znum, $file) {
            require __DIR__."/../../tasks/$znum/$file";
        };

        require __DIR__."/../templates/content.php";
    };
};

?>
