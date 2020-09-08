<?php get_header()?>
	<h3 class="mb-4"><strong><?php single_cat_title()?></strong></h3>
	<?php if(have_posts()) {?>
		<?php if(category_description()) {?>
			<div class="archive-meta"><?php category_description()?></div>
		<?php }?>
		<ul class="about-links">
			<?php 
			$count_posts = 0;
			while(have_posts()) { the_post();
				$count_posts++;
			?>
				<?php get_template_part('content')?>
			<?php 
			}
			?>
		</ul>
		<div class="text-center">
		<?php if($wp_query->max_num_pages > 1) {?>
				<script>
				var ajaxurl = '<?php site_url()?>/wp-admin/admin-ajax.php';
				var true_posts = '<?php serialize($wp_query->query_vars)?>';
				var class_content = 'col-12';
				var file_content = '';
				var current_page = <?php (get_query_var('paged')) ? get_query_var('paged') : 1?>;
				var max_pages = '<?php $wp_query->max_num_pages?>';
				</script>
				<div class="mb-4">
					<div class="btn btn-success" id="true_loadmore">Загрузить ещё <i class="icon-arrow-down"></i></div>
				</div>
		<?php }?>
		</div>
	<?php 
	} else {
	?>
		<p>Извините, в данной рубрике нет записей.</p>
	<?php 
	}
	?>
<?php get_footer()?>
