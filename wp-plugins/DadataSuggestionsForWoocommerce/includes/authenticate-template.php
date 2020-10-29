<div style="max-width:600px;position:relative;margin: 30px 30px 30px 0;">
	<div id="lic_overlay" style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;background: #fff url('<?php echo plugins_url('ajax-loader.gif', __FILE__); ?>') no-repeat center;background: rgba(255,255,255,0.5) url('<?php echo plugins_url('ajax-loader.gif', __FILE__); ?>') no-repeat center;display: none;z-index: 5;"></div>
	<div style="background: #ddd;padding: 20px 30px;border-radius: 3px;overflow: hidden;">
		<div style="font-size: 16px;margin-bottom:20px;">
			<strong>Укажите полученный лицензионный ключ</strong>
		</div>
		<div style="">
			<input id="vsvse_key" type="text" value="" class="regular-text code">
			<input type="submit" id="vsvse_submit" class="button button-secondary" value="Активировать">
		</div>
		<div id="lic_message" style="display:none;padding:15px 5px 5px;"></div>
	</div>
</div>
<script type="text/javascript">
	jQuery(function() {
		jQuery("#vsvse_submit").on( "click", function(){

			jQuery("#lic_overlay").fadeIn();

			var data = {
				action		: "vsvse_authenticate_sent",
				serial_key 	: jQuery("#vsvse_key").val()					
			};
							
			jQuery.ajax({
				type: "POST",
				url: ajaxurl,
				dataType: "json",
				data: data,
				success: function(resp){
					if(resp.result == false) {
						jQuery("#lic_message").slideDown("fast").html("<span style='color:red;'>Нет связи с сервером. Обратитесть к администратору плагина</span>");	
					} else {
						jQuery("#lic_message").slideDown("fast").html(jQuery(resp.result.body).find(".result_msg").html());										
					}
				},
				error: function(resp){
					console.log(resp);
				},
				complete : function(){
					jQuery("#lic_overlay").fadeOut();
				}					
			});
		});
	});
</script>