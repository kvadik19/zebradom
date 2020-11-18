<?php
/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

defined( 'ABSPATH' ) || exit;

$notes = $order->get_customer_order_notes();
?>
<?php 	while(have_posts()) {
		the_post();
		?> 
		<div class="title-content">
			<h1 class="title-page"><?php the_title(); ?></h1>
			<div class="title-date">от <?php echo wc_format_datetime($order->get_date_created(), 'F j'); ?></div> 
		</div> 
<?php
	}
	?>	

<div class="right-menu">
	<div class="woocommerce-status"><?php echo wc_get_order_status_name( $order->get_status() );?></div>
	<div>
		 
	Товары	<?php //var_dump($order);?>
	</div>
	<div>
		<span>Доставка</span>	<span><?php echo wc_price($order->get_shipping_total());?></span>
	</div>
	<div>
		<span>Сумма:</span>	<span><?php echo wc_price($order->get_total());?></span>
	</div>
</div>

<?php
// printf(
// 	/* translators: 1: order number 2: order date 3: order status */
// 	esc_html__( 'Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce' ),
// 	'<mark class="order-number">' . $order->get_order_number() . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
// 	'<mark class="order-date">' . wc_format_datetime( $order->get_date_created() ) . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
// 	'<mark class="order-status">' . wc_get_order_status_name( $order->get_status() ) . '</mark>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
// );
?>
 

<?php if ( $notes ) : ?>
	<h2><?php esc_html_e( 'Order updates', 'woocommerce' ); ?></h2>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ( $notes as $note ) : ?>
		<li class="woocommerce-OrderUpdate comment note">
			<div class="woocommerce-OrderUpdate-inner comment_container">
				<div class="woocommerce-OrderUpdate-text comment-text">
					<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n( esc_html__( 'l jS \o\f F Y, h:ia', 'woocommerce' ), strtotime( $note->comment_date ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
					<div class="woocommerce-OrderUpdate-description description">
						<?php echo wpautop( wptexturize( $note->comment_content ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action( 'woocommerce_view_order', $order_id ); ?>

<div class="woocommerce-block">
	<h2 class="woocommerce-order-details__title">Получатель</h2>
	<div><?php echo $order->get_billing_first_name();?> <?php echo $order->get_billing_last_name();?></div>
	<?php if ( $order->get_billing_phone() ) : ?>
		<div class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></div>
	<?php endif; ?>
	<?php if ( $order->get_billing_email() ) : ?>
		<div class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></div>
	<?php endif; ?>
</div>

<div class="woocommerce-block">
	<h2 class="woocommerce-order-details__title">Способ получения</h2>
	<?php echo $order->get_payment_method_title();?>
</div>

<div class="woocommerce-block">
	<h2 class="woocommerce-order-details__title">Способ оплаты</h2>
	<?php echo $order->get_payment_method_title();?>
</div>

<div class="woocommerce-block">
	<h2 class="woocommerce-order-details__title">Комментарий</h2>
 
</div>