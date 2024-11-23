<?php

require_once __DIR__.'/router.php';

get('/', 'main-nav.php');

require_once __DIR__.'/z_common/api/session.php';

post('/$znum/api/sign_in', $post_sign_in);
post('/$znum/api/sign_up', $post_sign_up);
get('/$znum/api/sign_out', $get_sign_out);
get('/$znum/api/profile_image', $get_profile_image);

require_once __DIR__.'/z_common/view/session.php';
get('/$znum/view/sign_in', $sign_in_view);
get('/$znum/view/sign_up', $sign_up_view);

require_once __DIR__.'/z_common/view/content.php';
get('/$znum/$page', function ($znum, $page) {
	global $content_view;
	$content_view("$page.php")($znum);
});
