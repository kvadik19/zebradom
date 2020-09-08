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

do_action( 'woocommerce_before_cart' ); ?>

<h4 class="text-center text-uppercase font-weight-bold">Оформление заказа:</h4>
<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
    <div class="product-list">
        <?php do_action( 'woocommerce_before_cart_contents' ); ?>

        <?php
        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $_product_parent = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            if(!empty($_product->get_parent_id())){
                $_product_parent = wc_get_product( $_product->get_parent_id() );
            }
            
            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                ?>
                <div class="product-list-item woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                    <div class="product-list-item-remove">
                        <?php
                        echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                            'woocommerce_cart_item_remove_link',
                            sprintf(
                                '<a href="%s" aria-label="%s" data-product_id="%s" data-product_sku="%s"><button type="button" class="close"><span aria-hidden="true">&times;</span></button></a>',
                                esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                esc_html__( 'Remove this item', 'woocommerce' ),
                                esc_attr( $product_id ),
                                esc_attr( $_product->get_sku() )
                            ),
                            $cart_item_key
                        );
                        ?>
                    </div>
                    <div class="product-list-item-image">
                        <?php
                        $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

                        if ( ! $product_permalink ) {
                            echo $thumbnail; // PHPCS: XSS ok.
                        } else {
                            printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
                        }
                        ?>
                    </div>
                    <div class="product-list-item-info">
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="list-unstyled">
                                    <li>Изделие: <?=do_excerpt( $_product_parent->get_name(), 3)?></li>
                                    <li>Материал: <?=get_field('cloth', $_product_parent->get_id())->post_title?></li>
                                    <li>Ширина по замеру: <?=get_field('width', $_product_parent->get_id())?> см.</li>
                                    <li>Высота по замеру: <?=get_field('height', $_product_parent->get_id())?> см.</li>
                                    <li>Габаритная ширина:  см.</li>
                                    <li>Габаритная высота:  см.</li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-unstyled">
                                    <li>Ширина ткани: <?=get_field('width', $_product_parent->get_id())?> см.</li>
                                    <li>Высота управления: <?=get_field('height', $_product_parent->get_id())?> см.</li>
                                    <?

                                        $item_id = ( !empty( $cart_item['variation_id'] ) ) ? $cart_item['variation_id'] : '';
                                        if ( !empty( $item_id ) ) {
                                        
                                        $variations = get_variation_data_from_variation_id( $item_id );
                                        echo '<li>' . $variations . '</li>';
                                        
                                        }
                                        else{
                                            echo ' <li>Цвет комплектации: Белый</li>';
                                        }

                                        
                                    
                                    
                                    ?>
                                    <li>Моторизация: <?=get_field('control', $_product_parent->get_id()) == 'electro' ? 'Да' : 'Нет'?></li>
                                    <li>Разворот ткани: Расчет ткани по ширине</li>
                                    <li>Намотка ткани: Прямая</li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <div class="product-list-item-count shop-params">
                        <div class="form-group text-center">
                            <label>Количество:</label>
                            <div class="input-group">
                                <?php
                                if ( $_product->is_sold_individually() ) {
                                    $product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
                                } else {
                                    $product_quantity = woocommerce_quantity_input(
                                        array(
                                            'classes' => "form-control",
                                            'input_name'   => "cart[{$cart_item_key}][qty]",
                                            'input_value'  => $cart_item['quantity'],
                                            'max_value'    => $_product->get_max_purchase_quantity(),
                                            'min_value'    => '0',
                                            'product_name' => $_product->get_name(),
                                        ),
                                        $_product,
                                        false
                                    );
                                }
                                echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="product-list-item-price">
                        <strong class="text-muted">Цена:</strong> <?= $_product->get_price() * $cart_item['quantity']?> руб.
                    </div>
                </div>
                <?/*<tr class="">
                    <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
                    <?php
                    if ( ! $product_permalink ) {
                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                    } else {
                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                    }

                    do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

                    // Meta data.
                    echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

                    // Backorder notification.
                    if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
                        echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
                    }
                    ?>
                    </td>

                    <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">

                    </td>


                    </td>

                    <td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
                        <?php
                            echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                        ?>
                    </td>
                </tr>*/
                
               
                
                ?>
                <?php
            }
           ?>
           <? 
        }
        ?>

        <?php do_action( 'woocommerce_cart_contents' ); ?>

        <tr>
            <td colspan="6" class="actions">

                <?php if ( wc_coupons_enabled() ) { ?>
                    <div class="coupon">
                        <label for="coupon_code"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label> <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" /> <button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
                        <?php do_action( 'woocommerce_cart_coupon' ); ?>
                    </div>
                <?php } ?>

                <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

                <?php do_action( 'woocommerce_cart_actions' ); ?>

                <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
            </td>
        </tr>

        <?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</div>
	<?php do_action( 'woocommerce_after_cart_table' ); ?>
</form>

<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
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

<?php do_action( 'woocommerce_after_cart' ); ?>
