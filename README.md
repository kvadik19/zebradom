# zebradom
## Тема zebradom_2020.ru для Wordpress
#### Рестайлинг сайта на базе темы zebradom_soft70.ru

### Шаблоны header.php и footer.php
В каждый шаблон отдельно подключатся bar-top.php и bar-bot.php соответственно. Сделано, в-основном, для удобочитаемости.
Обрывочные теги:
В header.php открывается 
```<section class="content">```
который закрывавется d footer.php
```</section>```

### Главная страница сайта - front-page.php
Конструктор вынесен в builder.php с возможностью замены на что-нибудь другое 

Изменения шаблонов
zebradom_2020.ru/woocommerce/cart
zebradom_2020.ru/woocommerce/checkout

### functions.php
Процесс загрузки стилей и скриптов по add_action('wp_enqueue_xxxxxx') управляется массивом $def_links, в котором подгружаемые элементы определяются по названию испольуемого шаблона
