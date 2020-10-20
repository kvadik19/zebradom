<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit;

// do_action( 'woocommerce_before_cart' ); 
?>

	<h4 class="page-wide">Корзина</h4>
	<form class="woocommerce-cart-form page-wide cart-list" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<?php // do_action( 'woocommerce_before_cart_contents' ); ?>
	<div class=" page-part part-wide">
<?php
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		echo '<div class="cart-item" id="', $cart_item_key,'">';
		echo drawItem($cart_item);
		echo '</div>';
	}
?>
	</div>	<!-- part-wide -->

	<div class="page-part part-narrow">
<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
		<div id="cart-total" class="cart-collaterals ">
			<?php
				/**
				* Cart collaterals hook.
				*
				* @hooked woocommerce_cross_sell_display
				* @hooked woocommerce_cart_totals - 10
				*/
				do_action( 'woocommerce_cart_collaterals' );
			?>
		</div>
	</div>	<!-- part-narrow -->
</form>	<!-- cart-list-->

<?php 
do_action( 'woocommerce_after_cart' ); 

function pureName( $clo ) {
	global $modelKeys;
	$rg = '/\s*('.$clo['fields']['цвет']
			.'|'.$clo['fields']['вид_модели']
			.'|'.$modelKeys['type']['name'][$clo['fields']['вид_модели']]
		.')\s*/i';
	$title = preg_replace($rg, ' ', $clo['post_title']);
	return preg_replace('/^\s+|\s+$/', '', $title);
};

function drawItem( $item ) {
	global $modelKeys;
	global $title_check;
	$codeRet = '';
	$_product = apply_filters( 'woocommerce_cart_item_product', $item['data'], $item, $item['key'] );

// log_write(var_export($_product,true));

	if ( $_product && $_product->exists() && $item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $item, $item['key'] ) ) {
		$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $item ) : '', $item, $item['key'] );

		$codeRet .= '<div class="item-mark"><input type="checkbox" class="item-check" checked data-id="'.$item['key'].'" /></div>';

		$cloth = get_cloth( get_field('cloth', $item['product_id'])->ID)[0];

		$thumbnail = '<img src="'.$cloth['gallery'][0].'" title="'.$cloth['post_title'].'"/>';
		if ( $product_permalink ) {
			$thumbnail = sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
		}
		$codeRet .= '<div class="item-thumb">'.$thumbnail."</div>\n";

		$codeRet .= '<div class="item-info"><div>';
		$codeRet .= '<b>Штора '.$modelKeys['type']['name'][$cloth['fields']['вид_модели']].'</b><br>';
		$codeRet .= $_product->get_name().'<br>';
		$codeRet .= 'Ткань &laquo;'.pureName($cloth).'&raquo;, '.get_field('width', $item['product_id']).'x'.get_field('height', $item['product_id']).' см., ';
		$codeRet .= 'цвет '.$cloth['fields']['цвет'].', управление '.$modelKeys['control']['name'][get_field('control', $item['product_id'])].'</div>';
		$codeRet .= '<span class="item-kill" data-id="'.$item['key'].'">Удалить';
		$codeRet .= "</span></div>\n";

		$codeRet .= '<div class="item-count"><div class="spin">';
		$codeRet .= '<span class="spin">&ndash;</span>';
		$codeRet .= '<input type="text" class="spin digit" data-id="'.$item['key'].'" value="'.$item['quantity'].'" min="1" max="100"/>';
		$codeRet .= "<span class=\"spin\">+</span></div></div>\n";
		
		$codeRet .= '<div class="item-price" data-price="'.$_product->get_price().'">';
		$codeRet .= '<p class="o-total">'.apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $item['quantity'] ), $item, $item['key'] ).'</p>';
		$codeRet .= '<p class="o-strike"></p>';
		$codeRet .= '<p class="o-discnt"></p>';
		$codeRet .= "</div>\n";
// 			<td class="product-name" data-title="esc_attr_e( 'Product', 'woocommerce' ); ">
// 			
// 			if ( ! $product_permalink ) {
// 				echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $item, $item['key'] ) . '&nbsp;' );
// 			} else {
// 				echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $item, $item['key'] ) );
// 			}
// 
// 			// do_action( 'woocommerce_after_cart_item_name', $item, $item['key'] );
// 
// 			// Meta data.
// 			echo wc_get_formatted_cart_item_data( $item ); // PHPCS: XSS ok.
// 
// 			// Backorder notification.
// 			if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $item['quantity'] ) ) {
// 				echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
// 			}
// 			</td>
// 
// 			<td class="product-price" data-title="<php esc_attr_e( 'Price', 'woocommerce' ); >">
// 					echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $item, $item['key'] ); // PHPCS: XSS ok.
// 			</td>
// 
// 			<td class="product-quantity" data-title="<? esc_attr_e( 'Quantity', 'woocommerce' ); >">
// 			if ( $_product->is_sold_individually() ) {
// 				$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $item['key'] );
// 			} else {
// 				$product_quantity = woocommerce_quantity_input(
// 					array(
// 						'input_name'   => "cart[{$item['key']}][qty]",
// 						'input_value'  => $item['quantity'],
// 						'max_value'    => $_product->get_max_purchase_quantity(),
// 						'min_value'    => '0',
// 						'product_name' => $_product->get_name(),
// 					),
// 					$_product,
// 					false
// 				);
// 			}
// 
// 			echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $item['key'], $item ); // PHPCS: XSS ok.
// 			</td>
// 
// 			<td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); >">
// 					echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $item['quantity'] ), $item, $item['key'] ); // PHPCS: XSS ok.
// 				>
// 			</td>
// 		</tr>
	}
	return $codeRet;
}

?>
<div id="dimmer" hidden></div>
<div id="alert" class="popanel float" hidden>
	<div class="closebox">&#10005;</div>
	<div class="panel-content">
		<h4>Желаете удалить из корзины заказа</h4>
		<p class="alrt-text"></p>
		<div class="buttonbar">
			<span id="alrt-esc" class="btn btn-app alt">Нет</span>
			<span id="alrt-do" class="btn btn-app">Удалить</span>
		</div>
	</div>
</div>
