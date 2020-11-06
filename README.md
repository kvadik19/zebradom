# zebradom
## Тема zebradom_2020.ru для Wordpress
#### Рестайлинг сайта на базе темы zebradom_soft70.ru

### Шаблоны header.php и footer.php
В каждый шаблон отдельно подключаются **bar-top.php** и **bar-bot.php** соответственно. Сделано, в-основном, для удобочитаемости.

Обрывочные теги:
В **header.php** открывается 
```
<section class="content">
```
который закрывавется в **footer.php**
```
</section>
```

### Главная страница сайта - front-page.php
Конструктор вынесен в builder.php с возможностью замены на что-нибудь другое 

Изменения шаблонов
```
zebradom_2020.ru/woocommerce/cart
zebradom_2020.ru/woocommerce/checkout
```
### functions.php
Процесс загрузки стилей и скриптов по `add_action('wp_enqueue_xxxxxx')` управляется массивом **$def_links**, в котором подгружаемые элементы определяются по названию используемого шаблона

### plugins
В директорию темы добавлена поддиректория `wp-plugins`, в которой хранятся измененные по каким-либо причинам плуги. Для работы wordpress с директории `wp-content/plugins` создаются симлинки

### woocommerce
Перемещение функционала woocommerce из стандартного URL `/cart` в `/checkout` согласно дизайн-проекта, связано с изменением frontend .php и .js скриптов.
В разделе "Оформление заказа" содержимое скрипта `wp-content/plugins/woocommerce/assets/js/frontend/cart.js` перенесено в `wp-content/themes/zebradom_2020.ru/js/check.js`.
Изменения в `wp-content/plugins/woocommerce/includes/class-wc-frontend-scripts.php:~515` - добавлен параметр, передаваемый объектом wc_checkout_params
`
	case "wc-checkout":
	$params = array(
	"update_shipping_method_nonce" => wp_create_nonce( "update-shipping-method" ),
		...
	);
`