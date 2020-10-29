<?php
add_theme_support('post-thumbnails');
add_theme_support( 'title-tag' );

add_image_size('zebradom-cloth73x73', 73, 73, true);
add_image_size('zebradom-cloth300x345', 300, 345, true);

$modelKeys = [
	'type' => [
		'name' => [ 'zebra' => 'зебра',
					'classic' => 'классика'
					],
		'title' => [ 'зебра' => 'zebra', 
					'классика' => 'classic'
					]
			],
	'mount' => [ 
		'name' => [ 'flap' => 'на створку',
					'open' => 'на проем'
					],
		'title' => [ 'на створку' => 'flap',
					'на проем' => 'open'
					]
			],
	'equip' => [
		'name' => [ 'inbox' => 'в коробе',
					'default' => 'без короба'
					],
		'title' => [ 'в коробе' => 'inbox',
					'без короба' => 'default'
					]
			],
	'control' => [
		'name' => [ 'man-right' => 'справа',
					'man-left' => 'cлева',
					'electro' => 'дистанционное'
					],
		'title' => [ 'справа' => 'man-right',
					'cлева' => 'man-left',
					'дистанционное' => 'electro'
					]
			]
	];

$tmpl_uri = get_template_directory_uri();
$def_links = [
		'global' => [
			'style' => [
					'font-style' => '//fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap&subset=cyrillic',
					'bootstrap' => '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css',
					'font-awesome' => "$tmpl_uri/css/font-awesome.css",
					'photoswipe' => "$tmpl_uri/vendor/photoswipe/photoswipe.css",
					'photoswipe-skin' => "$tmpl_uri/vendor/photoswipe/default-skin/default-skin.css",
					'sprites' => "$tmpl_uri/css/sprites.css",
					'app' => "$tmpl_uri/css/app.css",
					'style' => "$tmpl_uri/style.css"
				],
			'script' => [
					['jquery', '//code.jquery.com/jquery-3.4.1.min.js', [], false, true],
					['popper', '//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', ['jquery'], false, true],
					['bootstrap', '//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', ['popper'], false, true],
					['photoswipe-zebra', "$tmpl_uri/js/photoswipe-ui-zebra.min.js", ['jquery','photoswipe'], false, true],
					['app', "$tmpl_uri/js/app.js", ['jquery'], false, true]
				]
		],
		'page-clients.php' => [
			'style' => [
					'lightgallery' => "$tmpl_uri/css/lightgallery.css",
				],
			'script' => [
					['true_loadmore', "$tmpl_uri/js/loadmore.js", ['jquery']],
					['lightgallery', "$tmpl_uri/js/lightgallery.min.js", ['jquery']],
					['slick', "$tmpl_uri/js/slick.min.js", ['jquery']],
				]
		],
		'page.php' => [
			'style' => [
					'farbtastic-picker' => "$tmpl_uri/js/farbtastic/farbtastic.css",
					'builder' => "$tmpl_uri/css/builder.css",
					'classic-pck' => "$tmpl_uri/css/classic.min.css",
				],
			'script' => [
					['farbtastic-picker', "$tmpl_uri/js/farbtastic/farbtastic.js", ['jquery'], false, true],
					['jq-zoom', "$tmpl_uri/js/zoom.js", ['jquery'], false, true],
					['threejs', "$tmpl_uri/js/three.min.js", [], false, true],
					['builder', "$tmpl_uri/js/builder.js", [ 'jquery',
															'jq-zoom',
															'threejs',
															'app' ], false, true]
				]
		],
		'page-clients.php' => [
			'style' => [
					'page-clients' => "$tmpl_uri/css/page-clients.css",
					'page-solutions' => "$tmpl_uri/css/page-resh.css",
					'slick' => "$tmpl_uri/css/slick.css",
					'slick-theme' => "$tmpl_uri/css/slick-theme.css",
				],
			'script' => [
					['clients', "$tmpl_uri/js/clients.js", ['jquery'], false, true]
				]
		],
		'page-dealers.php' => [
			'style' => [
				'page-dealers' => "$tmpl_uri/css/page-opt.css",
			],
		],
		'page-solutions.php' => [
			'style' => [
					'page-solutions' => "$tmpl_uri/css/page-resh.css",
				],
			'script' => [
					['solutions', "$tmpl_uri/js/solutions.js", ['jquery'], false, true]
				]
		],
		'page-sale.php' => [
			'style' => [
				'page-solutions' => "$tmpl_uri/css/page-resh.css",
			],
		],
		'page-cart.php' => [
			'style' => [
					'page-wooc' => "$tmpl_uri/css/woocom.css",
				],
			'script' => [
					['cart', "$tmpl_uri/js/cart.js", ['jquery'], false, true]
				]
		],
		'page-order.php' => [
			'style' => [
					'page-wooc' => "$tmpl_uri/css/woocom.css",
				],
			'script' => [
					['order', "$tmpl_uri/js/order.js", ['jquery'], false, true]
				]
		],
	];

function enqueue_src() {
	global $def_links;
	$page_template = get_page_template();
	$page_template = substr($page_template, strrpos($page_template, '/')+1);

log_write("LOAD RESOURCES FOR: $page_template IN ".get_stylesheet_directory() );
	$verCSS = filemtime( get_stylesheet_directory().'/css' );
	$verJS = filemtime( get_stylesheet_directory().'/js' );
	wp_deregister_script('jquery');

	foreach ( $def_links['global']['style'] as $key => $def ) {
		wp_enqueue_style($key, $def, [], $verCSS);
	}
	foreach ( $def_links['global']['script'] as $def ) {
		wp_enqueue_script( ...$def );
	}

	// Apply resources
	if ( array_key_exists( $page_template, $def_links) ) {
		if ( array_key_exists( 'style', $def_links[$page_template]) ) {
			foreach ( $def_links[$page_template]['style'] as $key => $def ) {
				wp_enqueue_style($key, $def, [], $verCSS);
			}
		}
		if ( array_key_exists( 'script', $def_links[$page_template]) ) {
			foreach ( $def_links[$page_template]['script'] as $def ) {
				$def[1] .= "?$verJS";
				wp_enqueue_script( ...$def );
			}
		}
	}
}
add_action('wp_enqueue_scripts', 'enqueue_src');

function true_customizer_init($wp_customize) {
	$true_transport = 'postMessage';
	$wp_customize->add_section(
		'true_desc_index',
		array(
			'title'	 => 'Описания на главной',
			'priority'  => 10,
			'description' => ''
		)
	);
	$wp_customize->add_setting(
		'true_desc_index_mount',
		array(
			'default'			=> '',
			'sanitize_callback'  => 'true_sanitize',
		)
	);
	$wp_customize->add_control(
		'true_desc_index_mount',
		array(
			'section'  => 'true_desc_index',
			'label'	=> 'Описание "Крепление"',
			'type'	 => 'textarea'
		)
	);
	$wp_customize->add_setting(
		'true_desc_index_control',
		array(
			'default'			=> '',
			'sanitize_callback'  => 'true_sanitize',
		)
	);
	$wp_customize->add_control(
		'true_desc_index_control',
		array(
			'section'  => 'true_desc_index',
			'label'	=> 'Описание "Управление"',
			'type'	 => 'textarea'
		)
	);
	$wp_customize->add_setting(
		'true_desc_index_equip',
		array(
			'default'			=> '',
			'sanitize_callback'  => 'true_sanitize',
		)
	);
	$wp_customize->add_control(
		'true_desc_index_equip',
		array(
			'section'  => 'true_desc_index',
			'label'	=> 'Описание "Комплектация"',
			'type'	 => 'textarea'
		)
	);
	$wp_customize->add_setting(
		'true_desc_index_type',
		array(
			'default'			=> '',
			'sanitize_callback'  => 'true_sanitize',
		)
	);
	$wp_customize->add_control(
		'true_desc_index_type',
		array(
			'section'  => 'true_desc_index',
			'label'	=> 'Описание "Тип штор"',
			'type'	 => 'textarea'
		)
	);
	$wp_customize->add_setting(
		'true_desc_index_opacity',
		array(
			'default'			=> '',
			'sanitize_callback'  => 'true_sanitize',
		)
	);
	$wp_customize->add_control(
		'true_desc_index_opacity',
		array(
			'section'  => 'true_desc_index',
			'label'	=> 'Описание "Прозрачность"',
			'type'	 => 'textarea'
		)
	);
	$wp_customize->add_setting(
		'true_desc_index_size',
		array(
			'default'			=> '',
			'sanitize_callback'  => 'true_sanitize',
		)
	);
	$wp_customize->add_control(
		'true_desc_index_size',
		array(
			'section'  => 'true_desc_index',
			'label'	=> 'Описание "Размеры"',
			'type'	 => 'textarea'
		)
	);
	$wp_customize->add_setting(
		'true_desc_index_sale',
		array(
			'default'			=> '',
			'sanitize_callback'  => 'true_sanitize',
		)
	);
	$wp_customize->add_control(
		'true_desc_index_sale',
		array(
			'section'  => 'true_desc_index',
			'label'	=> 'Описание "Скидка"',
			'type'	 => 'textarea'
		)
	);
}
add_action('customize_register', 'true_customizer_init');

function log_write( $logstr ) {
	$path = ABSPATH;
	if ( !file_exists("$path/log") ) {
		mkdir("$path/log");
	}
	$name = get_template_directory();
	$name = substr($name, strrpos($name, '/')+1);
	$log = fopen("$path/log/$name.log", 'a');
	fwrite( $log, date('Y-m-d H:i:s', time())."\t$logstr\n" );
	fclose($log);
}

function plural_str( $num, array $forms ) {
	$group = [ '1', '234', '567890'];
	$num = ( strlen($num) > 2 ) ? substr( $num, strlen($num)-2 ) : $num;		# Get only last 2 digits
	$num = ( $num > 10 && $num < 15 ) ? 5 : $num;		# Correct 11...14 form
	$dig = substr( $num, strlen($num)-1 );

	$cnt = 0;
	foreach ( $group as $digtest ) {
		if ( preg_match( '/'.$dig.'/', $digtest) ) {
			break ;
		}
		$cnt++;
	}
	if ( $cnt > count($forms)-1 ) {
		$cnt = count($forms)-1;
	}
	return $forms[$cnt];
}

function true_sanitize($value) {
	return stripcslashes($value);
}

function true_customizer_live() {
	wp_enqueue_script('true-theme-customizer', get_stylesheet_directory_uri().'/js/theme-customizer.js', array(
		'jquery',
		'customize-preview'
	), null, true);
}

function get_most_viewed($args = '') {
	parse_str($args, $i);
	$num = isset($i['num']) ? $i['num'] : 10;
	$key = isset($i['key']) ? $i['key'] : 'views';
	$order = isset($i['order']) ? 'ASC' : 'DESC';
	$cache = isset($i['cache']) ? 1 : 0;
	$days = isset($i['days']) ? (int) $i['days'] : 0;
	$echo = isset($i['echo']) ? 0 : 1;
	$format = isset($i['format']) ? stripslashes($i['format']) : 0;
	global $wpdb, $post;
	$cur_postID = $post->ID;
	if ($cache) {
		$cache_key = (string) md5(__FUNCTION__.serialize($args));
		if ($cache_out = wp_cache_get($cache_key)) { //получаем и отдаем кеш если он есть
			if ($echo) {
				return print($cache_out);
			} else {
				return $cache_out;
			}
		}
	}
	if ($days) {
		$AND_days = "AND post_date > CURDATE() - INTERVAL $days DAY";
		if (strlen($days) == 4) {
			$AND_days = "AND YEAR(post_date)=".$days;
		}
	}
	$sql = "SELECT p.ID, p.post_title, p.post_date, p.guid, p.comment_count, (pm.meta_value+0) AS views
	FROM $wpdb->posts p
		LEFT JOIN $wpdb->postmeta pm ON(pm.post_id = p.ID)
	WHERE pm.meta_key = '$key' $AND_days
		AND p.post_type = 'post'
		AND p.post_status = 'publish'
	ORDER BY views $order LIMIT $num";
	$results = $wpdb->get_results($sql);
	if (!$results) {
		return false;
	}
	$out = '';
	preg_match('!{date:(.*?)}!', $format, $date_m);
	$x = 'li2';
	foreach ($results as $pst) {
		$x == 'li1' ? $x = 'li2' : $x = 'li1';
		if ((int) $pst->ID == (int) $cur_postID) {
			$x .= " current-item";
		}
		$Title = $pst->post_title;
		$a1 = "<a href='".get_permalink($pst->ID)."' title='{$pst->views} просмотров: $Title'>";
		$a2 = "</a>";
		$comments = $pst->comment_count;
		$views = $pst->views;
		if ($format) {
			$date = apply_filters('the_time', mysql2date($date_m[1], $pst->post_date));
			$Sformat = str_replace($date_m[0], $date, $format);
			$Sformat = str_replace(array(
				'{a}',
				'{title}',
				'{/a}',
				'{comments}',
				'{views}'
			), array(
				$a1,
				$Title,
				$a2,
				$comments,
				$views
			), $Sformat);
		} else {
			$Sformat = $a1.$Title.$a2;
		}
		$out .= "<li class='$x'>$Sformat</li>";
	}
	if ($cache) {
		wp_cache_add($cache_key, $out);
	}
	if ($echo) {
		return print $out;
	} else {
		return $out;
	}
}

add_action('after_setup_theme', function () {
									register_nav_menus(array(
										'main_menu'	=> __('Primary menu', 'crea'),
										'sidebar_menu' => __('Sidebar menu', 'crea'),
										'foot_menu'	=> __('Footer menu', 'crea'),
									));
								});

add_action('customize_preview_init', 'true_customizer_live');

// require_once('wp-bootstrap-navwalker.php');
// require_once('wp-bootstrap-footerwalker.php');

function true_load_posts() {
	$file = $_POST['file_content'];
	$class = $_POST['class_content'];
	$args = unserialize(stripslashes($_POST['query']));
	$args['paged'] = $_POST['page'] + 1;
	$args['post_status'] = 'publish';
	query_posts($args);
	if (have_posts()) {
		while (have_posts()) {
			the_post();
			?>
			<div class="<?php $class ?>">
				<?php
				get_template_part('content'.$file);
				?>
			</div>
			<?php
		}
	}
	die();
}

add_action('wp_ajax_loadmore', 'true_load_posts');
add_action('wp_ajax_nopriv_loadmore', 'true_load_posts');

//Views
function get_post_views($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if ($count == '') {
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0";
	}
	return $count;
}

function set_post_views($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if ($count == '') {
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	} else {
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}

add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views', 5, 2);
function posts_column_views($defaults)
{
	$defaults['post_views'] = __('Просмотры');
	return $defaults;
}

function posts_custom_column_views($column_name, $id) {
	if ($column_name === 'post_views') {
		echo get_post_views(get_the_ID());
	}
}

add_filter('post_gallery', 'gallery_list_client', 10, 2);
function gallery_list_client($output, $attr) {
	$ids_arr = explode(',', $attr['ids']);
	$ids_arr = array_map('trim', $ids_arr);
	$pictures = get_posts(array(
		'posts_per_page' => -1,
		'post__in'	   => $ids_arr,
		'post_type'	  => 'attachment',
		'orderby'		=> 'post__in',
	));
	if (!$pictures) {
		return 'Запрос вернул пустой результат.';
	}

	$out = '<ul class="client-list-org">';
	foreach ($pictures as $pic) {
		$src = $pic->guid;
		$t = esc_attr($pic->post_title);
		$title = ($t && false === strpos($src, $t)) ? $t : '';
		$caption = ($pic->post_excerpt != '' ? $pic->post_excerpt : $title);
		$out .= '
		<li class="client-list-item">
			<a href="'.$caption.'"><img src="'.$src.'" ></a>
		</li>';
	}
	$out .= '</ul>';
	return $out;
}

//ajax
add_action('wp_ajax_addOrder', 'add_order');
add_action('wp_ajax_nopriv_addOrder', 'add_order');
function add_order() {
	$equip = $_POST['equip'];
	$control = $_POST['control'];
	$mount = $_POST['mount'];
	$model = $_POST['model'];
	$type = $_POST['type'];
	$cloth_id = $_POST['cloth'];
	$width = $_POST['width'];
	$height = $_POST['height'];
	$count = $_POST['count'];
	
	$category = get_field('категория', $cloth_id);
	$ret = [ "status" => "fail" ];
	if ($category) {
		$price = calc_price($model, $category, $equip, $width, $height, $control == 'electro');
		if ( $price['is_real'] ) {
			$product_id = add_new_user_sol($model.' '.$width.'x'.$height, $type, $equip, $control, $mount, $cloth_id,
				$width, $height, $price['is_guarantee'], $price['price']);
			WC()->cart->add_to_cart($product_id, $count);
			$cart_content = [];
			$woocart = WC()->cart->cart_contents;
			foreach ( $woocart as $item) {		// Lite version of cart
				array_push( $cart_content, ['ID' => $item['product_id'], 'count' => $item['quantity'], 'price' => $item['line_total']]);
			}
			$ret = [ 'status' => 'success', 
					'product_id' => $product_id,
					'cloth_id' => $cloth_id,
					'type' => $type, 
					'count' => $count, 
					'price' => $price["price"], 
					'cart' => $cart_content,
				];
		}
	}
	exit( json_encode($ret) );
}

function add_new_user_sol($name, $type, $equip, $control, $mount, $cloth_id, $width, $height, $is_guarantee, $price) {
	$post_id = wp_insert_post(array(
		'post_author'  => 1,
		'post_title'   => $name,
		'post_content' => '',
		'post_status'  => 'publish',
		'post_type'	=> 'product',
	));

	update_post_meta($post_id, '_thumbnail_id', get_post_meta($cloth_id, '_thumbnail_id', true));

	wp_set_object_terms($post_id, 'simple', 'product_type');
	wp_set_object_terms($post_id, array(27), 'product_cat');

	update_field('type', $type, $post_id);
	update_field('equip', $equip, $post_id);
	update_field('control', $control, $post_id);
	update_field('mount', $mount, $post_id);
	update_field('cloth', $cloth_id, $post_id);
	update_field('width', $width, $post_id);
	update_field('height', $height, $post_id);
	update_field('guarantee', $is_guarantee, $post_id);

	update_post_meta($post_id, '_visibility', 'visible');
	update_post_meta($post_id, '_stock_status', 'instock');
	update_post_meta($post_id, 'total_sales', '0');
	update_post_meta($post_id, '_downloadable', 'no');
	update_post_meta($post_id, '_virtual', 'no');
	update_post_meta($post_id, '_regular_price', $price);
	update_post_meta($post_id, '_sale_price', '');
	update_post_meta($post_id, '_price', $price);
	update_post_meta($post_id, '_purchase_note', '');
	update_post_meta($post_id, '_featured', 'no');
	update_post_meta($post_id, '_weight', '');
	update_post_meta($post_id, '_length', '');
	update_post_meta($post_id, '_width', '');
	update_post_meta($post_id, '_height', '');
	update_post_meta($post_id, '_sku', '');
	update_post_meta($post_id, '_sale_price_dates_from', '');
	update_post_meta($post_id, '_sale_price_dates_to', '');
	update_post_meta($post_id, '_sold_individually', '');
	update_post_meta($post_id, '_manage_stock', 'no');
	update_post_meta($post_id, '_backorders', 'no');
	update_post_meta($post_id, '_stock', '');

	return $post_id;
}

add_action('wp_ajax_getPrice', 'get_price_json');
add_action('wp_ajax_nopriv_getPrice', 'get_price_json');
function get_price_json() {
	$param = $_POST;
	$param['category'] = isset($param['category']) ? $param['category'] : '';
	$param['electro'] = (isset($param['electro']) && $param['electro'] == 'true');
	echo json_encode( get_price($param) );
	die;
}

function get_price( $set ) {
	$model = $set['model'];
	$category = $set['category'];
	$equip = $set['equip'];
	$width = $set['width'];
	$height = $set['height'];
	$count = $set['count'];

	$price = calc_price($model, $category, $equip, $width, $height, $set['electro']);
// log_write( "Calc_price res: ".var_export($price, true) );

	//Всегда брать для показа гарантийные высоту и ширину
	//if (!$price['is_guarantee']) {
		$price['sizes_guarantee'] = get_model_max_guarantee($model, $category, $price['width'], $price['height']);
		foreach ($price['sizes_guarantee'] as $key => $val) {
			$price['sizes_guarantee'][$key] = ceil(($val + 0) * 100);
		}
	//}
	if (!$price['is_real']) {
		$price['sizes_real'] = get_model_max_real($model, $category, $price['width'], $price['height']);
		foreach ($price['sizes_real'] as $key => $val) {
			$price['sizes_real'][$key] = ceil(($val + 0) * 100);
		}
	}
	$price['sizes_range'] = (array) get_model_max_sizes($model, $category);
	foreach ($price['sizes_range'] as $key => $val) {
		$price['sizes_range'][$key] = ceil(($val + 0) * 100);
	}
	$price['request'] = $set;
	return $price;
}

function calc_price($model, $category, $equip, $width, $height, $electro) {
	$all_options = get_option('true_options'); 

	$width_calc = $width / 100;
	$height_calc = $height / 100;
	$width = round(($width + 4 ) / 100, 1);
	$height = round(($height + 4) / 100, 1);
	$model_price = get_model_price($model, $category, $width_calc, $height_calc);			// See at ../plugins/soft70

// log_write( var_export($model_price, true) );
	$exchange = $all_options['wc_up_setting_course_dollar'];		 /*get_option('wc_up_setting_course')*/
	
	$price = $model_price->price;

	if ($electro) {
		$price += 230 /*get_option('wc_up_setting_electro')*/;
	}
	$is_guarantee = $model_price->is_guarantee;
	/*get_option('wc_up_setting_percent')*/ 
	$percents = 1 + ($all_options['wc_up_setting_percent']  / 100);			// ?
	$additional = 0;
	$images_scheme = array();
	
	if ($model === 'LVT') {
// log_write( 'LVT DETECTED '.$equip );
		if ($equip === 'default') {
			if (in_range($width, 2, 3) && in_range($height, 3, 4)) {
// 			if ( $width < 3) {
				$additional = 19/*get_option('wc_up_setting_add1') + 0*/;
			} elseif (in_range($width, 3, /*3.3*/ 4) && in_range($height, 4, /*4.5*/ 6)) {
// 			} else {
				$additional = 22 /*get_option('wc_up_setting_add2') + 0*/;
				
				if($height == 6 || $width == 4){
					return [
						'price'		=> ceil(($price + ($width + $additional)) * $percents * $exchange),
						'is_real'	  => $model_price != null,
						'is_guarantee' => 0,
						'width'		=> $width,
						'height'	   => $height
					];
				} else{
					return [
						'price'		=> ceil(($price + ($width + $additional)) * $percents * $exchange),
						'is_real'	  => $model_price != null,
						'is_guarantee' => $is_guarantee == 1,
						'width'		=> $width,
						'height'	   => $height
					];
				}
				
			}
		} else {
// log_write(var_export($all_options, true));
// 			if (in_range($width, 0.5, 2) && in_range($height, 1, 3)) {
			if ( $width < 2) {
				$additional = 23.50 /*get_option('wc_up_setting_add3') + 0*/;
// 			} elseif (in_range($width, 2, 3.3) && in_range($height, 3, 4.5)) {
			} else {
				$additional = 30.20 /*get_option('wc_up_setting_add4') + 0*/;
			}
// log_write( 'ADDING '.$additional );
		}

	} elseif ($model === 'LVT-ЗЕБРА') {
		if ($equip === 'default') {
			if (in_range($width, 0.5, 2) && in_range($height, 0.5, 3)) {
				$additional = 24 /*get_option('wc_up_setting_add5') + 0*/;
			} elseif (in_range($width, 2, 2.8) && in_range($height, 3, 4.5)) {
				$additional = 19 /*get_option('wc_up_setting_add6')*/ + 0;
				return [
					'price'		=> ceil(($price + ($additional)) * $percents * $exchange),
					'is_real'	  => $model_price != null,
					'is_guarantee' => $is_guarantee == 1,
					'width'		=> $width,
					'height'	   => $height
				];


			}
		} else {
			if (in_range($width, 2, 2.8) && in_range($height, 3, 4.5)) {
				$additional = 30.20 /*get_option('wc_up_setting_add7') + 0*/;
			}
		}
	}

	/* Расчет картинок-схем*/
// 	WHAT'S A FUCKIN' SHEET!!!!
	if ($model === 'LVT') {
		if ($equip === 'default') {
			if (in_range($width, 0.5, 2) && in_range($height, 1, 3)) {
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-all.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-1.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-2.png');
			} elseif (in_range($width, 2, 3) && in_range($height, 3, 4)) {
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-all.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-1_2.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-2_2.png');
			}
			elseif (in_range($width, 3, 4) && in_range($height, 4, 6)) {
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-all.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-1_3.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-2_3.png');
			}
		}
		else {
			if (in_range($width, 0.5, 2) && in_range($height, 1, 3)) {
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-all.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-1_1_1.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-2_1_1.png');
			} elseif (in_range($width, 2, 3.3) && in_range($height, 3, 4.5)) {
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-all.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-1_1_2.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-2_1_2.png');
			}
		}
		
	} elseif($model === 'UNI 2') {
		array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-UNI-all.png');
		array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-UNI-1.png');
	} elseif($model === 'MINI') {
		array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-all.png');
		array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-MINI-1.png');
		array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-MINI-2.png');
	} elseif($model === 'LVT-ЗЕБРА') {
		if ($equip === 'default') {
			if(in_range($width, 0.5, 2.0) && in_range($height, 0.5, 3.0)){
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-all.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-5.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-6.png');
			}
			elseif(in_range($width, 2.0, 2.8) && in_range($height, 3.0, 4.5)){
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-all.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-3.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-4.png');
			}
		}
		else{
			if (in_range($width, 0.5, 2) && in_range($height, 0.5, 3)) {
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-all.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-1.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-2.png');
			}
			elseif(in_range($width, 2.0, 2.8) && in_range($height, 3.0, 4.5)){
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-all.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-3.png');
				array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-4.png');
			}
			

		}
	}
	elseif($model === 'UNI2-ЗЕБРА'){
		array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-UNI-all.png');
		array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-ZEBRA-UNI-1.png');
		array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-ZEBRA-UNI-2.png');
	}
	elseif($model === 'MINI-ЗЕБРА'){
		array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-LVT-ZEBRA-all.png');
		array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-ZEBRA-MINI-1.png');
		array_push($images_scheme,get_template_directory_uri() . '/images/builder/instructions/i-ZEBRA-MINI-2.png');
	}


// log_write("ceil(($price + ($width * $additional)) * $percents * $exchange)");

	return [
		'price'		=> ceil(($price + ($width * $additional)) * $percents * $exchange),
		'is_real'	  => $model_price != null,
		'is_guarantee' => $is_guarantee == 1,
		'width'		=> $width,
		'height'	   => $height,
		'imgs' => $images_scheme
	];
}

function in_range($value, $min, $max) {
	return ($min <= $value) && ($value <= $max);
}

function add_option_field_to_general_admin_page() {
	$options = [
		'wc_up_setting_electro' => 'Электромотор «С пульта»',
		/*'wc_up_setting_percent' => 'Процент',
		'wc_up_setting_add1' => 'Спец. параметр №1',
		'wc_up_setting_add2' => 'Спец. параметр №2',
		'wc_up_setting_add3' => 'Спец. параметр №3',
		'wc_up_setting_add4' => 'Спец. параметр №4',
		'wc_up_setting_add5' => 'Спец. параметр №5',
		'wc_up_setting_add6' => 'Спец. параметр №6',
		'wc_up_setting_add7' => 'Спец. параметр №7',
		'wc_up_setting_course' => 'Курс доллара',*/
	];
	
	foreach($options as $option => $name) {
		// регистрируем опцию
//		register_setting( 'general', $option_name );
		register_setting( 'general', $name );

		// добавляем поле
		add_settings_field( 
			$option.'-id', 
			$name, 
			'wc_up_setting_callback_function', 
			'general', 
			'default', 
			[
				'id' => $option.'-id', 
				'option_name' => $option 
			]
		);
	}
}

add_action('admin_menu', 'add_option_field_to_general_admin_page');

function wc_up_setting_callback_function($val) {
	$id = $val['id'];
	$option_name = $val['option_name'];
	?>
	<input 
		type="number" 
		name="<?php$option_name?>" 
		id="<?php$id?>" 
		value="<?php esc_attr(get_option($option_name))?>" 
	/> 
	<?php
}

add_action('wp_ajax_cart_hook', 'cart_hook');
add_action('wp_ajax_nopriv_cart_hook', 'cart_hook');

function cart_hook() {

// log_write(var_export($_POST, true));
	$ret = ['success' => false];
	if ( $_POST['mode'] == 'rm' ) {
		$itm = WC()->cart->get_cart_item($_POST['id']);
		$ret = ['success' => WC()->cart->remove_cart_item($_POST['id']),
				'item' => $itm,
				'totals' => WC()->cart->get_totals()
				];
	} else if ( $_POST['mode'] == 'qty' && $_POST['qty'] > 0 ) {
		$ret = ['success' => WC()->cart->set_quantity($_POST['id'], $_POST['qty'], true),
				'qty' => $_POST['qty'], 
				'item' => WC()->cart->get_cart_item($_POST['id']),
				'totals' => WC()->cart->get_totals()
				];
	} else if ( $_POST['mode'] == 'mark' ) {
		$itm = WC()->cart->get_cart_item($_POST['id']);
		$vis = 'hidden';
		if ( $_POST['mark'] == 1) $vis = 'visible';
// log_write('Visibility have '.var_export(get_post_meta($itm['product_id'], '_visibility'),true)." set $vis");
// 		update_post_meta($itm['product_id'], '_visibility', $vis)
		$ret = ['success' => false,
				'mark' => $_POST['mark'], 
				'item' => WC()->cart->get_cart_item($_POST['id']),
				'totals' => WC()->cart->get_totals()
				];
log_write(var_export($itm, true));
	}
	exit( json_encode($ret) );
}

add_action('wp_ajax_getCloth', 'get_cloth_json');
add_action('wp_ajax_nopriv_getCloth', 'get_cloth_json');

function get_cloth_json() {
	exit( json_encode( get_cloth( $_POST['type'])) );
}

function get_cloth( $type ) {			// For using outside of AJAX
	$qry = [
			'posts_per_page'=> -1,
			'post_type'	  	=> 'product',
			'order'			=> 'ASC',
			'orderby'		=> 'ID',
			'product_cat'	=> 'cloth',
			'nopaging'		=> true,
			'meta_query'	=> [
					'relation' => 'AND',
								[ 'key'	 => 'вид_модели',
								'value'   => $type,
								'compare' => '=',
								]
							],
		];
	if ( preg_match('/^\d+$/', $type) ) {		// model_type or ID can be passed
		$qry['p'] = $type;
		$qry['meta_query'] = [];
	}

	$products_query = new WP_Query( $qry );

	$products = (array) $products_query->get_posts($qry);
	foreach ($products as $key => $product) {
		$products[$key] = (array) $product;
		$products[$key]['vendor_code'] = get_post_meta($products[$key]['ID'], '_sku');
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
// log_write( var_export($products[$key],true) );
		$post_data = get_post_meta($products[$key]['ID'], '_product_image_gallery');
		$gallery_str = array_shift( $post_data );
		if (!empty($gallery_str)) {
			$gallery_arr = explode(',', $gallery_str);
			foreach ($gallery_arr as $val) {
				$gallery[] = wp_get_attachment_url($val);
			}
		}
		$products[$key]['gallery'] = $gallery;
	}
	return $products;
}


add_action('wp_ajax_getClothCurrent', 'get_cloth_current_json');
add_action('wp_ajax_nopriv_getClothCurrent', 'get_cloth_current_json');
function get_cloth_current_json() {
	echo json_encode( get_cloth_current( $_POST['id'] ) );
	die;
}

function get_cloth_current( $id ) {			// For using outside of AJAX
	$products_query = new WP_Query(array(
		'posts_per_page' => -1,
		'post_type'	  => 'product',
		'order'		  => 'ASC',
		'orderby'		=> 'ID',
		'product_cat'	=> 'cloth',
		'nopaging' => true,
		'post__in' => [$id],
	));

	$products = (array) $products_query->get_posts();

	foreach ($products as $key => $product) {
		$products[$key] = (array) $product;
		$products[$key]['vendor_code'] = get_post_meta($products[$key]['ID'], '_sku');
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
		$post_data = get_post_meta($products[$key]['ID'], '_product_image_gallery');
		$gallery_str = array_shift( $post_data );
		$gallery_arr = explode(',', $gallery_str);
		if (!empty($gallery_str)) {
			foreach ($gallery_arr as $val) {
				$gallery[] = wp_get_attachment_url($val);
			}
		}
		$products[$key]['gallery'] = $gallery;
	}
	return $products;
}



//woocomerce
function do_excerpt($string, $word_limit) {
	$words = explode(' ', $string, ($word_limit + 1));
	if (count($words) > $word_limit) {
		array_pop($words);
	}
	echo implode(' ', $words).' ...';
}

add_filter('woocommerce_sale_flash', 'custom_sale_flash', 10, 3);
function custom_sale_flash($text, $post, $_product) {
	return '<span class="onsale"><img src="'.get_bloginfo('template_url').'/images/icons/sale.png"></span>';
}

function iap_wc_bootstrap_form_field_args($args, $key, $value)
{
	$args['class'][] = 'form-group float-left';
	$args['label_class'] = 'w-100';
	$args['input_class'][] = 'form-control w-100';
	return $args;
}

add_filter('woocommerce_form_field_args', 'iap_wc_bootstrap_form_field_args', 10, 3);

//add_filter('woocommerce_cart_needs_payment', '__return_false');

add_filter('woocommerce_account_menu_items', 'misha_remove_my_account_links');
function misha_remove_my_account_links($menu_links)
{
	//unset( $menu_links['edit-address'] ); // Addresses
	unset($menu_links['dashboard']); // Remove Dashboard
	//unset( $menu_links['payment-methods'] ); // Remove Payment Methods
	//unset( $menu_links['orders'] ); // Remove Orders
	unset($menu_links['downloads']); // Disable Downloads
	//unset( $menu_links['edit-account'] ); // Remove Account details tab
	//unset( $menu_links['customer-logout'] ); // Remove Logout link
	return $menu_links;
}

function tb_text_strings( $translated_text, $text, $domain ) {
	switch ( $translated_text ) {
		case 'Просмотр корзины' :
			$translated_text = __('Корзина', 'woocommerce');
			break;
	}
	return $translated_text;
}
add_filter('gettext', 'tb_text_strings', 20, 3);


// // Adding Meta container admin shop_order pages
// add_action( 'add_meta_boxes', 'mv_add_meta_boxes' );
// if ( ! function_exists( 'mv_add_meta_boxes' ) )
// {
//	 function mv_add_meta_boxes()
//	 {
//		 add_meta_box( 'mv_other_fields', __('Экспорт заказа в Excel','woocommerce'), 'mv_add_other_fields_for_packaging', 'shop_order', 'side', 'core' );
//	 }
// }

// // Adding Meta field in the meta container admin shop_order pages
// if ( ! function_exists( 'mv_add_other_fields_for_packaging' ) )
// {
//	 function mv_add_other_fields_for_packaging()
//	 {
//		 global $post;

//		 echo '<div>'. $post->ID .'</div>';

//	 }
// }

function dd( $anything ) {
	add_action( 'shutdown', function () use ( $anything ) {
		echo "<div style=' z-index: 99999;float: left; position: relative;  margin-left:100px;width: 90%; font-size: 12px; border: 2px solid red; padding: 5px 10px; box-shadow: 0 0 10px rgba(0,0,0,1); left: 30px; top:0;  background-color: white; overflow: auto; '><pre style='overflow: auto;'>";
		var_dump( $anything );
		echo "</pre></div>";
	} );

	//die();
}

$true_page = 'price_settings_page.php'; // это часть URL страницы, рекомендую использовать строковое значение, т.к. в данном случае не будет зависимости от того, в какой файл вы всё это вставите
 
/*
 * Функция, добавляющая страницу в пункт меню Настройки
 */
function true_options() {
	global $true_page;
	add_options_page( 'Ценовые настройки', 'Ценовые настройки', 'edit_true_options', $true_page, 'true_option_page');  
}
add_action('admin_menu', 'true_options');
 
/**
 * Возвратная функция (Callback)
 */ 
function true_option_page() {
	global $true_page;
	echo '<div class="wrap">';
		echo '<form method="post" enctype="multipart/form-data" action="options.php">';
		echo settings_fields('true_options'); // меняем под себя только здесь (название настроек)
		echo do_settings_sections($true_page);
		echo submit_button();
		echo '</form>
	</div>';
}
 
/*
 * Регистрируем настройки
 * Мои настройки будут храниться в базе под названием true_options (это также видно в предыдущей функции)
 */
function true_option_settings() {
	global $true_page;
	// Присваиваем функцию валидации ( true_validate_settings() ). Вы найдете её ниже
	register_setting( 'true_options', 'true_options', 'true_validate_settings' ); // true_options
 
	// Добавляем секцию
	add_settings_section( 'true_section_1', 'Ценовые настройки', '', $true_page );
 
	// Создадим текстовое поле в первой секции
	$true_field_params = array(
		'type'	  => 'number', // тип
		'id'		=> 'wc_up_setting_course_dollar',
		'desc'	  => '', // описание
		'label_for' => 'wc_up_setting_course_dollar'
		
	);
	add_settings_field( 'wc_up_setting_course', 'Курс доллара', 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );

	$true_field_params = array(
		'type'	  => 'number', // тип
		'id'		=> 'wc_up_setting_percent',
		'desc'	  => '', // описание
		'label_for' => 'wc_up_setting_percent'
		
	);
	add_settings_field( 'wc_up_setting_percent', 'Процент', 'true_option_display_settings', $true_page, 'true_section_1', $true_field_params );

}
add_action( 'admin_init', 'true_option_settings' );
 
/*
 * Функция отображения полей ввода
 * Здесь задаётся HTML и PHP, выводящий поля
 */
function true_option_display_settings($args) {
	extract( $args );
 
	$option_name = 'true_options';
 
	$o = get_option( $option_name );
 
	switch ( $type ) {  
		case 'number':  
			$o[$id] = esc_attr( stripslashes($o[$id]) );
			echo "<input class='regular-text' type='number' id='$id' name='" . $option_name . "[$id]' value='$o[$id]' />";  
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
		break;
		case 'textarea':  
			$o[$id] = esc_attr( stripslashes($o[$id]) );
			echo "<textarea class='code large-text' cols='50' rows='10' type='text' id='$id' name='" . $option_name . "[$id]'>$o[$id]</textarea>";  
			echo ($desc != '') ? "<br /><span class='description'>$desc</span>" : "";  
		break;
		case 'checkbox':
			$checked = ($o[$id] == 'on') ? " checked='checked'" :  '';  
			echo "<label><input type='checkbox' id='$id' name='" . $option_name . "[$id]' $checked /> ";  
			echo ($desc != '') ? $desc : "";
			echo "</label>";  
		break;
		case 'select':
			echo "<select id='$id' name='" . $option_name . "[$id]'>";
			foreach($vals as $v=>$l){
				$selected = ($o[$id] == $v) ? "selected='selected'" : '';  
				echo "<option value='$v' $selected>$l</option>";
			}
			echo ($desc != '') ? $desc : "";
			echo "</select>";  
		break;
		case 'radio':
			echo "<fieldset>";
			foreach($vals as $v=>$l){
				$checked = ($o[$id] == $v) ? "checked='checked'" : '';  
				echo "<label><input type='radio' name='" . $option_name . "[$id]' value='$v' $checked />$l</label><br />";
			}
			echo "</fieldset>";  
		break; 
	}
}
 
/*
 * Функция проверки правильности вводимых полей
 */
function true_validate_settings($input) {
	foreach($input as $k => $v) {
		$valid_input[$k] = trim($v);
 
		/* Вы можете включить в эту функцию различные проверки значений, например
		if(! задаем условие ) { // если не выполняется
			$valid_input[$k] = ''; // тогда присваиваем значению пустую строку
		}
		*/
	}
	return $valid_input;
}

function check_mobile_device() { 
	$mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
	$agent = strtolower($_SERVER['HTTP_USER_AGENT']);	
	foreach ($mobile_agent_array as $value) {	
		if (strpos($agent, $value) !== false) return true;   
	};	 
	return false; 
};


register_post_type('dealers_content', array(
	'labels'			 => array(
		'name'			   => 'Изделия(для дилеров)', 
		'singular_name'	  => 'Изделие(для дилеров)',
		'add_new'			=> 'Добавить новое ',
		'add_new_item'	   => 'Добавить новую популярное изделие',
		'edit_item'		  => 'Редактировать популярное изделие',
		'new_item'		   => 'Новая популярное изделие',
		'view_item'		  => 'Посмотреть популярное изделие',
		'search_items'	   => 'Найти популярное изделие',
		'not_found'		  =>  'Популярное изделие не найдено',
		'not_found_in_trash' => 'В корзине популярное изделие не найдено',
		'parent_item_colon'  => '',
		'menu_name'		  => 'Изделия(для дилеров)'

	  ),
	'public'			 => false,
	'publicly_queryable' => false,
	'show_ui'			=> true,
	'show_in_menu'	   => true,
	'query_var'		  => true,
	'rewrite'			=> true,
	'capability_type'	=> 'post',
	'has_archive'		=> true,
	'hierarchical'	   => false,
	'menu_position'	  => null,
	'supports'		   => array('title')
) );


function add_theme_caps() {
	$role = get_role( 'shop_manager' );

	$role->add_cap( 'edit_true_options' ); 
	
	$role = get_role( 'administrator' );

	$role->add_cap( 'edit_true_options' ); 
   
}
add_action( 'admin_init', 'add_theme_caps');



add_filter('option_page_capability_true_options', create_function(NULL, 'return "edit_true_options";') );



// add_action('init', 'dynamic_seo_content_init');
// function dynamic_seo_content_init(){
// 	register_post_type('dynamic_seo_content', array(
// 		'labels'			 => array(
// 			'name'			   => 'Динамический контент', // Основное название типа записи
// 			'singular_name'	  => 'Динамический контент', // отдельное название записи типа Book
// 			'add_new'			=> 'Добавить новый ',
// 			'add_new_item'	   => 'Добавить новый элемент',
// 			'edit_item'		  => 'Редактировать элемент',
// 			'new_item'		   => 'Новый элемент',
// 			'view_item'		  => 'Посмотреть элемент',
// 			'search_items'	   => 'Найти элемент',
// 			'not_found'		  =>  'Элементов не найден',
// 			'not_found_in_trash' => 'В корзине элементов не найдено',
// 			'parent_item_colon'  => '',
// 			'menu_name'		  => 'Динамический контент'

// 		  ),
// 		'public'			 => false,
// 		'publicly_queryable' => true,
// 		'show_ui'			=> true,
// 		'show_in_menu'	   => true,
// 		'query_var'		  => true,
// 		'rewrite'			=> true,
// 		'capability_type'	=> 'post',
// 		'has_archive'		=> false,
// 		'hierarchical'	   => false,
// 		'menu_position'	  => null,
// 		'supports'		   => array('title')
//	 ) );
	
// }

// add_action( 'init', 'dynamic_seo_content_taxonomy' );
// function dynamic_seo_content_taxonomy(){

// 	register_taxonomy( 'dynamic_seo_content_cat', [ 'dynamic_seo_content' ], [ 
// 		'label'				 => '', 
// 		'labels'				=> [
// 			'name'			  => 'Категории',
// 			'singular_name'	 => 'Категория',
// 			'search_items'	  => 'Найти кактегорию',
// 			'all_items'		 => 'Все категории',
// 			'view_item '		=> 'Посмотреть категорию',
// 			'parent_item'	   => 'Родительская категория',
// 			'parent_item_colon' => 'Родительская категория:',
// 			'edit_item'		 => 'Редакитировать категорию',
// 			'update_item'	   => 'Обновить категорию',
// 			'add_new_item'	  => 'Добавить новую категорию',
// 			'new_item_name'	 => 'Новая категория',
// 			'menu_name'		 => 'Категории',
// 		],
// 		'public'				=> true,
// 		'show_in_nav_menus'	 => false, // равен аргументу public
// 		'show_ui'			   => true, // равен аргументу public
// 		'show_tagcloud'		 => false, // равен аргументу show_ui
// 		'hierarchical'		  => true,
// 		'rewrite'			   => true,
// 		'show_admin_column'	 => true, // Позволить или нет авто-создание колонки таксономии в таблице ассоциированного типа записи. (с версии 3.5)
// 	] );
// }


//			See at js/solutions.js, js/ajax-add-to-cart.js
add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
		
function woocommerce_ajax_add_to_cart() {

			$product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
			$quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
			$variation_id = absint($_POST['variation_id']);
			$passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
			$product_status = get_post_status($product_id);

			if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

				do_action('woocommerce_ajax_added_to_cart', $product_id);

				if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
					wc_add_to_cart_message(array($product_id => $quantity), true);
				}

				WC_AJAX :: get_refreshed_fragments();
			} else {

				$data = array(
					'error' => true,
					'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

				echo wp_send_json($data);
			}

			wp_die();
		}

function get_variation_data_from_variation_id( $item_id ) {
	$_product = new WC_Product_Variation( $item_id );
	$variation_data = $_product->get_variation_attributes();
	//$variation_detail = woocommerce_get_formatted_variation( $variation_data, true );  // this will give all variation detail in one line
	$variation_detail = woocommerce_get_formatted_variation( $variation_data, false);  // this will give all variation detail one by one
	return $variation_detail; // $variation_detail will return string containing variation detail which can be used to print on website
	// return $variation_data; // $variation_data will return only the data which can be used to store variation data
}
