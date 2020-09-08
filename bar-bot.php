<footer class="bar-wide">

	<div class="header">
		<a class="header-brand" href="/">
			<img src="<?php echo get_field('main_logo',$post_id); ?>" alt="">
			<small><?php  echo get_field('logo_text'); ?></small>
		</a>
		<?php
		echo wp_nav_menu([
			'theme_location' => 'foot_menu',
			'depth' => 1,
			'container' => 'div',
			'container_id' => 'bottomLinks',
			'container_class' => 'menu-bot',
			'menu_class' => 'menu-bot',
		]);
		?>
		<div class="footer-info">
			<section>		<!-- class="footer-contact" -->
				<a class="header-contact-item" href="<?php echo $href_viber ?>"><img src="<?php echo get_template_directory_uri() ?>/images/icons/viber.svg" class="icon" /></a>            
				<a class="header-contact-item" href="https://api.whatsapp.com/send?phone=<?php echo $phone_clean ?>&text=&source=&data=&app_absent=">
					<img src="<?php echo get_template_directory_uri() ?>/images/icons/whatsup.svg" class="icon" />
				</a>
				<span class="header-contact-item">
					<a class="header-phone-main" href="tel:<?php echo $phone_number ?>"><?php echo $phone_number ?></a>
					<small>Бесплатный звонок по РФ</small>
				</span>
			</section>
			<section class="header-user">		<!-- class="footer-contact" -->
				<a href="#" class="btn btn-callback" data-toggle="modal" data-target="#callback">
					<img src="<?php echo get_template_directory_uri() ?>/images/icons/phone.svg" class="icon" />Заказать звонок</a>
				<a href="mailto:<?php echo get_field('email_link', $post_id) ?>" class="btn btn-callback gray blank" >
					<img src="<?php echo get_template_directory_uri() ?>/images/icons/mailto.svg" class="icon" /><?php echo get_field('email_link', $post_id)?></a>
			</section>
					
			<section class="header-user">		<!-- class="footer-contact" -->
				<a class="header-contact-item" href="<?php echo get_field('vk_group_link', $post_id) ?>"><img src="<?php echo get_template_directory_uri() ?>/images/icons/vk.svg" class="icon" /></a>            
				<a class="header-contact-item" href="<?php echo get_field('inst_link', $post_id) ?>"><img src="<?php echo get_template_directory_uri() ?>/images/icons/twt.svg" class="icon" /></a>            
				<a class="header-contact-item" href="<?php echo get_field('youtube_channel_link', $post_id) ?>"><img src="<?php echo get_template_directory_uri() ?>/images/icons/yut.svg" class="icon" /></a>            
			</section>
			<br clear="all">
		<div class="footer-copyright">
			&copy; <?php echo date('Y') ?> Интернет магазин рулонных штор Zebradom.ru. Все права защищены.
			Запрещено любое копирование материалов ресурса без письменного согласия Zebradom.ru.
			Генеральный директор Филькин Валентин Геннадьевич.
			Адрес для корреспонденции и пожеланий: Московская область, г. Мытищи, ул.Летная. 19. оф.310.1
		</div>
		</div>		<!-- footer-info -->

	</div>	<!-- header -->
	<div class="header">
	</div>	<!-- header -->
</footer>		<!-- footer -->

<?php
// 				<div class="footer-info-socials">
// 					<a class="footer-phone" href="tel:<?php  echo get_field('phone_number_main', $post_id); ?-->" title="Бесплатный звонок по РФ"><?php  echo get_field('phone_number_main', $post_id); ?--></a>
// 					<div class="footer-phone-label">Бесплатный звонок по РФ</div>
// 					<div class="footer-contacts">
// 						<?php if(!empty(get_field('vk_group_link', $post_id))) : ?-->
// 							<a href="<?php echo get_field('vk_group_link', $post_id);?-->" target="_blank" title="Мы в ВК!"><span class=" icon-vk"></span></a>
// 						<?php  endif; ?-->
// 						<?php if(!empty(get_field('inst_link', $post_id))) : ?-->
// 							<a href="<?php echo get_field('inst_link', $post_id);?-->" target="_blank" title="Мы в Инстраграм!"><span class=" icon-ig"></span></a>
// 						<?php  endif; ?-->
// 						<?php if(!empty(get_field('youtube_channel_link', $post_id))) : ?-->
// 							<a href="<?php echo get_field('youtube_channel_link', $post_id);?-->" target="_blank" title="Смотрите нас на Youtube!"><span class=" icon-yt"></span></a>
// 						<?php  endif; ?-->
// 						if (!empty(get_field('email_link', $post_id))) :
// 							echo "<a class=\"footer-mail pull-right\" href=\"mailto:".get_field('email_link', $post_id)."\" title=\"Напишите нам!\">".get_field('email_link', $post_id)."</a>\n";
// 						endif
// 						</div>
// 					</div>
?>
