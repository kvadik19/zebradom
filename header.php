<!doctype html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset')?>">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<?php echo "\t\t",'<script type="text/javascript">var plugs=\'',plugins_url(),"';</script>\n"; ?>

		<?php wp_head() ?>
	</head>
	<body <?php body_class('layout')?>>

<?php
// 	$post_id = url_to_postid('/glavnaja');
	$post_id = get_option( 'page_on_front');

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
	global $parentURL;
	$point = get_post(null, 'OBJECT');
	$crumb = '';
	if ( !(is_home() || is_front_page()) && $point->post_title ) {
		$crumb = '<a href="/">Главная</a>';
		if ( $parentURL ) {
			$crumb .= '<a href="'.$parentURL.'">'.get_the_title( url_to_postid($parentURL) ).'</a>';
		}
		$crumb .= '<span>'.$point->post_title.'<span>';
	} else {
		$crumb = '';
	}
?>
	<div id="breadcrumbs" class="page-set"><?php echo $crumb ?></div>
	<section class="content">
