<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
	do_action( 'woocommerce_before_checkout_form', $checkout );
?>
	<h4 class="page-wide"><?php echo get_post(null, OBJECT)->post_title ?></h4>
	
<form class="checkout woocommerce-checkout woocommerce-cart-form page-wide cart-list" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" method="post">
	<div class=" page-part part-wide">

		<div id="order_review_heading" class="btn"><?php esc_html_e( 'Your order', 'woocommerce' ); ?>: 
			<?php echo WC()->cart->cart_contents_count,' ',plural_str(WC()->cart->cart_contents_count, ['товар', 'товара', 'товаров']) ?>
			на сумму <?php wc_cart_totals_order_total_html(); ?></div>

		<div id="order_review" class="pop-list" hidden>
<?php
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		echo '<div class="order-item" id="', $cart_item_key,'">';
		echo drawItem($cart_item);
		echo '</div>';
	}
?>
		</div><!-- pop-list -->

		<?php if ( $checkout->get_checkout_fields() ) : ?>

			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

			<div class="col2-set" id="customer_details">
				<div class="row">
					<div class="col-12">
						<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</div>
				</div>
			</div>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<?php endif; ?>
	</div><!-- part-wide, left-->

	<div class="page-part part-narrow">
		<div id="cart-total" class="cart-collaterals ">
			<div class="check">
				<div><?php esc_html_e( 'Your order', 'woocommerce' ); ?></div>
			</div>
			<div class="check cart-subtotal">
				<div><?php esc_html_e( 'Products', 'woocommerce' ); ?> (<span class="cart-count"><?php echo WC()->cart->cart_contents_count ?></span>)</div>
				<div id="subtotal" data-title="<?php esc_attr_e( 'Products', 'woocommerce' ); ?>"><?php echo WC()->cart->get_cart_subtotal(); ?></div>
			</div>

			<div class="check cart-shipping">
				<div><?php esc_html_e( 'Shipping', 'woocommerce' ); ?><span id="shipping_desc"></span></div>
				<div id="shipping" data-title="<?php esc_attr_e( 'Shipping', 'woocommerce' ); ?>"><?php echo WC()->cart->get_cart_shipping_total(); ?></div>
			</div>

			<div class="check order-total">
				<div><?php esc_html_e( 'Total', 'woocommerce' ); ?>:</div>
				<div  id="total" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></div>
			</div>

			<div class="wc-proceed-to-checkout">
				<a class="btn btn-app" href="#">Оплатить заказ</a>
			</div>
		</div>
	</div>	<!-- part-narrow -->
<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
</form>

<?php 
function drawItem( $item ) {
	global $modelKeys;
	global $wp;
	$codeRet = '';
	$_product = apply_filters( 'woocommerce_cart_item_product', $item['data'], $item, $item['key'] );
	if ( $_product && $_product->exists() && $item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $item, $item['key'] ) ) {
// log_write('Visibility '.$_product->is_visible());
		$codeRet .= '<div class="item-name">'.$_product->get_name().'</div>';
		$codeRet .= '<div class="item-count">'.$item['quantity'].'</div>';
		$codeRet .= '<div class="item-price">';
		$codeRet .= apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $item['quantity'] ), $item, $item['key'] );
		$codeRet .= "</div>\n";
	}
	return $codeRet;
}

?>

