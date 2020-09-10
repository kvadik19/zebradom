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

    $(document).on('click', '.js-shop-count-down', function () {
        let target = $('#' + $(this).data('target'));
        if (target.length) {
            let newVal = parseInt(target.val()) - 1;
            target.val((newVal < 0) ? 0 : newVal);
            target.trigger('change');
        }
        return false;
    });
    $(document).on('click', '.js-shop-count-up', function () {
        let target = $('#' + $(this).data('target'));
        if (target.length) {
            let newVal = parseInt(target.val()) + 1;
            target.val(newVal);
            target.trigger('change');
        }
        return false;
    });
    jQuery("#lightgallery").lightGallery(); 
    
});

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
