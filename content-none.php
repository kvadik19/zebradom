<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
	<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'semicolon' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
<?php elseif ( is_search() ) : ?>
	<p><?php 'Извините, но ничего не найдено. Пожалуйста, попытайтесь снова с другими ключевыми словами.'?></p>
	<?php get_search_form(); ?>
<?php else : ?>
	<p><?php 'Извините, но ничего не найдено.'?></p>
<?php endif; ?>
