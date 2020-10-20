<?php 
/*
	Template Name: Шаблон "Корзина"
*/
get_header();
?>
<div class="page-set">
<?php while(have_posts()) { 
	the_post();
	echo the_content();
	if (false && (comments_open() || '0' != get_comments_number())) {
		echo comments_template();
	}
} ?>
</div><!-- page-set -->
<?php get_footer() ?>
