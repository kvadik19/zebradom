jQuery(document).ready(function ($) {
		$(".ddtsugclosed").toggleClass("show");
		$(".ddtsugtitle").click(function () {
				$(this).parent().toggleClass("show").children("div.ddtsugcontents").slideToggle("medium");
				if ( $(this).parent().hasClass("show") ) {
					$(this).children(".ddtsugtitle_h3").css("background", "rgb(253, 253, 253)");
				} else {
					$(this).children(".ddtsugtitle_h3").css("background", "rgb(240, 238, 238)");
				}
			});
	});

function join(arr /*, separator */) {
	var separator = arguments.length > 1 ? arguments[1] : ", ";
	return arr.filter(function (n) {
		return n
	}).join(separator);
}

$("#fullname").suggestions({
		serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
		token: scriptParams.token_key,
		type: "NAME",
		/* Вызывается, когда пользователь выбирает одну из подсказок */
		onSelect: function (suggestion) {
// 				console.log(suggestion);
				var fullname = suggestion.data;

				$("#billing_first_name").val(fullname.name);
				$("#billing_last_name").val(fullname.surname);

			}
	});


$("#address").suggestions({
		serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
		token: scriptParams.token_key,
		type: "ADDRESS",
		/* Вызывается, когда пользователь выбирает одну из подсказок */
		onSelect: function (suggestion) {
// 			console.log(suggestion);
			var address = suggestion.data;
			$("#billing_postcode").val(address.postal_code);
			$("#billing_state").val(
				join([address.region_type, address.region], " ")
			);
			$("#billing_city").val(join([
				join([address.area_type, address.area], " "),
				join([address.city_type, address.city], " "),
				join([address.settlement_type, address.settlement], " ")
			]));
			$("#billing_address_1").val(join([
				join([address.street_type, address.street], " "),
				join([address.house_type, address.house], " "),
				join([address.block_type, address.block], " "),
				join([address.flat_type, address.flat], " ")
			]));
			$("#billing_postcode").trigger("update_checkout");
		}
	});

$("#email").suggestions({
		serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
		token: scriptParams.token_key,
		type: "EMAIL",
		/* Вызывается, когда пользователь выбирает одну из подсказок */
		onSelect: function (suggestion) {
// 			console.log(suggestion);
			var email = suggestion.data;
			$("#billing_email").val(email.local + "@" + email.domain);
		}
	});

$('#phone').on('input', function (e) {
		$('#billing_phone').value = this.value;
	});
