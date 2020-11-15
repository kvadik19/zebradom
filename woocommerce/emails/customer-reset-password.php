<?php
/**
 * Customer Reset Password email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-reset-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates/Emails
 * @version 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

<?php do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer username */ ?>
<p>Здравствуйте!</p>
<?php /* translators: %s: Store name */ ?>
<p>Вы (или кто-то другой) посылали запрос на восстановление пароля на сайте zebradom.ru.</p>
<?php /* translators: %s: Customer username */ ?>


<p>Для генерации нового пароля перейдите по <a class="link xoo-el-login-tgr" href="<?php echo esc_url( add_query_arg( array( 'key' => $reset_key, 'id' => $user_id ), wc_get_endpoint_url( 'lost-password', '', wc_get_page_permalink( 'home' ) ) ) ); ?>">ссылке</a>
</p>
<p>Если Вы этого не делали, просто проигнорируйте это письмо</p>
<?php
 

do_action( 'woocommerce_email_footer', $email );
