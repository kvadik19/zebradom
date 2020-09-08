<?php 
/*
	Template Name: Шаблон "Готовые решения"
*/
?>
<?php get_header()?>
	<?php while( have_posts() ) { the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="entry-content">
				<?php the_content(); ?>
				<h4>Готовые решения</h4>
				<div class="products">
					<div class="product-list row">
					<?php 
					$products_query = new WP_Query( 
											[
											'posts_per_page' => -1,
											'post_type'	  => 'product',
											'orderby'		=> 'date',
											'product_cat'	=> 'solutions',
											] );

					$products = (array) $products_query->get_posts();
					while ( $products_query->have_posts() ) : 
						$products_query->the_post(); global $product; 

						$gallery = [];
						$thumb = get_post_meta($product->get_id(), '_thumbnail_id');
						if (!empty($thumb[0])) {
							$gallery[] = wp_get_attachment_url($thumb[0]);
						}
						$gallery_str = get_post_meta($product->get_id(), '_product_image_gallery');
						if (!empty($gallery_str[0])) {
							$gallery_arr = explode(',', $gallery_str[0]);
							foreach ($gallery_arr as $val) {
								$gallery[] = wp_get_attachment_url($val);
							}
						}
						?>
						<div class="col-xl-3 col-lg-4 col-md-3">
							<div class="product-list-item" data-gallery="<?php htmlspecialchars(json_encode($gallery)) ?>">
								<div class="product-list-item-image">
									<?php echo get_the_post_thumbnail($product->get_id());

									if ($product->is_on_sale()) {
									?>
										<img class="sale" src="<?php  bloginfo('template_url') ?>/images/icons/sale.png" alt="">
									<?php 
									}
									?>
								</div>
								<div class="product-list-item-body">
									<?php /*<div class="text"><?php$product['post_title']?></div>*/?>
									<ul class="list-unstyled">
										<li>Изделие: <?php  echo $product->get_name() ?></li>
										<li>Материал: <?php echo get_field('cloth', $product->get_id())->post_title?></li>
										<li>Ширина по замеру: <?php echo get_field('width', $product->get_id())?> см.</li>
										<li>Высота по замеру: <?php echo get_field('height', $product->get_id())?> см.</li>
										<li>Габаритная ширина:  см.</li>
										<li>Габаритная высота:  см.</li>
									</ul>
									<ul class="list-unstyled">
										<li>Ширина ткани: <?php echo get_field('width', $product->get_id())?> см.</li>
										<li>Высота управления: <?php echo get_field('height', $product->get_id())?> см.</li>
										<li>Цвет комплектации: Белый</li>
										<li>Моторизация: <?php echo get_field('control', $product->get_id()) == 'electro' ? 'Да' : 'Нет'?></li>
										<li>Разворот ткани: Расчет ткани по ширине</li>
										<li>Намотка ткани: Прямая</li>
									</ul>
									<?php 
										echo $product->get_price_html(); 
										woocommerce_template_single_add_to_cart();		//  $loop->post, $product 
									?>  
									</div>
							</div>
						</div>
						<?php 
						/*$products[$key]['vendor_code'] = get_post_meta($products[$key]['ID'], '_sku');
						$products[$key]['preview'] = get_the_post_thumbnail($products[$key]['ID'], "thumbnail-73x73");
						$products[$key]['fields'] = get_fields($products[$key]['ID']);
						$products[$key]['texture_lvt'] = wp_get_attachment_url($products[$key]['fields']['изображение_lvt']);
						$products[$key]['texture_mini'] = wp_get_attachment_url($products[$key]['fields']['изображение_mini']);
						$products[$key]['texture_uni'] = wp_get_attachment_url($products[$key]['fields']['изображение_uni']);
						$gallery = [];
						$thumb = get_post_meta($products[$key]['ID'], '_thumbnail_id')[0];
						if (!empty($thumb)) {
							$gallery[] = wp_get_attachment_url($thumb);
						}
						$gallery_str = get_post_meta($products[$key]['ID'], '_product_image_gallery')[0];
						$gallery_arr = explode(',', $gallery_str);
						if (!empty($gallery_str)) {
							foreach ($gallery_arr as $val) {
								$gallery[] = wp_get_attachment_url($val);
							}
						}
						$products[$key]['gallery'] = $gallery;*/

					endwhile;
					wp_reset_query(); 
					?>
				</div>
			</div>
		</article>

		<?php
		if(false && (comments_open() || '0' != get_comments_number())) {
			comments_template();
		}
		?>
	<?php } ?>
	<div style="display:none;">
	<?php 
		$loop = new WP_Query( array(
			'posts_per_page' => -1,
			'post_type'	  => 'product',
			'orderby'		=> 'date',
			'product_cat'	=> 'solutions',
		));
		while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>	
				<?php 
					echo $product->get_price_html(); 
					woocommerce_template_single_add_to_cart( );		// $loop->post, $product 
				?>	
	<?php 
		endwhile;
		wp_reset_query(); 
	?>
</div>

<?php get_footer()?>
