<?php
/* ====================================
 * Plugin Name: Подсказки Dadata для Woocommerce
 * Description: Подключает подсказки сервиса DaData.ru к странице оформления заказа WooCommerce
 * Plugin URI: https://1cbonus.ru/product/plagin-podskazok-dadata-woocommerce/
 * Author: Anton Loktionov
 * Author URI: https://1cbonus.ru
 * Version: 1.0
 * ==================================== */

//Класс проверки скрипта
if ( ! class_exists( 'Request_VerstaemVse' ) ) {
	class Request_VerstaemVse {

		//адрес сервера где осуществляется проверка
		private $api_url = 'http://api.1cbonus.ru';

		function __construct() {

			$this->site_url = home_url();

			//название метода проверки и версия скрипта/плагина (см. скриншот в архиве)
			$this->id_plugin = 'id_plugin_or_scripts';
			$this->id_plugin_ver = 'id_plugin_or_scripts_v_1';

			//временные ключи которые используются при проверке
			$this->trans_key = 'wc_name_key';
			$this->trans_result = 'wc_name_result';

			//период провеки серийного ключа, по умолчанию 1 раз в день
			$this->day_scan = 1;

			add_action('wp_ajax_vsvse_authenticate_sent', array($this, 'vsvse_authenticate_sent'));

			//если ключа во временной переменной нет то покажем форму активации скрипта/плагина
			if( get_transient( $this->trans_key ) === false ) {

				add_action( 'admin_menu',  array($this, 'vsvse_authenticate') );

			} else {

				//иначе если ключ есть, но нет возвращаемого кода при успешной проверке ключа, отправим запрос на получение кода из метода проверки
				if( get_transient( $this->trans_result ) === false ) {

					//получаем ответ от сервера
					$result = $this->result_body(true, get_transient( $this->trans_key ));

					//если ответ отрицательный то удалим из временных переменных и ключ и возращаемый код из базы сайта
					// после чего отобразится форма активации
					if($result['body'] == 'valid_false') {
						delete_transient($this->trans_key);
						delete_transient($this->trans_result);
					} else {
						//если ответ отличный от того что выше то создадим временную переменную на срок определенный выше
						set_transient( $this->trans_result, $result['body'], $this->day_scan * DAY_IN_SECONDS );
					}
				}
			}

		}

		//Создадим в консоле меню для ввода серийного ключа
		function vsvse_authenticate(){
/* 			add_menu_page( 
				'Регистрация серийного ключа Плагин подсказок Dadata для Woocommerce',
				'Подсказки Dadata',
				'manage_options', 
				'ddtsug_plugin',
				array( $this, 'yandex_authenticate_form')
			); */
		}

		//Сам запрос к серверу проверки серийного ключа, плюс передаем некоторую информацию о клиенте
		function result_body($check, $s_key) {
		
			$result = wp_remote_post($this->api_url, array(
				'method'      => 'POST',
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'body'        => array(
							'site_url' 		=> $this->site_url, // адрес сервера проверки, указан выше
							'serial_key' 	=> $s_key, // серийный ключ
							'ip_addr' 		=> $_SERVER["REMOTE_ADDR"], 
							'server_name' 	=> $_SERVER["SERVER_NAME"],
							'ip_server' 	=> $_SERVER["SERVER_ADDR"],
							'folder_server' => $_SERVER["DOCUMENT_ROOT"],
							'last_scan' 	=> Date('d.m.Y H:i'),
							'id_plugin' 	=> $this->id_plugin, // индентификатор плагина, указанвыше
							'id_plugin_ver' => $this->id_plugin_ver, //версия плагина, указана выше
							'check' 		=> $check, // параметр, определяющий первая ли это активация плагина или периодическая проверка
							'password' 		=> 'password_1111' //какой-нибудь пароль который проверяется на сервере, защита от ботов,
																	// если пароль не совпадет в с паролем в файле проверки на сервере то скрипт просто не будет выполнятся.
						),
				'cookies'     => array(),
				'ssl_verify' => false		
			));

			if ( is_wp_error( $result ) ) {
   				return $result->get_error_message(); // если ошибка, покажим ее
   			} else {
				return $result; // если все хорошо вернем результат
   			}
		}

		// AJAX функция обработки формы и серийного ключа
		function vsvse_authenticate_sent() {	    

			//получаем ответ от сервера передавае ему серийный ключ, false значит что это проверка в первые
			$result = $this->result_body(false, $_POST['serial_key']);

			//если ответ не равен массиву то в скрипт (authenticate-template.php) вернем false и там его обработаем
			if(gettype($result) != 'array') {
					echo json_encode(array('result' => false));
			} else {

				//иначе рабем разбирать ответ от сервера
				//отделим возращаемый кусок php кода указанный в методе проверки
				preg_match_all( '|<result_code.*?>(.*)</result_code>|sei', $result['body'], $matches );

				//если кусок кода есть то сохраним ключ и полученный код во временные переменные
				if(isset($matches[1][0])) {
					set_transient( $this->trans_key, $_POST['serial_key'] );
					set_transient( $this->trans_result, $matches[1][0], $this->day_scan * DAY_IN_SECONDS );
					echo json_encode(array('result' => $result, 'result_code' => $matches[1][0]));
				} else {
					//иначе просто вернем ответ от сервера и обработаем в скрипте
					echo json_encode(array('result' => $result));
				}
			}
			wp_die();
		}

		//подключим шаблон формы активации
		function yandex_authenticate_form() {
			include 'includes/authenticate-template.php';
		}

	}
}

$Request_VerstaemVse = new Request_VerstaemVse();
require_once( plugin_dir_path(__FILE__) . '/includes/function.php' );