	</div>
</section>
<?php
	$post_id = 6869;
	$phone_number = get_field('phone_number', $post_id);
	$phone_clean = preg_replace("/[-+)(]/", "", $phone_number);
	$href_viber = "viber://chat?number=+$phone_clean";
	$expand_button = '';
	if (check_mobile_device()) {
		$href_viber = "viber://add?number=$phone_clean";
		$expand_button = '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" '.
						'aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">'.
						'<span class="navbar-toggler-icon"></span><button>';
	}
	include( 'bar-bot.php' );
?>

		<div class="modal fade" id="callback" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Обратный звонок</h4>
						<button type="button" id="close-callback" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body d-none-call">
						<?phpdo_shortcode('[contact-form-7 id="4108" title="Форма обратной связи"]')?>

					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="master" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Заказать мастера</h4>
						<button type="button" id="close-master" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body d-none-call">
						<?phpdo_shortcode('[contact-form-7 id="5165" title="Форма заказа мастера"]')?>
					</div>
				</div>
			</div>
		</div>
		<!-- Photoswipe -->
		<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="pswp__bg"></div>
			<div class="pswp__scroll-wrap">
				<div class="pswp__container">
					<div class="pswp__item"></div>
					<div class="pswp__item"></div>
					<div class="pswp__item"></div>
				</div>
				<div class="pswp__ui pswp__ui--hidden">
					<div class="pswp__top-bar">
						<div class="pswp__counter"></div>
						<button class="pswp__button pswp__button--close" title="Закрыть (Esc)"></button>
						<button class="pswp__button pswp__button--share" title="Поделиться"></button>
						<button class="pswp__button pswp__button--fs" title="Полноэкранный режим"></button>
						<button class="pswp__button pswp__button--zoom" title="Масштаб увеличить/уменьшить"></button>
						<div class="pswp__preloader">
							<div class="pswp__preloader__icn">
								<div class="pswp__preloader__cut">
									<div class="pswp__preloader__donut"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
						<div class="pswp__share-tooltip"></div>
					</div>
					<button class="pswp__button pswp__button--arrow--left" title="Назад (стрелка влево)"></button>
					<button class="pswp__button pswp__button--arrow--right" title="Далее (стрелка вправо)"></button>
					<div class="pswp__caption">
						<div class="pswp__caption__center"></div>
					</div>
				</div>
			</div>
		</div>
<?php
		if(is_home() || is_page_template('page-index') || is_front_page()) {
?>
			<div class="modal fade" id="clothInfo" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Ткань <span class=cloth-info-title></span></h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-6">
									<div class="cloth-info-full-image">
										<div class="img-zoom-container">
											<img id="clothImg" class="zoom" rel="adjustX: 10, adjustY:-4" alt="" src="">
											<div id="clothImgResult" class="img-zoom-result"></div>
										</div>
									</div>
									<div class="cloth-info-thumbs">
										<div class="cloth-info-thumb">
											<img alt="" src="">
										</div>
									</div>
								</div>
								<div class="col-6 cloth-info-attributes">
									<div class="row">
										<div class="col-6">Наименование</div>
										<div class="col-6 cloth-info-name"></div>
									</div>
									<div class="row">
										<div class="col-6">Артикул</div>
										<div class="col-6 cloth-info-vendor-code"></div>
									</div>
									<div class="row">
										<div class="col-6">Категория</div>
										<div class="col-6 cloth-info-cat"></div>
									</div>
									<div class="row">
										<div class="col-6">Единица измерения</div>
										<div class="col-6 cloth-info-unit"></div>
									</div>
									<div class="row">
										<div class="col-6">Прозрачность</div>
										<div class="col-6 cloth-info-transparent"></div>
									</div>
									<div class="row">
										<div class="col-6">Ширина рулона</div>
										<div class="col-6 cloth-info-width"></div>
									</div>
									<div class="row">
										<div class="col-6">Структура</div>
										<div class="col-6 cloth-info-structure"></div>
									</div>
									<div class="row">
										<div class="col-6">Вес, г/м2</div>
										<div class="col-6 cloth-info-weight"></div>
									</div>
									<div class="row">
										<div class="col-6">Пригодность для влажных помещений</div>
										<div class="col-6 cloth-info-wet-rooms"></div>
									</div>
									<div class="row">
										<div class="col-6">Стойкость к выгоранию</div>
										<div class="col-6 cloth-info-fade-resistance"></div>
									</div>
									<div class="row">
										<div class="col-6">Уход и чистка</div>
										<div class="col-6 cloth-info-wash"></div>
									</div>
									<div class="row">
										<div class="col-6">Цвет</div>
										<div class="col-6 cloth-info-color"></div>
									</div>
									<div class="row">
										<div class="col-6">Страна происхождения</div>
										<div class="col-6 cloth-info-country"></div>
									</div>
									<div class="row">
										<div class="col-6">Сертификация</div>
										<div class="col-6 cloth-info-certification"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="goToCart" tabindex="-1" role="dialog" aria-hidden="true" data-info="goToCart">
			<div class="modal-dialog modal-md modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-body">
						<div style="display: flex;justify-content: space-between;flex-wrap: wrap;">
							<button type="button" class="btn btn-lg btn-korzina mt-2 text-nowrap goToCart-close">Продолжить покупки</button>
							<a href="/cart">
								<button type="button" class="btn btn-lg btn-success mt-2 text-nowrap">Перейти в корзину
								</button>
							</a>
						</div>
					</div>
				</div>
			</div>
<?php
		}
		/**
		* Получает информацию обо всех зарегистрированных размерах картинок.
		*
		* @global $_wp_additional_image_sizes
		* @uses   get_intermediate_image_sizes()
		*
		* @param  boolean [$unset_disabled = true] Удалить из списка размеры с 0 высотой и шириной?
		* @return array Данные всех размеров.
		*/
		/*function get_image_sizes( $unset_disabled = true ) {
			$wais = & $GLOBALS['_wp_additional_image_sizes'];

			$sizes = array();

			foreach ( get_intermediate_image_sizes() as $_size ) {
				if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
					$sizes[ $_size ] = array(
						'width'  => get_option( "{$_size}_size_w" ),
						'height' => get_option( "{$_size}_size_h" ),
						'crop'   => (bool) get_option( "{$_size}_crop" ),
					);
				}
				elseif ( isset( $wais[$_size] ) ) {
					$sizes[ $_size ] = array(
						'width'  => $wais[ $_size ]['width'],
						'height' => $wais[ $_size ]['height'],
						'crop'   => $wais[ $_size ]['crop'],
					);
				}

				// size registered, but has 0 width and height
				if( $unset_disabled && ($sizes[ $_size ]['width'] == 0) && ($sizes[ $_size ]['height'] == 0) )
					unset( $sizes[ $_size ] );
			}

			return $sizes;
		}

		die( print_r( get_image_sizes() ) );*/
?>
		<script>
			let template_url = '<?php bloginfo('template_url')?>';
		</script>
		<?php  wp_footer() ?>
	</body>
<html>
<?php  /*
<script src="/js/jquery.2.1.0.min.js"></script> 
<script src="/js/bootstrap.min.js"></script>
*/ ?>
