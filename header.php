<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset')?>">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title><?php wp_title('«', true, 'right')?> <?php bloginfo('name')?></title>
		<?php wp_head() ?>
	</head>
	<body <?php body_class('layout')?>>

<?php
	$post_id = 6869;
	$phone_number = get_field('phone_number', $post_id);
	$phone_clean = preg_replace("/[-+)(]/", "", $phone_number);
	$href_viber = "viber://chat?number=+$phone_clean";
	$expand_button = '';
	if (check_mobile_device()) {
		$href_viber = "viber://add?number=$phone_clean";
		$expand_button = '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" '.
						'aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">'.
						'<span class="navbar-toggler-icon"></span><button>';
	}
	include( 'bar-top.php' );
?>
	<section class="content">
