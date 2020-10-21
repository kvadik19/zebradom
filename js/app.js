/**
 * Application Script
 * Chiffa © 2019 http://goweb.pro
 */

jQuery(document).ready(function ($) {
	$('body').tooltip({
			selector: '[data-toggle=tooltip]'
		});

	$.ajaxSetup({dataType: 'json'});

	$('.woocommerce-input-wrapper > *').unwrap();
	$('.address-field').hide();

	jQuery("#lightgallery").lightGallery();

	document.querySelectorAll('.popanel .closebox').forEach( function(s) { 
// 					s.addEventListener('mouseup', function(e) { 
				// Use JQuery instead to emulate ability
					$(s).on('mouseup', function(e) { 
										let panel = findParentBy(e.target, function(o) { return o.className.match('popanel') } );
										document.getElementById('dimmer').hidden = true;
										panel.hidden = true;
									});
			} );

	document.querySelectorAll('input[type="text"].digit').forEach( function(d) {
					d.onkeypress = function(e) {
						if ( e.keyCode.toString().match(/^13|27|7$/) ) e.target.blur();		// Enter|Esc|Tab	(Esc ignored while focus())
						if ( e.keyCode < 48 || e.keyCode > 57 ) e.preventDefault();
					};
				});
});

function getCookie(c_name) {
	if (document.cookie.length > 0) {
		c_start = document.cookie.indexOf(c_name + '=');
		if (c_start != -1) {
			c_start = c_start + c_name.length + 1;
			c_end = document.cookie.indexOf(';', c_start);
			if (c_end == -1) {
				c_end = document.cookie.length;
			}
			let value = unescape(document.cookie.substring(c_start, c_end));
			if ( value.match(/^[\{\[].*[\}\]]$/) ) {
				try { value = JSON.parse(value) } catch(e) {};
			}
			return value;
		}
	}
	return '';
};

function setCookie(name, value, options) {		// https://learn.javascript.ru/cookie
	options = options || {};

	let expires = options.expires;

	if (typeof expires === 'number' && expires) {
		let d = new Date();
		d.setTime(d.getTime() + expires * 1000);
		expires = options.expires = d;
	}
	if (expires && expires.toUTCString) {
		options.expires = expires.toUTCString();
	}
	if ( typeof(value) === 'object' ) value = JSON.stringify(value);
	value = encodeURIComponent(value);
	let updatedCookie = name + '=' + value;
	for (let propName in options) {
		updatedCookie += ';' + propName;
		let propValue = options[propName];
		if (propValue !== true) {
		updatedCookie += '=' + propValue;
		}
	}
	document.cookie = updatedCookie;
}

function addAction(el, hdlr, callbk, prior) {			// To set queue of event handlers
	let proc = el[hdlr];
	if ( proc ) {
		if (prior) {
			el[hdlr] = function() { proc( callbk() ); };
		} else {
			el[hdlr] = function() { callbk( proc() ) };
		}
	} else {
		el[hdlr] = callbk;
	}
}

function getPosition ( element ) {
	let offsetLeft = 0, offsetTop = 0;
	do {
		offsetLeft += element.offsetLeft;
		offsetTop  += element.offsetTop;
		} while ( element = element.offsetParent );
	return [offsetLeft, offsetTop];
}

function findParentBy(node,code) {
	let parent = node.parentNode;
	try {
		if ( code(parent) ) {
			return parent;
		} else {
			return findParentBy(parent,code);
		}
	} catch(e) { return null }
}

function createObj(type, descr) {
	let inp = window.document.createElement(type);
	for ( let prop in descr ) {
		try { 
			eval('inp.'+prop+' = descr[prop]');
		} catch(e) {
			inp.setAttribute(prop, descr[prop] );
		}
	}
	return inp;
}

function hexToRgb(h) {
	if ( !h ) return 'rgba(0,0,0,0)';
	if ( h.match(/^rgb\(/) ) return h;
	if ( h.match(/^#/) ) h = h.replace(/^#/,'');
	let c = h.length / 3;		// Color value length
	let r = 'rgb(';
	for ( let n=0; n < h.length; n += c ) {
		let v = h.substr(n, c);
		if (c == 1) v += v;
		r += (parseInt(v,16) + ',');
	}
	r = r.replace(/,$/,'') + ')';
	return r;
}

function componentToHex(c) {
	if ( typeof(c) == 'string' ) {
		c *= 1;
	} else if ( typeof(c) == 'undefined' ) {
		c = 0;
	}
	var hex = c.toString(16);
	return hex.length == 1 ? "0" + hex : hex;
}

function rgbToHex(r, g, b) {
	if ( !r ) return '#000000';
	if ( r.match(/^#[A-F0-9]{3,6}$/i) ) {
		return r.replace(/^#([A-F0-9])([A-F0-9])([A-F0-9])$/,'#$1$1$2$2$3$3');		// From #rgb to #rrggbb
	}
	if ( r.match(/^rgb/i) ) {
		if (navigator.userAgent.match(/opera/i)) {
			var rgbs = r.match(/^rgb\D+(\d+)\D+(\d+)\D+(\d+)\D+/i);
			r = rgbs[1];
			g = rgbs[2];
			b = rgbs[3];
		} else {
			[ , r, g, b] = r.match(/^rgb\D+(\d+)\D+(\d+)\D+(\d+)\D+/i);		// Opera can't
		}
	} else if ( r.match(/^transpa/i) ) {
		return '#666666';
	}
	return '#' + componentToHex(r) + componentToHex(g) + componentToHex(b);
}
