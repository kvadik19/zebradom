jQuery(function ($) {
	// /checkout page JS
	document.getElementById('cart-total').style.top = (document.getElementById('bar-top').offsetHeight+10)+'px';
	let hideView = function(evt) {
						evt.stopImmediatePropagation();
						if ( evt.path.findIndex( function(itm) { return (itm.id === 'order_review') }) > -1 ) return;
						document.getElementById('order_review_heading').className = document.getElementById('order_review_heading').className.replace(/\s*on/g,'');
						document.getElementById('order_review').hidden = true;
						document.removeEventListener('click', hideView);
					};
	document.getElementById('order_review_heading').onclick = function(e) {
									e.stopImmediatePropagation();
									if ( this.className.match(/on/) ) {
										this.className = this.className.replace(/\s*on/g,'');
										this.nextElementSibling.hidden = true;
									} else {
										this.className += ' on';
										this.nextElementSibling.hidden = false;
										document.addEventListener('click', hideView);
									}
								};
});
