<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-edit-account.php.
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

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' ); ?>

<h1 class="title-page">Мои данные</h1>


<form class="woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>
	
	<div class="woocommerce-form-row">
		<label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
	</div>

	<div class="woocommerce-form-row">
		<label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?></label>
		<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
	</div>

	<div class="woocommerce-form-row">
        <label for="middle_name">Отчество</label>
        <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="middle_name" id="middle_name" value="<?php echo esc_attr( $user->middle_name ); ?>" />
	</div>

	<input type="hidden" readonly class="woocommerce-Input woocommerce-Input--text input-text" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> 

	<div class="woocommerce-form-row">
		<label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?></label>
		<input type="email" class="woocommerce-Input woocommerce-Input--email input-text" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
	</div>

	<div class="woocommerce-form-row">
        <label for="billing_phone">Телефон</label>
		<input type="text" class="woocommerce-Input woocommerce-Input--phone input-text" name="billing_phone" id="billing_phone" value="<?php echo esc_attr( $user->billing_phone ); ?>" />
	</div>

	<div class="woocommerce-form-row" id="dadata_field">
        <label for="address">Адрес доставки</label>
		<input type="text" class="woocommerce-Input woocommerce-Input--adres input-text" name="address" id="address" value="<?php echo esc_attr( $user->address ); ?>" />
	</div>

	<div class="password-btn"><span>Изменить пароль</span><span style="display: none;">Скрыть изменение пароля</span></div>

	<div class="content-password" style="display: none;" >
		<fieldset>
			<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide align-items-center">
				<label for="password_current">Старый пароль</label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_current" id="password_current" autocomplete="off" />
			</div>
			<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide align-items-center">
				<label for="password_1">Новый пароль</label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_1" id="password_1" autocomplete="off" />
			</div>
			<div class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide align-items-center">
				<label for="password_2">Новый пароль еще раз</label>
				<input type="password" class="woocommerce-Input woocommerce-Input--password input-text" name="password_2" id="password_2" autocomplete="off" />
			</div>
		</fieldset>
	</div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<div>
		<?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
		<button type="submit" class="woocommerce-Button button btn-app" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>">Сохранить</button>
		<input type="hidden" name="action" value="save_account_details" />
	</div>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>
</form>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>

 