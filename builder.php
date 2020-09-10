<?php
	$clothes = get_cloth($type);
?>
	<script>
		var activeCloth = <?php echo isset($_GET['cloth']) ? $_GET['cloth'] : $clothes[0]['ID'];?>;		// 
		var cloths = {'<?php echo $type ?>':<?php echo json_encode($clothes) ?>};
		var activeModelType = '<?php echo $type ?>';
	</script>
	<div class="builder">
		<div class="builder-wide">
			<h4>Рулонные шторы. Практично, удобно, стильно!</h4>
			<span>Конструктор поможет выбрать индивидуальное интерьерное решение</span>
		</div>
		<div class="builder-part builder-left">
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
		<div class="builder-part builder-right">
			<div class="opt-list">
				<div class="opt-row">
					<div class="opt-head" id="listInfo">
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
							<span data-filter="origin" class="pulld">Страна-производитель</span>
							<span data-filter="opacity" class="pulld">Светопроницаемость (%)</span>
							<span data-filter="colorCode" data-ref="colorName" class="pulld">Цвет</span>
							<span data-filter="texture" class="pulld">Текстура</span>
						</div>
					</div>
					<div class="cloth-list">
						<div class="builder-loading d-none"><img src="<?php bloginfo('template_url') ?>/images/builder/loading.gif" alt=""/></div>
						<ul class="cloth-list">
<?php
foreach ($clothes as $item) {
	$short_title = preg_replace('/\s*зебра\s*/i', '', $item['post_title']);
	echo '<li class="cloth-list-item" id="clo_',$item['ID'],'" style="background-image:url(\'',$item['gallery'][0],'\')"';		//  data-toggle="tooltip"
	echo 'title="',$short_title,'" data-cloth-id="',$item['ID'],'" data-texture-lvt="',$item['texture_lvt'],'" data-texture-mini="',$item['texture_mini'],'" ';
	echo 'data-texture-uni="',$item['texture_uni'],'" data-cat="',$item['fields']['категория'],'" data-short-title="',$short_title,'" data-title="',$item['post_title'],'" ';
	echo 'data-vendor-code="',$item['vendor_code'][0],'" data-color-cloth="',$item['fields']['цвет'],'">';
	echo '<i aria-hidden="true" class="clo-info"><img src="',bloginfo('template_url'),'/images/icons/findglass.svg" /></i>';
	echo '<input hidden type="radio" class="form-check-input" name="cloth" value="',$item['ID'],'" />';
	echo "</li>\n";
}
?>
						</ul>
					</div>		<!--cloth-list-->
					<div class="opt-head ruler">
						<span id="collapseAll" class="filter-switch expand-list" hidden>Свернуть список</span>
					</div>
				</div>		<!--opt-row -->
				<div class="opt-row">
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
				</div>
			</div>		<!--opt-list-->
		</div>		<!--builder-right-->
		<div class="builder-wide">
		<?php // echo '<code>'.var_export($clothes).'</code>' ?>
		
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
		</div>
	</div>
	<?php // include('buildermod.php') ?>

