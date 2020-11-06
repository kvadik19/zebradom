<?php
/**
 * Checkout billing information form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-billing.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 * @global WC_Checkout $checkout
 */
defined('ABSPATH') || exit;
// log_write(var_export($checkout->get_checkout_fields(),true));
// 	log_write( var_export( WC()->checkout['rpaefw_post_calc'], true) );
?>

<div class="woocommerce-billing-fields">
	
	<h5>Данные получателя</h5>
	<div class="woocommerce-billing-fields__field-wrapper">
<?php
	$fields = $checkout->get_checkout_fields('billing');
	$fform = [ 'billing_first_name' => [],
				'billing_last_name' => [],
				'billing_company' => [],
				'billing_state' => [],
				'billing_postcode' => [],
				'billing_country' => [],
				'billing_phone' => [],
				'billing_email' => [],
				'billing_address_1' => ['placeholder' => ''],
			];

	foreach ( $fform as $field => $def ) {
		$opts = $fields[$field];
		if ( count($def) > 0 ) {
			foreach ( $def as $k => $v) {
				$opts[$k] = $v;
			}
		}
		woocommerce_form_field($field, $opts, $checkout->get_value($field));
	}
?>
		<p class="form-row form-row-wide form-group float-left" id="billing_email_field" data-priority="110">
			<?php do_action('woocommerce_dadata', $checkout); ?>
		</p>
	</div>
	<h5>Город доставки</h5>
		<label for="billing_city">Город</label>
<?php woocommerce_form_field('billing_city', 
							['label' => '','class' => array_push($fields['billing_city']['class'],'field-wide')], 
							$checkout->get_value('billing_city'));
	do_action('woocommerce_after_checkout_billing_form', $checkout);
?>
</div>

	<h5>Способ доставки</h5>
<input name="shipping_method" id="shipping_method" data-index="0" type="hidden" />

<div class="shp-list">
	<div class="shp-item shipping_method sel" data-method="local_pickup">
		<div class="shp-title">Самовывоз
		</div>
		<div class="shp-desc">Заберите товар со склада в течение 5 дней
		</div>
		<div class="shp-price">Бесплатно
		</div>
	</div>

	<div class="shp-item shipping_method" data-method="rpaefw_post_calc:8">
		<div class="shp-title">Доставка Почта России (EMS)
		</div>
		<div class="shp-desc">Доставка курьерской службой с трек-номером для отслеживания
		</div>
		<div class="shp-price">
		</div>
	</div>

	<div class="shp-item shipping_method" data-method="cdek">
		<div class="shp-title">Доставка СДЭК на ПВЗ
		</div>
		<div class="shp-desc"><a href="#">Выберите удобный для вас пункт выдачи заказов (ПВЗ) СДЭК</a>
		</div>
		<div class="shp-price">
		</div>
	</div>

	<div class="shp-item shipping_method" data-method="cdek">
		<div class="shp-title">Доставка СДЭК курьером
		</div>
		<div class="shp-desc">Доставим товар по вашему адресу
		</div>
		<div class="shp-price">
		</div>
	</div>

</div>

<div id="wc_reply" >
</div>


<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
	<div class="woocommerce-account-fields">
		<?php if (!$checkout->is_registration_required()) : ?>

			<p class="form-row form-row-wide create-account">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
							id="createaccount" <?php checked((true === $checkout->get_value('createaccount') || (true === apply_filters('woocommerce_create_account_default_checked',
								false))), true); ?>
							type="checkbox"
							name="createaccount"
							value="1"/> <span><?php esc_html_e('Create an account?', 'woocommerce'); ?></span>
				</label>
			</p>

		<?php endif; ?>

		<?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

		<?php if ($checkout->get_checkout_fields('account')) : ?>

			<div class="create-account">
				<?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
					<?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php endif; ?>

		<?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
	</div>
<?php endif; ?>

