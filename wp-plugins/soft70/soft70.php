<?php
/*
Plugin Name: WC Update Price
Description:
Version: 1.0
Author: soft70
*/

require_once ABSPATH.'wp-admin/includes/upgrade.php';
require_once __DIR__.'/PHPExcel/Classes/PHPExcel.php';

global $wpdb;
$table_name = $wpdb->get_blog_prefix().'models_prices';

$lists = [
			'MINI',
			'MINI-ЗЕБРА',
			'UNI 2',
			'UNI2-ЗЕБРА',
			'LVT',
			'LVT-ЗЕБРА',
		];
$cats = [
			'E',
			'1',
			'2',
			'3',
			'4',
			'5'
		];

class wc_up_class {
	public $db_version = 2;

	function __construct() {
		add_action('init', function () {
			$this->init();
		});
	}

	function init() {
		$installed_db_version = get_option('wc_up_db_version', 0);
		if (version_compare($this->db_version, $installed_db_version, '>')) {
			$this->upgrade();
		}
	}

	function upgrade() {
		global $wpdb;
		global $table_name;

		$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

		$sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
			id int(11) unsigned NOT NULL auto_increment,
			model varchar(255) NOT NULL default '',
			category varchar(1) NOT NULL default 'E',
			width decimal(7,2) unsigned NOT NULL default '0',
			height decimal(7,2) unsigned NOT NULL default '0',
			price decimal(7,2) unsigned NOT NULL default '0',
			is_guarantee boolean not null default '0',
			date_update date null,
			time_update time null,
			PRIMARY KEY id (id),
			KEY model (model),
			KEY category (category),
			KEY time_update (time_update),
			KEY width (width),
			KEY height (height),
			KEY date_update (date_update)
		) {$charset_collate};";
// print_r($sql);
		dbDelta($sql);
		update_option('wc_up_db_version', $this->db_version);
	}
}

$wc_up_db = new wc_up_class();

function add_model_price($model, $category, $width, $height, $price, $is_guarantee) {
	global $wpdb;
	global $table_name;

	$model = esc_sql($model);
	$category = esc_sql($category);
	$width = esc_sql($width);
	$height = esc_sql($height);
	$price = esc_sql($price);
	$is_guarantee = esc_sql($is_guarantee);
	$today = date("Y-m-d");    
	$todaytime = date("H:i:s");
	
	$sql= "INSERT INTO $table_name (model,category,width,height,price,is_guarantee,date_update,time_update) ".
				" VALUES ('$model','$category','$width','$height','$price','$is_guarantee',CURDATE(),CURTIME())";

	$wpdb->query($sql);
// 	$wpdb->insert($table_name, array(
// 			'model'        => $model,
// 			'category'     => $category,
// 			'width'        => $width,
// 			'height'       => $height,
// 			'price'        => $price,
// 			'is_guarantee' => $is_guarantee,
// 			'date_update' =>  $today,
// 			'time_update' =>  $todaytime
// 	));
}

function get_model_price($model, $category, $width, $height) {
	global $wpdb;
	global $table_name;

	$dbh = $wpdb->prepare(
		"SELECT * FROM {$table_name} AS a 
		WHERE a.model = %s AND a.`category`=%s AND a.`width`>=%f AND a.`height`>=%f 
		AND %f >= (SELECT MIN(c.`width`) AS `min_width` FROM {$table_name} as c WHERE c.`model`=%s AND c.`category`=%s AND c.`date_update` = (SELECT MAX(b.`date_update`) AS `date_update` FROM {$table_name} AS b WHERE b.`model`=%s AND b.`category`=%s GROUP BY b.`date_update` order by b.`date_update` DESC LIMIT 0,1)) 
		AND %f >= (SELECT MIN(c.`height`) AS `min_height` FROM {$table_name} AS c WHERE c.`model`=%s AND c.`category`=%s AND c.`date_update` = (SELECT MAX(b.`date_update`) AS `date_update` FROM {$table_name} as b WHERE b.`model`=%s AND b.`category`=%s GROUP BY b.`date_update` order by b.`date_update` DESC LIMIT 0,1)) 
		LIMIT 0,1",
		/*"SELECT * FROM {$table_name} WHERE `model`=%s AND `category`=%s AND `width`>=%f AND `height`>=%f LIMIT 1",*/
		$model,
		$category,
		$width,
		$height,
		$width,
		$model,
		$category,
		$model,
		$category,
		$height,
		$model,
		$category,
		$model,
		$category
	);
	$ret = $wpdb->get_row($dbh);
	return $ret;
}


/**
 * 03.06.20 get_model_max_guarantee убрал во внутреннем select limit 1
 */


function get_model_max_guarantee($model, $category, $width, $height) {
	global $wpdb;
	global $table_name;

// log_write( "get_max_gar from $table_name: $model, $category, $width, $height" );

	$height_real = $wpdb->get_row($wpdb->prepare(
		"SELECT MAX(`height`) as `height` FROM {$table_name} WHERE `model`=%s AND `category`=%s AND `width`=(SELECT `width` FROM {$table_name} WHERE `width`>=%f LIMIT 0,1) AND `is_guarantee`=1",
		$model,
		$category,
		$width
	));
	$width_real = $wpdb->get_row($wpdb->prepare(
		"SELECT MAX(`width`) as `width` FROM {$table_name} WHERE `model`=%s AND `category`=%s AND `height`=(SELECT `height` FROM {$table_name} WHERE `height`>=%f LIMIT 0,1) AND `is_guarantee`=1",
		$model,
		$category,
		$height
	));
	$result = [];
	if($height_real->height != null) {
		$result['height'] = $height_real->height;
	}
	if($width_real->width != null) {
		$result['width'] = $width_real->width;
	}
	if($height_real->height == null && $width_real->width == null) {
		$max_real = $wpdb->get_row($wpdb->prepare(
			"SELECT MAX(`width`) as `width`, MAX(`height`) as `height` FROM {$table_name} WHERE `model`=%s AND `category`=%s AND `is_guarantee`=1 LIMIT 1",
			$model,
			$category,
			$height
		));
		$result['height'] = $max_real->height;
		$result['width'] = $max_real->width;
	}
	return $result;
}

function get_model_max_real($model, $category, $width, $height) {
	global $wpdb;
	global $table_name;

	$height_real = $wpdb->get_row($wpdb->prepare(
		"SELECT MAX(`height`) as `height` FROM {$table_name} WHERE `model`=%s AND `category`=%s AND `width`=(SELECT `width` FROM {$table_name} WHERE `width`>=%f LIMIT 0,1)",
		$model,
		$category,
		$width
	));
	$width_real = $wpdb->get_row($wpdb->prepare(
		"SELECT MAX(`width`) as `width` FROM {$table_name} WHERE `model`=%s AND `category`=%s AND `height`=(SELECT `height` FROM {$table_name} WHERE `height`>=%f LIMIT 0,1)",
		$model,
		$category,
		$height
	));
	$result = [];
	if($height_real->height != null) {
		$result['height'] = $height_real->height;
	}
	if($width_real->width != null) {
		$result['width'] = $width_real->width;
	}
	if($height_real->height == null && $width_real->width == null) {
		$max_real = $wpdb->get_row($wpdb->prepare(
			"SELECT MAX(`width`) as `width`, MAX(`height`) as `height` FROM {$table_name} WHERE `model`=%s AND `category`=%s LIMIT 1",
			$model,
			$category,
			$height
		));
		$result['height'] = $max_real->height;
		$result['width'] = $max_real->width;
	}
	return $result;
}

function get_model_max_sizes($model, $category) {
	global $wpdb;
	global $table_name;

	return $wpdb->get_row( $wpdb->prepare(
		"SELECT MIN(`width`) as `min_width`, MAX(`width`) as `max_width`, MIN(`height`) as `min_height`, MAX(`height`) as `max_height` FROM {$table_name} ".
		"WHERE `model`=%s AND `category`=%s ".
			"AND `date_update`=".
					"(SELECT MAX(`date_update`) AS `date_update` FROM {$table_name} ".
						"WHERE `model`=%s AND `category`=%s GROUP BY `date_update` ORDER BY `date_update` DESC LIMIT 1 )",
		$model,
		$category,
		$model,
		$category
	));
}

add_action('admin_init', 'wc_upd_price_save');

function wc_upd_price_save() {
	global $wpdb;
	global $table_name;
	global $lists;
	global $cats;
	if (!is_admin() && !current_user_can('edit_theme_options')) {
		return;
	}
	if (!empty($_POST) && isset($_POST['page']) && $_POST['page'] == $_GET['page'] && isset($_POST['action']) && $_POST['action'] == 'wc_upd_price_save') {
		check_admin_referer();
		$types = [
				'application/vnd.ms-excel',
				'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
			];

		if (in_array($_FILES['file_excel']['type'], $types)) {
			$upload_dir = __DIR__.'/uploads/';
			$upload_file = $upload_dir.'prices.'.array_pop(explode('.', basename($_FILES['file_excel']['name'])));

			move_uploaded_file($_FILES['file_excel']['tmp_name'], $upload_file);

			$file_type = PHPExcel_IOFactory::identify($upload_file);
			$objReader = PHPExcel_IOFactory::createReader($file_type);
			$objPHPExcel = $objReader->load($upload_file);
			
			$wpdb->query("DELETE FROM $table_name");
			foreach ($lists as $name) {

				$sheet = $objPHPExcel->getSheetByName($name);
				$result = $sheet->toArray(); // выгружаем данные из объекта в массив
// log_write( $name);
// log_write( count($result) );


				foreach ($result as $key => $row) {
					$result[$key] = array_diff($row, array(''));
				}
			
				array_diff($result, array([]));

				$prices = [];
				$is_first_line = true;
				$cur1 = '';
				$cur2 = '';
				$myCats = $cats;
				$is_one = false;
				foreach ($result as $key => $row) {

					$row_keys = array_keys($row);

					if (count($row) == 2) {

						$cur1 = array_shift($myCats);
						$prices[$cur1] = [
									'key' => $row_keys[0]
								];
						$cur2 = array_shift($myCats);
						$prices[$cur2] = [
									'key' => $row_keys[1]
								];
						$is_one = false;
						$is_first_line = true;

					} elseif (count($row) == 1) {
						$cur1 = array_shift($myCats);
						$prices[$cur1] = [
									'key' => $row_keys[0]
								];
						$is_one = true;
						$is_first_line = true;
					} elseif (count($row) > 1) {
						if ($is_first_line) {

							$is_cat1 = true;
							$line1 = [];
							$line2 = [];

							$prev_key = $row_keys[0];
							foreach ($row as $cell_key => $cell) {
								if ($cell_key - $prev_key >= 2) {
									$is_cat1 = false;
								}
								if ($is_cat1) {
									$line1[] = $cell;
								} elseif (!$is_one) {
									$line2[] = $cell;
								}
								$prev_key = $cell_key;
							}
							$prices[$cur1]['sizes_w'] = $line1;
							if (!$is_one) {
								$prices[$cur2]['sizes_w'] = $line2;
							}
							$is_first_line = false;
						} else {
							$is_cat1 = true;
							$line1 = [];
							$line2 = [];
						
							$prev_key = $row_keys[0];
							foreach ($row as $cell_key => $cell) {
								if ($cell_key - $prev_key >= 2) {
									$is_cat1 = false;
								}
								$color = $sheet->getStyleByColumnAndRow($cell_key, $key + 1)
											->getFill()
											->getStartColor()
											->getRGB();
								if ($is_cat1) {
									
									$line1[] = [
										'price'        => $cell,
										'is_guarantee' => ($color == 'FFFFFF' || $color == '000000') ? 1 : 0
									];
								} elseif (!$is_one) {
									$line2[] = [
										'price'        => $cell,
										'is_guarantee' => ($color == 'FFFFFF' || $color == '000000') ? 1 : 0
									];
								}
								$prev_key = $cell_key;
// 								$count_2++;
							}
							$prices[$cur1]['sizes_h'][] = $line1[0]['price'];
							array_splice($line1, 0, 1);
							$prices[$cur1]['prices'][] = $line1;
							if (!$is_one) {
								$prices[$cur2]['sizes_h'][] = $line2[0]['price'];
								array_splice($line2, 0, 1);
								$prices[$cur2]['prices'][] = $line2;
							}
						}
					}
				}
			
				foreach ($prices as $key => $prices_cat) {
					if(is_array($prices_cat['sizes_w'])){
						foreach ($prices_cat['sizes_w'] as $key_w => $width) {
							foreach ($prices_cat['sizes_h'] as $key_h => $height) {
								$price = $prices_cat['prices'][$key_h][$key_w];
								if (isset($price)) {
									global $wc_up_db;
									$price['price'] = preg_replace('/[^0-9,.]/', '', $price['price']);
									add_model_price($name, $key, $width, $height, $price['price'], $price['is_guarantee']);
								}
							}
						}
					}
				}
			}
		}

	}
}

add_action('admin_menu', 'wc_upd_price_menu');
function wc_upd_price_menu() {
	add_plugins_page('WC Update Price ', 'WC Update Price', 'edit_theme_options', 'wc_up', 'wc_upd_price_options');
}

function wc_upd_price_options() {
	global $wpdb;
	global $lists;
	global $cats;
	global $table_name;
	$uptime = $wpdb->get_row($wpdb->prepare("SELECT date_update,time_update FROM {$table_name} ORDER BY date_update DESC,time_update DESC LIMIT 0,1"));
?>
	<style type="text/css">
		.order-num {
			width: 60px;
		}
		.short-text {
			width: 150px;
		}
		#wc_up-blogs-list-table * {
			text-align: center;
		}
		.inside h3 {
			margin: 0;
		}
		.inside table {
		}
		.comment ol {
			margin:1em 5em;
			line-height:1.2;
		}
		.comment li {
			margin-bottom:0px;
			font-weight:bold;
		}
		strong.comment {
			color:#000099;
		}
		.inside table .size {
			background: #fff254;
		}
		.inside table .no_guarantee {
			background: #b1b1b1;
		}
	</style>
	<div class="wrap" id="wp2pcs-admin-dashbord">
		<h2>Обновление цен</h2>
<?php if ( $uptime ) { ?>
		<strong class="comment">Последнее обновление <?php echo $uptime->date_update,' в ',$uptime->time_update ?></strong>
<?php } ?>
		<div class="comment"><strong>ВНИМАНИЕ!</strong> Прайслист будет полностью перезаписан. Постарайтесь удалить из файла всю лишнюю информацию.<br>
		Загружаемый xls-файл прайслиста <u>обязательно</u> должен содержать листы с такими названиями:
		<ol>
<?php
foreach( $lists as $model) {
	echo "\t\t<li>{$model}</li>\n";
}
?>
		</ol>
		</div>
		<div class="metabox-holder">
			<div class="postbox">
				<div class="inside" style="border-bottom:1px solid #CCC;margin:0;padding:8px 10px;">
					<form method="post" autocomplete="off" enctype="multipart/form-data">
						<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo 1024 * (1024 * 10) ?>"/>
						<input type="file"
							name="file_excel"
							accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"/>
						<input type="submit" value="Обновить" class="button-primary"/>
						<input type="hidden" name="action" value="wc_upd_price_save"/>
						<input type="hidden" name="page" value="<?php echo $_GET['page']; ?>"/>
						<?php wp_nonce_field(); ?>
					</form>
				</div>
			</div>
			<?php
			foreach($lists as $model) {

				foreach($cats as $cat) {
                   
					$prices_db = $wpdb->get_results($wpdb->prepare(
						"SELECT * FROM {$table_name} WHERE `model`=%s AND `category`=%s",
						$model,
						$cat
					));
					if(count((array)$prices_db) > 0) {
					?>
					<div class="postbox">
						<div class="inside" style="border-bottom:1px solid #CCC;margin:0;padding:8px 10px;">
							<h3><?php echo $model.' '.$cat ?></h3>
							<?php
							
							$prices = [];
							$heights = [];
							$widths = [];
							foreach($prices_db as $row) {
								$heights[] = $row->height;
								$widths[] = $row->width;
								$prices[$row->width][$row->height] = [
									"price" => $row->price,
									"is_guarantee" => $row->is_guarantee
								];
							}
							$heights = array_unique($heights);
							$widths = array_unique($widths);
							asort($heights);
							asort($widths);
							?>
							<table>
								<tr>
									<td></td>
									<?php
									foreach($widths as $width) {
									?>
										<td class="size"><?php echo $width?></td>
									<?php
									}
									?>
								</tr>
								<?php
								foreach($heights as $height) {
								?>
								<tr>
									<td class="size"><?php echo $height ?></td>
									<?php
									foreach($widths as $width) {
										if(isset($prices[$width][$height])) {
											$price = $prices[$width][$height];
										?>
											<td class="<?php echo $price["is_guarantee"] ? '':'no_guarantee' ?>"><?php echo $price["price"] ?></td>
										<?php
										} else {
										?>
											<td></td>
										<?php
										}
									}
									?>
								</tr>
								<?php
								}
								?>
							</table>
						</div>
					</div>
					<?php
					}
// 					$count++;
				}
			}
			?>
		</div>
	</div>
	<?php
}
function d($el) {
	echo "<pre>";
	print_r($el);
	echo "<pre>";
}