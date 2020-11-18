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
// 	log_write( var_export( WC()->checkout['rpaefw_post_calc'], true) );
?>

<div class="woocommerce-billing-fields">
	<?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>
	
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
				'billing_city' => ['label' => 'Город'],
				'billing_address_1' => ['class' => array_push($fields['billing_address_1']['class'],'field-wide')],
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
		<p class="form-row form-row-wide form-group float-left" id="dadata_field" data-priority="110">
			<?php do_action('woocommerce_dadata', $checkout); ?>
		</p>
	</div>

<?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>

<div id="addressAlert">
	Не удалось рассчитать стоимость доставки по указанному адресу. Попробуйте уточнить адрес.
</div>

	<h5>Способ доставки</h5>
<input name="shipping_method" id="shipping_method" data-index="0" type="hidden" />

<div id="shp-list" class="cell-list woocommerce-billing-fields">
	<div class="cell-item shipping_method sel" data-index="6" data-method="local_pickup">
		<div class="cell-title">Самовывоз
		</div>
		<div class="cell-desc">Заберите товар со склада в течение 5 дней
		</div>
		<div class="cell-price">Бесплатно
		</div>
	</div>

	<div class="cell-item shipping_method" data-index="1" data-method="rpaefw_post_calc">
		<div class="cell-title">Доставка Почта России (EMS)
		</div>
		<div class="cell-desc">Доставка курьерской службой с трек-номером для отслеживания
		</div>
		<div class="cell-price">
		</div>
	</div>

	<div class="cell-item shipping_method" data-method="cdek" hidden>
		<div class="cell-title">Доставка СДЭК на ПВЗ
		</div>
		<div class="cell-desc"><a href="#">Выберите удобный для вас пункт выдачи заказов (ПВЗ) СДЭК</a>
		</div>
		<div class="cell-price">
		</div>
	</div>

	<div class="cell-item shipping_method" data-method="cdek" hidden>
		<div class="cell-title">Доставка СДЭК курьером
		</div>
		<div class="cell-desc">Доставим товар по вашему адресу
		</div>
		<div class="cell-price">
		</div>
	</div>

</div>

	<h5>Способы оплаты</h5>
<input name="payment_method" id="payment_method" data-index="0" type="hidden" />

<div id="pay-list" class="cell-list woocommerce-billing-fields">
<?php
	$available_gateways = WC()->payment_gateways->get_available_payment_gateways();
	if ( ! empty( $available_gateways ) ) {
		foreach ( $available_gateways as $gateway ) {
			wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
		}
	} else {
		apply_filters( 'woocommerce_no_available_payment_methods_message', esc_html__( 'Sorry, it seems that there are no available payment methods for your location. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) );
// 		echo 'Способы оплаты не определены',"\n";;
	}

?>
</div>

	<h5>Комментарий к заказу</h5>
<div id="addons" class="woocommerce-additional-fields">
<?php do_action( 'woocommerce_before_order_notes', $checkout ); ?>
	<label for="order_comments">Комментарий</label>
	<textarea name="order_comments" id="order_comments" rows="5" class="input-text form-control w-100" 
			placeholder="Примечания к вашему заказу, например, особые пожелания отделу доставки.">
	</textarea>
<?php do_action( 'woocommerce_after_order_notes', $checkout ); ?>
</div>


<h5>Отладочная информация</h5>
<div id="wc-out" style="font-size:75%;color:#000066;background-color:#cccccc;"></div>


<?php if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
	<div class="woocommerce-account-fields">
<?php if (!$checkout->is_registration_required()) : ?>
			<input class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
				type="hidden" value="1" 
				id="createaccount" name="createaccount"
<?php
			checked((true === $checkout->get_value('createaccount') 
				|| (true === apply_filters('woocommerce_create_account_default_checked', false))), true); 
?>
			/>
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

