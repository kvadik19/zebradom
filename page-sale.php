<?php 
/*
	Template Name: Шаблон "Акции и скидки"
*/
?>
<?php get_header()?>
	<?php while(have_posts()) { the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="text-left mb-4">
				<h2><?php the_title(); ?></h2>
			</header>
			<div class="entry-content">
				<?php the_content(); ?>
				<h4>Товары со скидкой</h4>
				<div class="products">
                    <div class="product-list row">
                    <?php 
                    $products_query = new WP_Query(array(
                        'posts_per_page' => -1,
                        'post_type'      => 'product',
                        'orderby'        => 'date',
						'product_cat'    => 'solutions',
						'meta_query'     => array(
							'relation' => 'OR',
							array( // Simple products type
								'key'           => '_sale_price',
								'value'         => 0,
								'compare'       => '>',
								'type'          => 'numeric'
							),
							array( // Variable products type
								'key'           => '_min_variation_sale_price',
								'value'         => 0,
								'compare'       => '>',
								'type'          => 'numeric'
							)
						)
                    ));

                    $products = (array) $products_query->get_posts();
                    foreach ($products as $key => $product) {
                        $product = (array) $product;
                        $wc_product = new WC_Product($product['ID']);
                        $gallery = [];
                        $thumb = get_post_meta($product['ID'], '_thumbnail_id')[0];
                        if (!empty($thumb)) {
                            $gallery[] = wp_get_attachment_url($thumb);
                        }
                        $gallery_str = get_post_meta($product['ID'], '_product_image_gallery')[0];
                        $gallery_arr = explode(',', $gallery_str);
                        if (!empty($gallery_str)) {
                            foreach ($gallery_arr as $val) {
                                $gallery[] = wp_get_attachment_url($val);
                            }
                        }
                        ?>
                        <div class="col-xl-3 col-lg-4 col-md-3">
                            <div class="product-list-item" data-gallery="<?phphtmlspecialchars(json_encode($gallery))?>">
                                <div class="product-list-item-image">
                                    <?phpget_the_post_thumbnail($product['ID'])?>
                                    <?php 
                                    if($wc_product->is_on_sale()) {
                                    ?>
                                        <img class="sale" src="<?php  bloginfo('template_url') ?>/images/icons/sale.png" alt="">
                                    <?php 
                                    }
                                    ?>
                                </div>
                                <div class="product-list-item-body">
                                    <?php /*<div class="text"><?php$product['post_title']?></div>*/?>
                                    <ul class="list-unstyled">
                                        <li>Изделие: <?phpdo_excerpt($product['post_title'], 3)?></li>
                                        <li>Материал: <?phpget_field('cloth', $product['ID'])->post_title?></li>
                                        <li>Ширина по замеру: <?phpget_field('width', $product['ID'])?> см.</li>
                                        <li>Высота по замеру: <?phpget_field('height', $product['ID'])?> см.</li>
                                        <li>Габаритная ширина:  см.</li>
                                        <li>Габаритная высота:  см.</li>
                                    </ul>
                                    <ul class="list-unstyled">
                                        <li>Ширина ткани: <?phpget_field('width', $product['ID'])?> см.</li>
                                        <li>Высота управления: <?phpget_field('height', $product['ID'])?> см.</li>
                                        <li>Цвет комплектации: Белый</li>
                                        <li>Моторизация: <?phpget_field('control', $product['ID']) == 'electro' ? 'Да' : 'Нет'?></li>
                                        <li>Разворот ткани: Расчет ткани по ширине</li>
                                        <li>Намотка ткани: Прямая</li>
                                    </ul>
                                    <div class="price"><?phpget_post_meta($product['ID'], '_price')[0]?> руб.</div>
                                    <a href="/product-category/solutions/?add-to-cart=3664" data-quantity="1" class="btn btn-sm btn-block btn-product-list product_type_simple add_to_cart_button ajax_add_to_cart" data-product_id="<?php$product['ID']?>" data-product_sku="" aria-label="Добавить &quot;<?php$product['post_title']?>&quot; в корзину" rel="nofollow">В корзину</a>
                                </div>
                            </div>
                        </div>
                        <?php 
                    }
                    ?>
                    </div>
                </div>
			</div>

		</article>

		<?php
		if(false && (comments_open() || '0' != get_comments_number())) {
			comments_template();
		}
		?>
	<?php } ?>
<?php get_footer()?>