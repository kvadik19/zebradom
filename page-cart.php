<?php 
/*
	Template Name: Шаблон "Корзина"
*/
?>
<?php get_header()?>
	<?php while(have_posts()) { the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php the_content(); ?>
		</article>

		<?php
		if(false && (comments_open() || '0' != get_comments_number())) {
			comments_template();
		}
		?>
	<?php } ?>
<?php get_footer() ?>
