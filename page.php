<?php
	get_header();
	while(have_posts()) {
		the_post();
		get_template_part('content', 'page');
		if(false && (comments_open() || '0' != get_comments_number())) {
			comments_template();
		}
	}
	get_footer()
?>
