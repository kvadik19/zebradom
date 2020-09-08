<?php echo get_header();
/*if (count($_POST) > 0) {
	print_r($_POST);
}*/
if (is_home()) {
// //	$type = $_GET['type'] != 'zebra' || !isset($_GET['type']) ? 'classic' : 'zebra';
// 	$type = 'classic>';
// 	if (isset($_GET['type']) ) $type = 'zebra';
	$type = 'zebra';
	if (isset($_GET['type']) ) $type = $_GET['type'];

?>
	<h1>index</h1>
	<form action="/" method="POST">
	<?php include('builder.php') ?>

	<div class="shop flex-wrap flex-xl-nowrap">
			<div class="shop-col shop-info">
				<h3 class="text-nowrap">Скидка 5%</h3>
				<p>Поделись своей покупкой в соцсетях и получите скидку</p>
				<ul class="list-inline">
					<li class="list-inline-item"></li>
				</ul>
			</div>
			<div class="shop-col shop-params">
				<h4 class="shop-params-title">
					Введите размеры
					<i class="icon icon-info" data-info-target="size"></i>
				</h4>
				<div class="shop-params-body d-flex flex-column flex-md-row">
					<div class="shop-params-col">
						<div class="form-group">
							<label>Ширина:</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text js-width-range">Min ... см<br>Max ... см</span>
								</div>
								<input type="text" class="form-control" name="size_width" value="115">
								<div class="input-group-append">
									<span class="input-group-text">см</span>
								</div>
							</div>
						</div>
					</div>
					<div class="shop-params-col">
						<div class="form-group">
							<label>Высота:</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text js-height-range">Min ... см<br>Max ... см</span>
								</div>
								<input type="text" class="form-control" name="size_height" value="115">
								<div class="input-group-append">
									<span class="input-group-text">см</span>
								</div>
							</div>
						</div>
					</div>
					<div class="shop-params-col">
						<div class="form-group text-md-center">
							<label>Количество:</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<button class="btn btn-link js-shop-count-down"
											data-target="shop-count-value"
											type="button"><i class="icon icon-arrow-left"></i></button>
								</div>
								<input type="text" class="form-control" value="1" name="count" id="shop-count-value">
								<div class="input-group-append">
									<button class="btn btn-link js-shop-count-up"
											data-target="shop-count-value"
											type="button"><i class="icon icon-arrow-right"></i></button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="shop-params-footer">
					<p class="sizes-error js-sizes-error"></p>
					<p>
						<strong>
							Как сделать замер:
							<a href="#">Видео</a>
							<a href="#">Фото</a>
						</strong>
					</p>
					<p>
						<!-- <strong><a href="#">Схема системы</a></strong>, -->
						<strong><a class="btn btn-success" href="#" data-toggle="modal" data-target="#master">Вызвать замерщика</a></strong>
					</p>
				</div>
			</div>
			<div class="shop-col shop-order">
				<div class="row">
					<div class="col-sm-6 shop-order-item d-flex flex-column justify-content-between">
						<ul class="list-unstyled">
							<li><strong>Ткань:</strong>
								<span class="js-order-item-name">...</span></li>
							<li><strong>Цена:</strong>
								<span class="js-order-item-price">...</span> руб.
							</li>
						</ul>
						<button type="button"
								class="btn btn-lg btn-shop-order btn-danger mt-2 text-nowrap"
								data-infom-target="order">Добавить в корзину
						</button>
					</div>
					<div class="col-sm-6 shop-order-cart d-flex flex-column justify-content-between">
						<div class="shop-order-cart-count text-nowrap">Корзина:
							<span class="js-order-cart-count"><?php WC()->instance()->cart->cart_contents_count?></span> товаров
						</div>
						<div class="shop-order-cart-price text-nowrap">Сумма
							<span class="js-order-cart-price" data-sum="<?php WC()->cart->cart_contents_total?>"><?php ceil(WC()->cart->cart_contents_total)?></span> руб.
						</div>
						<div class="shop-order-cart-sale text-nowrap">Скидка
							<span class="js-order-cart-sale">0</span> руб. <i class="icon icon-info"
																			  data-info-target="sale"></i></div>
						<a href="/cart">
							<button type="button" class="btn btn-lg btn-shop-cart btn-success mt-2 text-nowrap">Корзина
							</button>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="modals">
			<div class="info" data-info="clothes">
				<div class="info-content">
					<div class="info-header">
						<button type="button" class="close" data-dismiss="info" aria-label="Close">
							Закрыть <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="info-body">
						<ul class="cloth-list cloth-list-full js-cloth-list">
						</ul>
					</div>
				</div>
			</div>
			<div class="info info-order" data-info="order">
				<div class="info-content">
					<div class="info-header">
						<button type="button" class="close" data-dismiss="info" aria-label="Close">
							Закрыть <span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="info-body">
						<div class="row">
							<div class="col-sm-5 info-order-js-img">
								<div class="text-center">
									<img class="img-fluid"
										 src="<?php echo bloginfo('template_url') ?>/images/example/order-pt.jpg">
									<img class="img-fluid"
										 src="<?php echo bloginfo('template_url') ?>/images/example/order-pb.jpg">
								</div>
							</div>
							<div class="col-sm-6">
								<h4 class="text-uppercase">Подтвердите параметры выбранного вами изделия</h4>

								<ul class="list-unstyled">
									<li>Изделие: <span class="js-order-confirm-model"></span></li>
									<li>Материал: <span class="js-order-confirm-cloth"></span></li>
									<li>Артикул: <span class="js-order-confirm-cloth-sku"></span></li>
									<li>Цвет: <span class="js-order-confirm-cloth-color"></span></li>
									<li>Ширина по замеру: <span class="js-order-confirm-width"></span> см.</li>
									<li>Высота по замеру: <span class="js-order-confirm-height"></span> см.</li>
									<li>Габаритная ширина: <span class="js-order-confirm-width-gb"></span> см.</li>
									<li>Габаритная высота: <span class="js-order-confirm-height-gb"></span> см.</li>
									<li>Ширина ткани: <span class="js-order-confirm-width"></span> см.</li>
									<li>Высота ткани: <span class="js-order-confirm-height"></span> см.</li>
									<li>Высота управления: <span class="js-order-confirm-height-upr"></span> см.</li>
									<li>Цвет комплектации: <span>белый</span></li>
									<li>Моторизация: <span class="js-order-confirm-electro"></span></li>
									<li>Разворот ткани: <span>Расчет ткани по ширине</span></li>
									<li>Намотка ткани: <span>Прямая</span></li>
								</ul>
								<p class="help-block">* точный оттенок материала определяется по каталогу. Обращаем ваше
									внимание, что данные вашего предварительного заказа не являются публичной
									офертой.</p>
								<br>
								<ul class="list-unstyled">
									<li><strong class="text-muted">Цена</strong>: <span class="js-order-confirm-price">...</span>
										руб.
									</li>
									<li><span>без доп.услуг (замер, доставка, монтаж)</span></li>
									<li>Кол-во: <span class="js-order-confirm-count">...</span> шт.</li>
								</ul>
								<div class="form-check mb-2">
									<input class="form-check-input" type="checkbox" value="" id="all-right" required>
									<label class="form-check-label" for="all-right">
										Я проверил(а), всё верно
									</label>
								</div>
								<div class="row">
									<div class="col-sm-6">
										<button type="button"
												class="btn btn-lg btn-block btn-success"
												data-dismiss="info">Вернуться
										</button>
									</div>
									<div class="col-sm-6">
										<button type="submit" class="btn btn-lg btn-block btn-danger btn-order">Добавить
											в корзину
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	<script>
		let activeCloth = <?php echo isset($_GET['cloth']) ? $_GET['cloth'] : 1765;?>
	</script>
<?php  } ?>
<?php
/*$dir = get_template_directory().'/images/builder/models/furniture/classic';
if (is_dir($dir)) {
	$files = scandir($dir);
	foreach($files as $key => $value){
		$path = realpath($dir.DIRECTORY_SEPARATOR.$value);
		if(!is_dir($path)) {
			$new_name = explode('-', $value);
			if(count($new_name) > 3) {
				unset($new_name[0]);
				unset($new_name[count($new_name)]);
				$new_arr = [ $new_name[count($new_name)] ];
				unset($new_name[count($new_name)]);
				foreach ($new_name as $item) {
					$new_arr[] = $item;
				}
				echo $dir.DIRECTORY_SEPARATOR.$value.'<br>';
				echo $dir.DIRECTORY_SEPARATOR.implode('-', $new_arr).".png<br>";
				rename($dir.DIRECTORY_SEPARATOR.$value, $dir.DIRECTORY_SEPARATOR.implode('-', $new_arr).".png");
			}
		}
	}
}*/
?>
<?php  /*$products_query = new WP_Query(array(
		'posts_per_page' => -1,
		'post_type'	  => 'product',
		'order'		  => 'ASC',
		'orderby'		=> 'ID',
		'product_cat'	=> 'cloth',
		'nopaging' => true,
		//'post__in' => [ 435 ],
		'meta_query'	 => array(
			'relation' => 'AND',
			array(
				'key'	 => 'вид_модели',
				'value'   => $_POST['type'],
				'compare' => '=',
			)
		),
	));
	var_dump($products_query->get_posts());

	$results = $wpdb->get_results( "SELECT wp_posts.* FROM wp_posts LEFT JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id) INNER JOIN wp_postmeta ON ( wp_posts.ID = wp_postmeta.post_id ) WHERE 1=1 AND ( wp_term_relationships.term_taxonomy_id IN (19) ) AND ( ( wp_postmeta.meta_key = 'вид_модели' AND wp_postmeta.meta_value = '' ) ) AND wp_posts.post_type = 'product' AND (wp_posts.post_status = 'publish' OR wp_posts.post_status = 'acf-disabled' OR wp_posts.post_status = 'wc-delivering' OR wp_posts.post_status = 'private') GROUP BY wp_posts.ID ORDER BY wp_posts.ID ASC" );

	var_dump($results);*/


	?>
<?php echo get_footer() ?>
