<div id="bar-top" class="bar-wide">
	<div class="menubar">
		<div class="header">
			<div class="menu-spacer"><?php echo $expand_button ?>
			</div>
			<div class="menu-main">
	<!-- 			<div class="navbar navbar-expand-lg navbar-light"> -->
	<!-- 				<div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
					<?php
					echo wp_nav_menu([
						'theme_location' => 'main_menu',
						'depth' => 0,
						'container' => 'div',
						'container_id' => 'navbarSupportedContent',
						'container_class' => 'menu-main-hor',
						'menu_class' => 'menu-main-hor',
	// 					'link_before' => '<span>',
	// 					'link_after' => '<span>',
	// 					'walker' => new wp_bootstrap_navwalker()
					]);
					?>
	<!-- 			</div> -->
			</div>
			<div class="menu-search">
				<div class="input-search"></div>
				<img src="<?php echo get_template_directory_uri() ?>/images/icons/findglass.svg" class="icon" />
			</div>
		</div>
	</div>
	<!--/ MAIN NAV -->
	<div class="header">

		<a class="header-brand" href="/">
			<img src="<?php echo get_field('main_logo',$post_id); ?>" alt="">
			<small><?php  echo get_field('logo_text'); ?></small>
		</a>
		<div class="header-main">
<!-- 			<div class="header-contacts"> -->
			<section>
				<a class="header-contact-item" href="<?php echo $href_viber ?>"><img src="<?php echo get_template_directory_uri() ?>/images/icons/viber.svg" class="icon" /></a>            
				<a class="header-contact-item" href="https://api.whatsapp.com/send?phone=<?php echo $phone_clean ?>&text=&source=&data=&app_absent=">
					<img src="<?php echo get_template_directory_uri() ?>/images/icons/whatsup.svg" class="icon" />
				</a>
				<span class="header-contact-item">
					<a class="header-phone-main" href="tel:<?php echo $phone_number ?>"><?php echo $phone_number ?></a>
					<small>Бесплатный звонок по РФ</small>
				</span>
			</section>

			<section>
				<a href="#" class="btn btn-callback" data-toggle="modal" data-target="#callback">
					<img src="<?php echo get_template_directory_uri() ?>/images/icons/phone.svg" class="icon" />Заказать звонок</a>
				<a href="#" class="btn btn-callback gray" data-toggle="modal" data-target="#callback">
					<img src="<?php echo get_template_directory_uri() ?>/images/icons/measure.svg" class="icon" />Вызвать замерщика</a>
			</section>
		</div>

		<div class="header-user">
<!-- 			<section> -->
				<?php if(is_user_logged_in()) {?>
				<a class="btn header-link " href="<?php echo get_page_link(51) ?>">
					<img src="<?php echo get_template_directory_uri() ?>/images/icons/ucab.svg" class="icon" />
					Личный кабинет
				</a>
				<?php } else {?>
				<span class="btn header-link xoo-el-login-tgr">
					<img src="<?php echo get_template_directory_uri() ?>/images/icons/ucab.svg" class="icon" />
					Войти
				</span>
				<?php } ?>
				<a class="btn header-link" href="/cart">
					<img src="<?php echo get_template_directory_uri() ?>/images/icons/cart.svg" class="icon" />
					<span  class="cart-count"><?php echo WC()->instance()->cart->cart_contents_count ?></span>
					Корзина
				</a>
<!-- 			</section> -->
		</div>
<!-- 			</div> -->
	</div>
</div><!-- bar-fixed -->
<!-- MAIN NAV -->
