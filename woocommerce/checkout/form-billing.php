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
?>
<div class="woocommerce-billing-fields">
	
	<h5>Данные получателя</h5>
	<div class="woocommerce-billing-fields__field-wrapper">
<?php
	$fields = $checkout->get_checkout_fields('billing');
	$fform = [ 'billing_first_name' => [],
				'billing_last_name' => [],
				'billing_company' => [],
				'billing_phone' => [],
				'billing_email' => [],
				'billing_address_1' => ['placeholder' => '']
			];

// log_write(var_export($fform,true));
	foreach ( $fform as $field => $def ) {
// log_write(var_export($def,true));
		$opts = $fields[$field];
		if ( count($def) > 0 ) {
			foreach ( $def as $k => $v) {
log_write($k.' '.$v);
				$opts[$k] = $v;
			}
log_write(var_export($opts, true));
		}
		woocommerce_form_field($field, $opts, $checkout->get_value($field));
// log_write("Field $field ".$fields[$field]['priority']);
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
?>
    <div class="clearfix"></div>
	<?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
</div>
<?php // if (!is_user_logged_in() && $checkout->is_registration_enabled()) : ?>
	<div class="woocommerce-account-fields">
		<?php // if (!$checkout->is_registration_required()) : ?>

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

		<?php // endif; ?>

		<?php do_action('woocommerce_before_checkout_registration_form', $checkout); ?>

		<?php //  if ($checkout->get_checkout_fields('account')) : ?>

			<div class="create-account">
				<?php foreach ($checkout->get_checkout_fields('account') as $key => $field) : ?>
					<?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
				<?php endforeach; ?>
				<div class="clear"></div>
			</div>

		<?php // endif; ?>

		<?php do_action('woocommerce_after_checkout_registration_form', $checkout); ?>
	</div>
<?php // endif; ?>
