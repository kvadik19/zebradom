<?php
	$type = 'zebra';
	if (isset($_GET['type']) ) $type = $_GET['type'];
	$clothes = get_cloth($type);

	$clSet = [];
	if ( array_key_exists('builder', $_COOKIE) ) {
		$clSet = str_replace('\"', '"', $_COOKIE['builder']);
		$clSet = json_decode( utf8_decode( $clSet ), true );
	} else {
		$clSet['_'.$type] = $clothes[0]['ID'];
	}
?>
	<script>
		var activeCloth = <?php echo isset($_GET['cloth']) ? $_GET['cloth'] : $clSet['_'.$type];?>;		// 
		var cloths = {'<?php echo $type ?>':<?php echo json_encode($clothes) ?>};
		var activeModelType = '<?php echo $type ?>';
	</script>
<div class="page-set">

	<div class="builder">
		<div class="page-wide">
			<h4>Рулонные шторы. Практично, удобно, стильно!</h4>
			<span>Конструктор поможет выбрать индивидуальное интерьерное решение</span>
		</div>
		<div class="page-part part-narrow">
			<div id="builder-display">
				<div id="builder-preview">
					<canvas id="canvas"></canvas>
				</div>
				<div class="opt-list">
					<div class="opt-row">
						<div class="opt-name">Цвет рамы</div>
						<div id="color-frame" class="opt-value"></div>
					</div>
					<div class="opt-row">
						<div class="opt-name">Цвет стен</div>
						<div class="opt-value">
							<div id="color-wall" class="btn btn-callback gray" style="background-color:#ffffff" ></div>
							<div class="btn btn-callback">
								<img src="<?php echo get_template_directory_uri() ?>/images/icons/edit.svg" class="icon" />Выбрать</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="page-part part-wide">
			<div class="opt-list">
				<div class="opt-row">
					<div class="opt-head">
						<strong>Подбери ткань</strong>&nbsp;<span id="countCloth"><?php echo count($clothes) ?></span> в ассортименте:
						<span id="expandAll" class="filter-switch expand-list">Показать все ткани</span>
						<span id="filterRst" class="filter-switch" hidden>Очистить фильтры</span><!-- &#10005; -->
					</div>
					<div class="opt-head" id="filterCloth">
<?php		// See : var fieldsOpt as a relations between Advanced Custom Fields and these options 
			// See also : related function for querySelectorAll('.tosort'), querySelectorAll('.pulld')
			// in builder.js
?>
						<div>
							<span>Сортировка:</span>
							<span data-sort="popularity" class="tosort">по популярности</span>
							<span data-sort="cat" class="tosort on fw">по цене</span>
						</div>
						<div>
							<span data-filter="origin" class="pulld multi">Страна-производитель</span>
							<span data-filter="opacity" class="pulld multi">Светопроницаемость (%)</span>
							<span data-filter="colorCode" data-ref="colorName" class="pulld multi">Цвет</span>
							<span data-filter="texture" class="pulld multi">Текстура</span>
						</div>
					</div>
					<div class="cloth-list">
						<div id="builder-loading" class="d-none"><img src="<?php bloginfo('template_url') ?>/images/icons/load-rainbow.svg" alt=""/></div>
						<ul class="cloth-list">
<?php
foreach ($clothes as $item) {
	$short_title = preg_replace('/\s*зебра\s*/i', '', $item['post_title']);
	echo '<li class="cloth-list-item" id="clo_',$item['ID'],'" style="background-image:url(\'',$item['gallery'][0],'\')" ';		//  data-toggle="tooltip"
	echo 'title="',$short_title,'" data-cat="',$item['fields']['категория'],'" data-title="',$item['post_title'],'" ';
	echo 'data-popularity="',isset($item['fields']['popularity']) ? $item['fields']['popularity'] : '0','"',">\n";
// Obsoleted dataset:
// 	echo 'data-texture-uni="',$item['texture_uni'];
//  data-cloth-id="',$item['ID'],'" data-texture-lvt="',$item['texture_lvt'],'" data-texture-mini="',$item['texture_mini'],'" 
//	echo 'data-short-title="',$short_title,'" data-vendor-code="',$item['vendor_code'][0],'" data-color-cloth="',$item['fields']['цвет'],'" ';
	echo '<i aria-hidden="true" class="clo-info"><img src="',bloginfo('template_url'),'/images/icons/findglass.svg" /></i>',"\n";
// 	echo '<input hidden type="radio" class="form-check-input" name="cloth" value="',$item['ID'],'" />',"\n";
	echo "</li>\n";
}
?>
						</ul>
					</div>		<!--cloth-list-->
					<div class="opt-head ruler">
						<span id="collapseAll" class="filter-switch expand-list" hidden>Свернуть список</span>
					</div>
				</div>		<!--opt-row -->
				<div class="opt-row"><?php // Options switcher. Sets `activeModelXXXX` variables immediately ?>
					<p>Подружись с солнцем, управляй светом, преврати день в ночь. <b>Закажи шторы на сайте прямо сейчас!</b>
					</p>
					<div id="options" class="opt-head">
						<div class="order-opt" data-name="type">
							<p>Выбери тип штор
							<span class="btn-small">Посмотреть!</span>
							</p>
							<figure class="option<?php echo $type=='classic' ? ' sel' : '' ?>" data-value="classic">
								<figcaption>Классика</figcaption>
								<img src="<?php bloginfo('template_url') ?>/images/builder/opt-type-c.svg" />
							</figure>
							<figure class="option<?php echo $type=='zebra' ? ' sel' : '' ?>" data-value="zebra">
								<figcaption>Зебра</figcaption>
								<img src="<?php bloginfo('template_url') ?>/images/builder/opt-type-z.svg" />
							</figure>
						</div>
						<div class="order-opt" data-name="mount">
							<p>Крепление
							<span class="btn-small">Преимущества</span>
							</p>
							<figure class="option sel" data-value="flap">
								<figcaption>На створку</figcaption>
								<img src="<?php bloginfo('template_url') ?>/images/builder/opt-mnt-f.svg" />
							</figure>
							<figure class="option" data-value="open">
								<figcaption>На проем</figcaption>
								<img src="<?php bloginfo('template_url') ?>/images/builder/opt-mnt-w.svg" />
							</figure>
						</div>
						<div class="order-opt" data-name="equip">
							<p>Комплектация
							<span class="btn-small">Как выбрать?</span>
							</p>
							<figure class="option" data-value="inbox">
								<figcaption>В коробе</figcaption>
								<img src="<?php bloginfo('template_url') ?>/images/builder/opt-kit-b.svg" />
							</figure>
							<figure class="option sel" data-value="default">
								<figcaption>Без короба</figcaption>
								<img src="<?php bloginfo('template_url') ?>/images/builder/opt-kit-o.svg" />
							</figure>
						</div>
					</div>
					<div class="opt-head ruler">
						&nbsp;
					</div>
				</div>
				<div class="opt-row"><?php // Dimensions inputs ?>
					<p>
					<b>Размеры, количество, управление</b><br/>
					Перед простановкой размеров внимательно ознакомьтесь с инструкцией по замеру</p>
					<div class="opt-head">
						<div class="order-input">
							<label for="size_width">Ширина, см</label>
							<input type="text" class="udata digit" id="size_width" value="115"/>
						</div>
						<div class="order-input">
							<label for="size_height">Высота, см</label>
							<input type="text" class="udata digit" id="size_height" value="120"/>
						</div>
						<div class="order-input">
							<label for="count">Количество</label>
							<div class="spin">
								<span class="spin">&ndash;</span>
								<input type="text" class="spin digit" id="count" value="1" min="1" max="100"/>
								<span class="spin">+</span>
							</div>
						</div>
						<div class="order-input">
							<label for="control">Управление</label>
							<span id="control" class="udata pulld" data-value="man-right">справа</span>
							<span hidden data-owner="control" data-value="man-left">cлева</span>
							<span hidden data-owner="control" data-value="electro">дистанционное</span>
						</div>
						<div class="order-input">
							<div>Как правильно <br>
								сделать замеры?
							</div>
							<div>
								<a href="/instrukcii" target="_blank" disabled><img src="<?php echo get_template_directory_uri() ?>/images/icons/icon-doc.svg" /></a>
								<a href="#" target="_blank" disabled><img src="<?php echo get_template_directory_uri() ?>/images/icons/icon-play.svg" /></a>
							</div>
						</div>
					</div>		<!-- Dimensions inputs -->
				</div>		<!-- Dimensions input row -->
			</div>		<!--opt-list-->
		</div>		<!--part-wide-->
	</div>	<!-- builder -->
</div>	<!-- page-set -->
<div id="shop-order" class="bar-wide">
	<div class="header">
		<div>
			<div id="o-info" class="order-detail part-narrow">
				<label></label>
				<p></p>
			</div>
			<div id="o-total" class="order-detail">
				<label>Стоимость:</label>
				<p></p>
			</div>
			<div id="o-discnt" class="order-detail">
				<label>Скидка:</label>
				<p></p>
			</div>
			<div id="o-msg" class="order-detail">
				<label>
					Поделись ссылкой в соцсетях<br> и получи скидку 5%
				</label>
			</div>
			<div id="o-shop" class="order-detail">
				<div>
					<span class="btn btn-app o-check">Добавить</span>
					<a href="/cart" class="btn btn-app alt o-cart">Корзина</a>
				</div>
			</div>
		</div>
	</div>
</div>		<!-- shop-order -->
<div class="page-set">
	<?php 
		include('buildermod.php');
		// Sample content
//		$post = get_post(8032);
//		echo $post->post_content;
	?>
</div>
