jQuery(function ($) {
	// /cart page JS support
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
									} else {
										lineRecalc(i.dataset.id);
									}
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
	document.querySelectorAll('input[type="checkbox"].item-check').forEach( function(c) {
			c.addEventListener('change', function(e) {
						let mark = 0;
						if ( c.checked ) {
							c.title = titles['.'+c.className][1];
							mark = 1;
						} else {
							c.title = titles['.'+c.className][0];
						}
						clearTimeout(ajaxDelay);
						ajaxDelay = setTimeout( function() {
									$.ajax({'url': '/wp-admin/admin-ajax.php', 
											'data':{'action':'cart_hook', 'mode':'mark', 'mark':mark, 'id':c.dataset.id},				// See functions.php
											'type':'POST'
											} )
									.done( function(data) {
											if ( data ) {
// console.log(data);
												let mark = data.mark;
												totalRecalc(data.totals);
											}
									})
									.fail( function( jqxhr, textStatus, error) { console.log(textStatus+' : '+error); }
									);
							}, 500);
					});
		});

	let ajaxDelay = 0;
	var lineRecalc = function(id) {
			let qHost = document.getElementById(id).querySelector('.item-count input[type="text"]');
			let qty = qHost.value;
			let prc = document.getElementById(id).querySelector('.item-price').dataset.price;
			let dsp = document.getElementById(id).querySelector('.item-price span.woocommerce-Price-amount.amount');
			dsp.innerHTML = dsp.innerHTML.replace(/^[^<]+/, (qty*prc).toLocaleString('ru-RU')+'&nbsp;');		// Momentary display value

			clearTimeout(ajaxDelay);
			ajaxDelay = setTimeout( function() {
						$.ajax({'url': '/wp-admin/admin-ajax.php', 
								'data':{'action':'cart_hook', 'mode':'qty', 'qty':qty, 'id':id},				// See functions.php
								'type':'POST'
								} )
						.done( function(data) {
								if ( data && data.success ) {
// console.log(data);
									qHost.value = data.qty;
									let prc = data.item.line_total;				// Display Actually stored values
									let dsp = document.getElementById(id).querySelector('.item-price span.woocommerce-Price-amount.amount');
									dsp.innerHTML = dsp.innerHTML.replace(/^[^<]+/, prc.toLocaleString('ru-RU')+'&nbsp;');
									let cartCount = 0;
									document.querySelectorAll('.item-count input[type="text"]').forEach( i => cartCount += (i.value*1) );
									$('.cart-count').text( cartCount );
									totalRecalc(data.totals);
								}
						})
						.fail( function( jqxhr, textStatus, error) { console.log(textStatus+' : '+error); }
						);
				}, 500);
		};
	var totalRecalc = function(data) {
			Object.keys(data).forEach( k =>{
					let dsp = document.getElementById(k);
					if (dsp) {
						dsp = dsp.querySelector('span.woocommerce-Price-amount.amount');
						dsp.innerHTML = dsp.innerHTML.replace(/^[^<]+/, (data[k]*1).toLocaleString('ru-RU')+'&nbsp;');
					}
				});
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
