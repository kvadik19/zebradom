<div id="dimmer" hidden></div>
<div id="o-confirm" class="popanel" hidden>
	<div class="closebox">&#10005;</div>
	<div id="cart-confirm" class="panel-content" style="display:none;">
		<h4>Параметры товара</h4>
		<h5>Внимательно проверь правильно ли сняты размеры,<br>сверившись с инструкцией</h5>
		<div class="o-content">
			<div id="o-img">
				<img src="<?php echo bloginfo('template_url') ?>/images/example/order-pt.jpg" class="img-fluid" />
				<img src="<?php echo bloginfo('template_url') ?>/images/example/order-pb.jpg" class="img-fluid" />
			</div><!-- pics part -->
			<div id="o-data">
				<ul>
				</ul>
				<div>
					<input type="checkbox" value="1" id="o-chk" />
					<label for="o-chk">
						Я проверил(а), всё верно
					</label>
				</div>
				<p class="o-total"></p>
				<p class="o-strike"></p>
				<p class="o-discnt"></p>
			</div><!-- text part-->
		</div><!-- content -->
		<div class="o-footer">
			<p class="o-confirm o-msg"></p>
			<div class="buttonbar">
				<span class="btn btn-app alt o-back">Продолжить покупки</span>
				<span id="o-add" class="btn btn-app">Добавить в корзину</span>
			</div>
		</div>
	</div><!-- cart-confirm -->
	<div id="cart-success" class="panel-content" style="display:none;">
		<h4>Товар добавлен в корзину</h4>
		<div id="item-show">
		</div>
		<div id="item-text">
			<div class="item-title">
				<p class="title"></p>
				<p class="subtitle"></p>
			</div>
			<div class="item-price">
				<p class="o-total"></p>
				<p class="o-strike"></p>
				<p class="o-discnt"></p>
			</div>
		</div>
		<div class="buttonbar">
			<span class="btn btn-app alt o-back">Продолжить покупки</span>
			<a href="/cart" class="btn btn-app o-cart">Перейти в корзину</a>
		</div>
	</div><!-- cart-success -->
</div><!-- panel -->
