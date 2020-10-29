<?php

function ddtsug_woo_fields_start() {

	if(get_option('ddtsug_woo_need_name')!=true) {
		echo '<input id="fullname" name="fullname" type="text" size="57" placeholder="Введите Ваше имя и фамилию"/>';
	}
	if(get_option('ddtsug_woo_need_address')!=true) {
?>
        <label for="address" class="w-100">Адрес&nbsp;<abbr class="required" title="обязательно">*</abbr></label>
        <input type="email" class="input-text form-control w-100" name="address" id="address" placeholder="Введите Ваш адрес в произвольной форме" value="" autocomplete="address">
<?php
	}
	if(get_option('ddtsug_woo_need_phone')!=true) {
		echo '<div style="margin-top: 10px;"> </div>';
		echo '<input id="phone" name="phone" type="text" size="57" placeholder="Введите Ваш номер телефона"/>';
	}
	if(get_option('ddtsug_woo_need_email')!=true) {
		echo '<div style="margin-top: 10px;"> </div>';
		echo '<input id="email" name="email" type="text" size="57" placeholder="E-mail адрес"/>';
	}
	if(get_option('ddtsug_woo_need_spoiler')==true) {
		echo '<div class="ddtsugspoiler ddtsugclosed">
<div class="ddtsugtitle"><div class="ddtsugtitle_h3">Подробная информация о заказе (заполняется автоматически)</div></div>
<div class="ddtsugcontents">';
	}

}

//проверяем существуют ли переменные с ключем и ответом отсервера,
//если есть то выполняем тот код который получили от сервера.
//Код может быть любым в данном случаем сервер из метода проверки должен вернуть следующий код:
//	add_action( 'admin_menu',  'test_menu_page' );
/* if( get_transient( 'wc_name_key' ) !== false && get_transient( 'wc_name_result' ) !== false ) {
	$return = get_transient( 'wc_name_result' );
	eval($return);
} */

add_action('woocommerce_dadata', 'ddtsug_woo_fields_start');

function ddtsug_woo_fields_end() {
	if(get_option('ddtsug_woo_need_spoiler')==true) {
	echo '</div></div>';
}


}
add_action('woocommerce_after_checkout_billing_form', 'ddtsug_woo_fields_end');

function ddtsug_woo_adding_scripts() {
	wp_register_script('ddtsug_woo_script', plugins_url('DadataSug.js', __FILE__), '', '', true);
	log_write('Load Suggs from '.plugins_url('DadataSug.js', __FILE__) );
	wp_enqueue_script('ddtsug_woo_script');
}

add_action( 'wp_enqueue_scripts', 'ddtsug_woo_adding_scripts' );

function ddtsug_woo_adding_styles() {
wp_register_style('ddtsug_woo_stylesheet', plugins_url('DadataSug.css', __FILE__));
wp_enqueue_style('ddtsug_woo_stylesheet');
}

add_action( 'wp_enqueue_scripts', 'ddtsug_woo_adding_styles' );

function ddtsug_woo_add_scripts() {
	$script_params = [
						'token_key' => get_option('ddtsug_woo_key')
					];
	echo '<link href="https://cdn.jsdelivr.net/jquery.suggestions/16.6/css/suggestions.css" type="text/css" rel="stylesheet" />'."\n".
		'<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>'."\n".
		'<!--[if lt IE 10]>'."\n".
		'<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>'."\n".
		'<![endif]-->'."\n".
		'<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.suggestions/16.6/js/jquery.suggestions.min.js"></script>'."\n";

	wp_localize_script( 'ddtsug_woo_script', 'scriptParams', $script_params );
}

add_action( 'woocommerce_after_checkout_form', 'ddtsug_woo_add_scripts' );

//чек-боксы---------------------------------------------------------
function ddtsug_woo_settings_checkboxes_page() {
	add_settings_section("ddtsug_woo_checkboxes_section", "Настройки вывода", null, "ddtsug_woo_settings");
	add_settings_field("ddtsug_woo_need_name", "НЕ выводить поле Имя Фамилия", "ddtsug_woo_checkbox_name_display", "ddtsug_woo_settings", "ddtsug_woo_checkboxes_section");
	register_setting("ddtsug_woo_checkboxes_section", "ddtsug_woo_need_name");

	add_settings_field("ddtsug_woo_need_address", "НЕ выводить поле Адрес", "ddtsug_woo_checkbox_address_display", "ddtsug_woo_settings", "ddtsug_woo_checkboxes_section");
	register_setting("ddtsug_woo_checkboxes_section", "ddtsug_woo_need_address");

	add_settings_field("ddtsug_woo_need_email", "НЕ выводить поле E-mail", "ddtsug_woo_checkbox_email_display", "ddtsug_woo_settings", "ddtsug_woo_checkboxes_section");
	register_setting("ddtsug_woo_checkboxes_section", "ddtsug_woo_need_email");

	add_settings_field("ddtsug_woo_need_phone", "НЕ выводить поле Телефон", "ddtsug_woo_checkbox_phone_display", "ddtsug_woo_settings", "ddtsug_woo_checkboxes_section");
	register_setting("ddtsug_woo_checkboxes_section", "ddtsug_woo_need_phone");

	add_settings_field("ddtsug_woo_need_spoiler", "Спрятать стандартные поля под спойлер", "ddtsug_woo_checkbox_spoiler_display", "ddtsug_woo_settings", "ddtsug_woo_checkboxes_section");
	register_setting("ddtsug_woo_checkboxes_section", "ddtsug_woo_need_spoiler");

}

function ddtsug_woo_checkbox_name_display() {
	?>
	<!-- Here we are comparing stored value with 1. Stored value is 1 if user checks the checkbox otherwise empty string. -->
	<input type="checkbox" name="ddtsug_woo_need_name" value="1" <?php checked(1, get_option('ddtsug_woo_need_name'), true); ?> />
	<?php
}

function ddtsug_woo_checkbox_address_display()
{
	?>
	<input type="checkbox" name="ddtsug_woo_need_address" value="1" <?php checked(1, get_option('ddtsug_woo_need_address'), true); ?> />
	<?php
}

function ddtsug_woo_checkbox_email_display()
{
	?>
	<input type="checkbox" name="ddtsug_woo_need_email" value="1" <?php checked(1, get_option('ddtsug_woo_need_email'), true); ?> />
	<?php
}
function ddtsug_woo_checkbox_phone_display()
{
	?>
	<input type="checkbox" name="ddtsug_woo_need_phone" value="1" <?php checked(1, get_option('ddtsug_woo_need_phone'), true); ?> />
	<?php
}
function ddtsug_woo_checkbox_spoiler_display()
{
	?>
	<input type="checkbox" name="ddtsug_woo_need_spoiler" value="1" <?php checked(1, get_option('ddtsug_woo_need_spoiler'), true); ?> />
	<?php
}


add_action("admin_init", "ddtsug_woo_settings_checkboxes_page");


function ddtsug_woo_checkbox_page()
{
	?>
	<div class="wrap">
<!--		<h1>Demo</h1>-->


		<?php
		settings_fields("ddtsug_woo_checkboxes_section");

		do_settings_sections("ddtsug_woo_settings");

		//submit_button();
		?>

	</div>
	<?php
}





add_action('admin_menu', 'ddtsug_woo_mt_add_pages');

function ddtsug_woo_mt_add_pages() {
	// Add a new submenu under Options:
	add_options_page('Подсказки DaData.ru', 'Подсказки DaData.ru', 8, 'ddtsug_woo_settings', 'mt_options_page');
}

function ddtsug_woo_settings() {
	echo "<h2>Подсказки DaData.ru</h2>";
}

// mt_options_page() displays the page content for the Test Options submenu
/**
 *
 */
function mt_options_page() {

	// variables for the field and option names
	$opt_name = 'ddtsug_woo_key';
	$hidden_field_name = 'ddtsug_woo_submit_hidden';
	$data_field_name = 'ddtsug_woo_key';

	//нужно ли поле Имя
	$opt_need_name = 'ddtsug_woo_need_name';
	$opt_need_address = 'ddtsug_woo_need_address';
	$opt_need_email = 'ddtsug_woo_need_email';
	$opt_need_phone = 'ddtsug_woo_need_phone';
	$opt_need_spoiler = 'ddtsug_woo_need_spoiler';

	// Read in existing option value from database
	$opt_val = get_option( $opt_name );

	// See if the user has posted us some information
	// If they did, this hidden field will be set to 'Y'
	if( $_POST[ $hidden_field_name ] == 'Y' ) {
		// Read their posted value
		$opt_val = $_POST[ $data_field_name ];

		// Save the posted value in the database
		update_option( $opt_name, $opt_val );

		update_option( $opt_need_name,      $_POST[ $opt_need_name ] );
		update_option( $opt_need_address,   $_POST[ $opt_need_address ] );
		update_option( $opt_need_email,     $_POST[ $opt_need_email ] );
		update_option( $opt_need_phone,     $_POST[ $opt_need_phone ] );
		update_option( $opt_need_spoiler,   $_POST[ $opt_need_spoiler ] );


		// Put an options updated message on the screen

		?>
		<div class="updated"><p><strong><?php _e('Настройки сохранены.', 'mt_trans_domain' ); ?></strong></p></div>

		<?php

	}

	// Now display the options editing screen

	echo '<div class="wrap">';

	// header

	echo "<h2>" . __( 'Настройки плагина Подсказки DaData.ru', 'mt_trans_domain' ) . "</h2>";

	// options form

	?>

	<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

		<p><?php _e("Токен, полученный в сервисе DaData.ru:", 'mt_trans_domain' ); ?>
			<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="50">
		</p><hr />
		<?php
		ddtsug_woo_checkbox_page();
		?>


		<p class="submit">
			<input type="submit" name="Submit" value="<?php _e('Сохранить изменения', 'mt_trans_domain' ) ?>" />
		</p>

	</form>
	</div>

<?php }
?>
