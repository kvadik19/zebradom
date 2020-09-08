<article id="post-<?php the_ID(); ?>" <?php post_class('clear'); ?>>
	<header>
		<h2><?php the_title(); ?></h4>
	</header>
	<div class="entry-content">
		<?php the_content(); ?>
	</div>
	<div class="clearfix"></div>
</article>