<?php get_header()?>
	<?php while(have_posts()) { the_post(); ?>
		<?php get_template_part('content', 'single'); ?>
		<?php
		if(false && (comments_open() || '0' != get_comments_number())) {
			comments_template();
		}
		?>
	<?php } ?>
<?php get_footer()?>
