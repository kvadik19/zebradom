<article id="post-<?php the_ID(); ?>" <?php post_class('clear'); ?>>
	<p><a href="<?php get_category_link(get_category_by_slug('info')->term_id)?>">&larr; Назад в информацию</a></p>
	<header>
		<h2><?php the_title(); ?></h4>
	</header>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
</article>
