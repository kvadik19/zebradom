<div class="modals" id="buildermod">
	<div class="info" data-info="clothes">
		<div class="info-content">
			<div class="info-header">
				<button type="button" class="close" data-dismiss="info" aria-label="Close">
					Закрыть <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="info-body">
				<ul class="cloth-list cloth-list-full">
<?php
foreach ($clothes as $item) {
	echo "<li>";
	echo '<a href="#" title="',$item['post_title'],'" data-cloth-id="',$item['ID'],'" data-texture-lvt="',$item['texture_lvt'],'" data-texture-mini="',$item['texture_mini'],'" ';
	echo 'data-texture-uni="',$item['texture_uni'],'" data-cat="',$item['fields']['категория'],'" data-short-title="',$item['post_title'],'" data-title="',$item['post_title'],'" ';
	echo 'data-vendor-code="',$item['vendor_code'][0],'" data-color-cloth="',$item['fields']['цвет'],'">';

	echo $item['preview'];
	echo '<i aria-hidden="true" class="fa fa-info"></i>';

	echo '</a>';
	echo '<input hidden type="radio" class="form-check-input" name="cloth" value="',$item['ID'],'" />';
	echo "</li>\n";
}
?>
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
							<li>Ширина по габариту: <span class="js-order-confirm-width"></span> см.</li>
							<li>Ширина по ткани: <span class="js-order-confirm-width-gb"></span> см.</li>
							<li>Высота по замеру: <span class="js-order-confirm-height"></span> см.</li>
							<li>Высота по габариту: <span class="js-order-confirm-height-gb"></span> см.</li>
							<li>Высота по габариту: <span class="js-order-confirm-height"></span> см.</li>
							<li>Высота управления: <span class="js-order-confirm-height-upr"></span> см.</li>
							<li>Цвет комплектации: <span>белый</span></li>
							<li>Управление: <span class="js-order-confirm-electro"></span></li>
							<!-- <li>Разворот ткани: <span>Расчет ткани по ширине</span></li>
							<li>Намотка ткани: <span>Прямая</span></li> -->
						</ul>
						<p class="help-block">*точный отеннок ткани может быть искажен экраном каждого компьютера и настроек браузера. 
							Обращаем ваше внимание, что данные вашего предварительного заказа не являются публичной офертой.</p>
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
								<button type="submit" class="btn btn-lg btn-block btn-korzina btn-order">Добавить
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