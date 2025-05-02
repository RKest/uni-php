<?php

$sign_in_view = function($znum) {
    $sign_up_uri = "/$znum/view/sign_up";
    $sign_in_uri = "/$znum/api/sign_in";
    require __DIR__.'/../templates/sign_in.php';
};

$sign_up_view = function($znum) {
    $sign_up_uri = "/$znum/api/sign_up";
    require __DIR__.'/../templates/sign_up.php';
};

$admin_view = function($znum) {
    $admin_uri = "/$znum/api/admin";
    $sign_in_uri = "/$znum/view/sign_in";
    require __DIR__.'/../templates/admin.php';
};

?>
