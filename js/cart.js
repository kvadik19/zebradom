jQuery(function ($) {
	document.getElementById('cart-total').style.top = (document.getElementById('bar-top').offsetHeight+10)+'px';
	let titles = {
					'.item-check':[	'Отметьте, если хотите заказать это прямо сейчас',
									'Снимите галочку, если не хотите заказывать это прямо сейчас' ],
					'.item-kill': ['Удалить это из корзины'],
				};
	Object.keys(titles)
			.forEach( k => { 
				document.querySelectorAll(k)
					.forEach(o =>{ 
							let tN = 0;
							let tSet = titles[k];
							if ( tSet.length > 1 ) {
								o.addEventListener('change', function(e) {
											if ( e.target.checked ) {
												e.target.title = tSet[1];
											} else {
												e.target.title = tSet[0];
											}
										});
								if (o.checked) tN = 1;
							}
							o.title = tSet[tN];
						})
			});

	document.querySelectorAll('div.spin').forEach( function(d) {
			let [min, max] = [-65535, 65535];
			let i = d.querySelector('input[type="text"].spin');
			if ( i.max ) max = i.max*1; 
			if ( i.min ) min = i.min*1;
			i.onfocus = function() { i.className = i.className.replace(/\s*rangeAlert/gi,'') };
			addAction(i, 'onchange', function() {
									if ( i.value*1 > max ) {
										i.value = max;
										i.className += ' rangeAlert';
									} else if ( i.value*1 < min ) {
										i.value = min;
										i.className += ' rangeAlert';
									}
									lineRecalc(i.dataset.id);
							}, 1);
			d.querySelectorAll('span.spin').forEach( function(s) {
					s.onmousedown = function() {
							i.className = i.className.replace(/\s*rangeAlert/gi,'');
							if ( s.innerText.match(/\+/) ) {
								i.value = (i.value*1) + 1;
							} else {
								i.value = (i.value*1) - 1;
							}
							i.onchange();
						};
				});
		});
	var lineRecalc = function(id) {
			let qty = document.getElementById(id).querySelector('.item-count input[type="text"]').value;
			let prc = document.getElementById(id).querySelector('.item-price').dataset.price;
			let dsp = document.getElementById(id).querySelector('.item-price span.woocommerce-Price-amount.amount');
			dsp.innerHTML = dsp.innerHTML.replace(/^[^<]+/, (qty*prc).toLocaleString('ru-RU')+'&nbsp;');
		};

	let screenKey = function(e) {			// Some keyboard operations while order confirmation window open
			switch( e.keyCode ) {
				case 27:			// Esc
					closePop();
					break;
			};		/* keyCodes case switcher */
		};
	let closePop = function() {			// Hide order confirmation window
			document.removeEventListener('keydown', screenKey);
			$('#alert .closebox').mouseup();
		};

	document.getElementById('alrt-esc').onmouseup = closePop;
	document.querySelectorAll('.item-kill').forEach( c =>{
			c.addEventListener('mouseup', function(e) {
					let host = e.target;
					document.querySelector('#alert p.alrt-text').innerHTML = host.previousElementSibling.innerHTML +'?';
					document.getElementById('dimmer').hidden = !document.getElementById('dimmer').hidden;
					document.getElementById('alert').hidden = !document.getElementById('alert').hidden;
					document.addEventListener('keydown', screenKey);
					
					document.getElementById('alrt-do').onmouseup = function() {
							$.ajax({'url': '/wp-admin/admin-ajax.php', 
									'data':{'action':'cart_hook', 'mode':'rm', 'id':host.dataset.id},				// See functions.php
									'type':'POST'
									} )
							.done( function(data) {
									if ( data && data.success ) {
										let row = document.getElementById(data.item.key);
										row.className += ' rollOut';
										window.setTimeout( function() { row.parentNode.removeChild(row) }, 600);
									}
									closePop();
							})
							.fail( function( jqxhr, textStatus, error) { console.log(textStatus+' : '+error); closePop(); }
							);
						};
				});
		});

});
