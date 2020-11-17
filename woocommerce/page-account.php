<?php 
/*
	Template Name: Шаблон "Личный кабинет"
*/
get_header();
wp_enqueue_script('jquery', '//code.jquery.com/jquery-3.4.1.min.js', false, false, true);
?>
<div class="page-set">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-content">
			<?php the_content(); ?>
		</div>
	</article>
</div>
<?php get_footer() ?>
