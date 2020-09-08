#!/usr/bin/php
<?php
$ts = array ( 
		0 => array ( 
			'ID' => 425, 
			'post_author' => '2', 
			'post_date' => '2019-10-27 08:34:28', 
			'post_date_gmt' => '2019-10-27 05:34:28', 
			'post_content' => '', 
			'post_title' => 'АНЖУ 4284 лиловый', 
			'post_excerpt' => '', 
			'post_status' => 'publish', 
			'comment_status' => 'open', 
			'ping_status' => 'closed', 
			'post_password' => '', 
			'post_name' => 'anzhu-4284-lilovyj', 
			'to_ping' => '', 
			'pinged' => '', 
			'post_modified' => '2019-10-27 08:34:28', 
			'post_modified_gmt' => '2019-10-27 05:34:28', 
			'post_content_filtered' => '', 
			'post_parent' => 0, 
			'guid' => 'http://t2.soft70.ru/product/', 
			'menu_order' => 0, 
			'post_type' => 'product', 
			'post_mime_type' => '', 
			'comment_count' => '0', 
			'filter' => 'raw', 
			'vendor_code' => array ( 0 => '300705-4284', ), 
			'preview' => '<img ...................... >', 
			'fields' => array ( 
				'вид_модели' => 'classic', 
				'категория' => '3', 
				'единица_измерения' => 'м', 
				'прозрачность' => '45', 
				'ширина_рулона' => '200', 
				'структура' => 'жемчуг / принт / блеск', 
				'вес_гм2' => '', 
				'пригодность_для_влажных_помещений' => true, 
				'стойкость_к_выгоранию' => '43589', 
				'уход_и_чистка' => 'сухая чистка', 
				'цвет' => 'лиловый',
				'страна_происхождения' => 'ГЕРМАНИЯ',
				'сертификация' => true, 
				'изображение_mini' => 427, 
				'изображение_uni' => 428, 
				'изображение_lvt' => 429, 
				'цвет_для_фильтра' => 'purple',
				), 
			'texture_lvt' => 'http://zdz.onpositive.ru/wp-content/uploads/2019/10/rollers-lvt-anju-4284-1.png',
			'texture_mini' => 'http://zdz.onpositive.ru/wp-content/uploads/2019/10/rollers-mini-anju-4284-1.png',
			'texture_uni' => 'http://zdz.onpositive.ru/wp-content/uploads/2019/10/rollers-uni-anju-4284-1.png',
			'gallery' => array ( 0 => 'http://zdz.onpositive.ru/wp-content/uploads/2019/11/rollers-anju-4284-3.png') 
		)
	);

foreach ( $ts as $item ) {
	echo '<a href="#" title="',$item['post_title'],'" data-cloth-id="',$item['ID'],'" data-texture-lvt="',$item['texture_lvt'],'" data-texture-mini="',$item['texture_mini'],'" >';
	echo "\n";
}

?>