/**
 * Application Script
 * Chiffa © 2019 http://goweb.pro
 */

jQuery(function ($) {
    let $activeClothUrl = null;
    /**
     * Info blocks
     */
    $("[data-info-target]").on("click", function () {
        let target = $(this).data("info-target");
        let container = $(".js-builder-info");
        $("[data-info]", container).hide();
        $("[data-info=" + target + "]", container).show();
        container.addClass("show");
        return false;
    });
    $("[data-dismiss]", ".js-builder-info").on("click", function () {
        let container = $(".js-builder-info");
        $(this).parents("[data-info]").hide();
        container.removeClass("show");
    });
    $(".goToCart-close").on("click", function () {
        $("[data-info=goToCart]").hide();
    });

    /**
     * Builder
     */
    $("form").keydown(function (event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            return false;
        }
    });
	let canvas = document.querySelector('canvas#canvas');
// 	let renderer;
	renderer = new THREE.WebGLRenderer({
						canvas: canvas,
						preserveDrawingBuffer: true
					});

	let windows = {
		white: {
			"color": "FFFFFF",
			"name": "Белый"
		},
		oaklight: {
			"color": "BE8E58",
			"name": "Дуб светлый"
		},
		oakgold: {
			"color": "7C491C",
			"name": "Золотой дуб"
		},
		mahagon: {
			"color": "380805",
			"name": "Махагон"
		},
		brown: {
			"color": "371305",
			"name": "Коричневый"
		},
		black: {
			"color": "060A06",
			"name": "Черный",
		},
		antracit: {
			"color": "3D4344",
			"name": "Антрацит"
		},
		gray: {
			"color": "97A3A5",
			"name": "Серый"
		}
	};
	
	let activeBGColor = "rgb(221,221,221)";
	let activeWindowColor = "white";
	let activeState = "CLOSE";
	let activeModelColor = "white";


	// Initial values
	// var activeModelType always declared in .php
	var activeClothOpacity;
    var activeModelMount = $('.order-opt[data-name="mount"] .sel').data('value');
    var activeModelEquip = $('.order-opt[data-name="equip"] .sel').data('value');
	var activeClothColors = [];
    var activeWidth = 120;
    var activeHeight = 120;
    var activeControl = true;
    var activeCount = 1;

	let sample = document.getElementById('color-wall');
	let callWallColor = function(evt) { 
			evt.stopImmediatePropagation();
			let pckr = document.querySelector('#f-picker');
			if ( !pckr ) {
				pckr = createObj('div',{'id':'f-picker','hidden':true});	//
				this.parentNode.appendChild(pckr);
			}
			if ( !pckr.hidden ) {
				pckr.hidden = true;
				return;
			}
			pckr.hidden=false;
			let hideMe = function(evt) {
								evt.stopImmediatePropagation();
								if ( evt.path.findIndex( function(itm) { return (itm.id == 'f-picker') }) > -1 ) return;
								document.getElementById('f-picker').hidden = true;
								document.removeEventListener('click', hideMe);
							};
			let picker = $.farbtastic(pckr);
			picker.setColor( rgbToHex(sample.style.backgroundColor) );
			picker.linkTo( function(clr) {
										sample.style.backgroundColor = clr;
										activeBGColor = clr;
									});
			document.addEventListener('click', hideMe);
			
		};
	sample.parentNode.addEventListener('click', callWallColor);		// Whole zone clickable

	var fieldsOpt = [
			{'name':'density', 'field':'вес_гм2', 'title':''},
			{'name':'type', 'field':'вид_модели', 'title':''},
			{'name':'unit', 'field':'единица_измерения', 'title':''},
			{'name':'pictLVT', 'field':'изображение_lvt', 'title':''},
			{'name':'pictMINI', 'field':'изображение_mini', 'title':''},
			{'name':'pictUNI', 'field':'изображение_uni', 'title':''},
			{'name':'class', 'field':'категория', 'title':'Категория'},
			{'name':'waterproof', 'field':'пригодность_для_влажных_помещений', 'title':''},
			{'name':'opacity', 'field':'прозрачность', 'title':''},
			{'name':'certified', 'field':'сертификация', 'title':''},
			{'name':'sunproof', 'field':'стойкость_к_выгоранию', 'title':''},
			{'name':'origin', 'field':'страна_происхождения', 'title':''},
			{'name':'texture', 'field':'структура', 'title':'Текстура'},
			{'name':'care', 'field':'уход_и_чистка', 'title':''},
			{'name':'colorName', 'field':'цвет', 'title':''},
			{'name':'colorCode', 'field':'цвет_для_фильтра', 'title':''},
			{'name':'width', 'field':'ширина_рулона', 'title':''},	
			{'name':'motive', 'field':'тема_рисунка', 'title':''},			// Not implemented yet!
			{'name':'popularity', 'field':'популярность', 'title':''},			// Not implemented yet!
		];

	var applyFilter = function() {
			let param = {};
			let checked = document.querySelectorAll('#filterCloth ul.poplist li.on:not([data-value="*"])');
			if ( checked.length > 0 ) {
				document.getElementById('filterRst').hidden = false;
				checked.forEach(
								function(li) {
									let key = li.parentNode.id.replace(/_pd$/,'');
									if ( !param[key] ) param[key] = { 'field':fieldsOpt.find( function(o) { return o.name==key } ).field, 'values':[] };
									param[key].values.push( li.dataset.value );
								}
							);
			} else {
				document.getElementById('filterRst').hidden = true;
			}

			activeClothColors = [];
			Object.keys(param).forEach( function(k) {		// Preflight params
										if ( k.match(/color/i) ) {		// Some special processing
											activeClothColors = param[k].values;
										}
									});
			
			let keys = Object.keys(param) ;
			let selectCount = 0;

			cloths[activeModelType].forEach( function(c) {
					let li = document.getElementById('clo_'+c.ID);
					li.hidden = true;
					let match = 0;			// AND condition matches count
					for ( let kN=0; kN < keys.length; kN++ ) {
						let name = keys[kN];
						let field = param[keys[kN]].field;
						if ( (field in c.fields) 
							&& param[name].values.find( function(pv) { return pv == c.fields[field] })  ) {
							match++;
						}
					};
// 					li.hidden = match !== keys.length;
					if ( match == keys.length ) {
						li.hidden = false;
						selectCount++;
					}
				});			// Apply filters
			document.getElementById('countCloth').innerText = selectCount;
			setCloth();
		};

	document.getElementById('filterRst').addEventListener('click', function() {
					let checked = document.querySelectorAll('#filterCloth .pulld.apply');
					if ( checked.length > 0 ) {
						checked.forEach( function(fd) {
											document.getElementById(fd.dataset.filter+'_pd').querySelector('li[data-value="*"]').click();
											markUpFilter(fd);
										}
									);
					}
				});

	var markUpFilter = function(host) {
			let panel = host.previousElementSibling;
// 			if (panel.hidden) return;
			panel.hidden=true;
			host.innerText = host.innerText.replace(/(:\s*\d+)?/g,'');
			host.className = host.className.replace(/\s*on\b/g,'')
			host.className = host.className.replace(/\s*apply\b/g,'');
			if ( panel.querySelector('li.on:not([data-value="*"])') ) {
				let opts = panel.querySelectorAll('li.on:not([data-value="*"])');
				host.className += ' apply';
				host.innerText += ': '+opts.length;
			}
			applyFilter();
		};

	function filterPulldInit() {		// Collect appropriate PullDown menus for filter based on existing fields
		document.querySelectorAll('.pulld').forEach( function(ctrl) {			// Sample list filtering

				let old = document.getElementById(ctrl.dataset.filter+'_pd');
				if ( old ) old.parentNode.removeChild(old);				// Garbage cleanup

				let pull = createObj('ul',{'id':ctrl.dataset.filter+'_pd', 'className':'poplist', 'hidden':true,
										'style.minWidth':ctrl.offsetWidth+'px', 'style.top':(ctrl.offsetTop+ctrl.offsetHeight)+'px',
										});
				let allof = createObj('li',{'innerText':'Показать все','className':'on','data-value':'*',
										'onclick':function(evt) { let host=evt.target;
																	if ( host.className.match(/\bon\b/) ) return;
																	host.parentNode.querySelectorAll('li.on').forEach( function(li) { li.className = li.className.replace(/\s*on\b/g,'') } );
																	host.className += ' on';
																}, 
										});
				let opt = fieldsOpt.find( function(o) { return o.name == ctrl.dataset.filter } );
				if ( opt ) {
					if ( opt.title.length > 0 ) ctrl.innerText = opt.title;
					let ref = null;
					if ( ctrl.dataset.ref ) {
						ref = fieldsOpt.find( function(o) { return o.name == ctrl.dataset.ref } );
					}
					let vals = {};
					let cnt = 0;
					cloths[activeModelType].forEach( function(cl) {
								if ( cl.fields[opt.field] ) {
									vals[cl.fields[opt.field]] = cl.fields[opt.field];
									if ( ref && cl.fields[ref.field] ) {
										vals[cl.fields[opt.field]] = cl.fields[ref.field];
									}
								}
							});
					Object.keys(vals).sort( function(a, b) { 
													if (a.match(/^\d+$/) && a.match(/^\d+$/)) { 
															return a-b 
													} else { 
														return a.charCodeAt(0) - b.charCodeAt(0)
													} 
											} ).forEach( function(k) {
													let [t, v] = [k, vals[k]];
													if ( ref ) [t, v] = [ vals[k], k ];
													pull.appendChild( createObj('li', {'innerText':t,'data-value':v,
																'onclick':function(evt) { let host=evt.target;
																						if ( host.className.match(/\bon\b/) ) {
																							host.className = host.className.replace(/\s*on\b/g,'');
																							if ( host.parentNode.querySelectorAll('li.on').length == 0 ) {
																								host.parentNode.firstElementChild.className += ' on';
																							}
																						} else {
																							host.className += ' on';
																							host.parentNode.firstElementChild.className 
																								= host.parentNode.firstElementChild.className.replace(/\s*on\b/g,'');
																						}
																					}, 
																			}) );
												});
				}
				if ( pull.firstElementChild ) {
					pull.insertBefore(allof, pull.firstElementChild);
				} else {
					pull.appendChild(allof);
				}
				ctrl.parentNode.insertBefore(pull, ctrl);
				ctrl.onclick = function(evt) {
						evt.stopImmediatePropagation();
						let host = evt.target;
						let panel = host.previousElementSibling;
						let offPanel = function(evt) {
											if ( evt.path.find( function(t) { return t.id == host.dataset.filter+'_pd' }) ) return;
											markUpFilter(host);
											document.removeEventListener('click', offPanel);
										};
						if ( host.className.match(/\bon\b/) ) {
							markUpFilter(host);
						} else {
							document.querySelectorAll('.pulld').forEach( markUpFilter );
							host.innerText = host.innerText.replace(/(:\s*\d+)?/g,'');
							panel.hidden = false;
							document.addEventListener('click', offPanel);
							host.className += ' on';
							panel.style.left = host.offsetLeft+'px'; 
							let diff = window.innerWidth - 20 - (getPosition(panel)[0] + panel.offsetWidth);
							if (diff < 0) {
								panel.style.left = (panel.offsetLeft+diff)+'px';
							}
						}
					};
			});			// end Collect sample filter popups
	}			//  Init pulldowns for filter

	document.querySelectorAll('.order-opt').forEach( function(div) {
			div.querySelectorAll('figure').forEach( function(opt) {
					opt.addEventListener('click', function() {
							if (opt.className.match(/\s*sel/)) return;
							let sel = div.querySelector('.sel');
							sel.className = sel.className.replace(/\s*sel/g,'');
							opt.className += ' sel';
							let varName = 'activeModel'+div.dataset.name.substr(0,1).toUpperCase()+div.dataset.name.substr(1).toLowerCase();
							eval( varName+'="'+opt.dataset.value+'"');
							if ( !cloths[activeModelType] ) {
								getAjaxCloth();
							} else {
								updateClothList();
							}
						});
				});
		});

	var checkListComplete = function() {
			let shown = document.querySelectorAll('div.cloth-list ul.cloth-list li.cloth-list-item:not([hidden])');
			let last = shown[shown.length-1];
			let swTop = document.getElementById('expandAll');
			let swBot = document.getElementById('collapseAll');
			let div = document.querySelector('div.cloth-list');
			if (div.style.height !== 'initial') div.dataset.h = div.offsetHeight;
			let expand = function() {
					if ( !swBot.hidden ) return;
					swTop.removeEventListener('click', expand);
					swTop.addEventListener('click', collapse);
					swBot.addEventListener('click', collapse);
					div.style.height = 'initial';
					swTop.dataset.pretext = swTop.innerText;
					swTop.innerText = swBot.innerText;
					swBot.hidden = false;
				};
			let collapse = function() {
					if ( swBot.hidden ) return;
					swTop.removeEventListener('click', collapse);
					swBot.removeEventListener('click', collapse);
					swTop.addEventListener('click', expand);
					div.style.height = '';
					swTop.innerText = swTop.dataset.pretext;
					swBot.hidden = true;
					setCloth();
				};

			swTop.className = swTop.className.replace(/\s*dis/g,'');
console.log('LastPosition : '+(div.offsetHeight - last.offsetTop));
			if ( !last ) {
				collapse();
				swTop.className += ' dis';
			} else if ( div.style.height == 'initial' && div.dataset.h >= last.offsetTop ) {
				collapse();
				swTop.className += ' dis';
			} else if ( div.offsetHeight < last.offsetTop ) {
				swTop.removeEventListener('click', collapse);
				swBot.removeEventListener('click', collapse);
				swTop.addEventListener('click', expand);
			} else {
// 				collapse();
			}
		};

	document.querySelectorAll('.tosort').forEach( function(ctrl) {			// Sample list soring
			ctrl.addEventListener('click', function(evt) {
				if ( ctrl.className.match(/\bon\b/) ) {
					let dir;
					if ( ctrl.className.match(/\bfw\b/) ) {
						ctrl.className = ctrl.className.replace(/(\s*fw\s*)/g,' bw');
						dir = 'bw';
					} else {
						ctrl.className = ctrl.className.replace(/(\s*bw\s*)/g,' fw');
						dir = 'fw';
					}
					ctrl.dataset.presort = dir;
				} else {
					ctrl.parentNode.querySelectorAll('.tosort').forEach(function(div) { div.className = div.className.replace(/\s*(on|[bf]w)/g,'')});
					let dir = 'fw';
					if ( ctrl.dataset.presort ) dir = ctrl.dataset.presort;
					ctrl.className += ' on '+dir;
					ctrl.dataset.presort = dir;
				}
				// Call sorting procedure HERE!
				// reference to controls dataset.sort and classname fw/bw, e.q. forward/backward 
				//
			});
		});

var ulSort = function() {
  var nodeList = document.querySelectorAll('li');
  var itemsArray = [];
  var parent = nodeList[0].parentNode;
  for (var i = 0; i < nodeList.length; i++) {    
    itemsArray.push(parent.removeChild(nodeList[i]));
  }
  itemsArray.sort(function(nodeA, nodeB) {
      var textA = nodeA.querySelector('div:nth-child(2)').textContent;
      var textB = nodeB.querySelector('div:nth-child(2)').textContent;
      var numberA = parseInt(textA);
      var numberB = parseInt(textB);
      if (numberA < numberB) return -1;
      if (numberA > numberB) return 1;
      return 0;
    })
    .forEach(function(node) {
      parent.appendChild(node)
    });
}


	$(document).on('click', 'li.cloth-list-item', function (e) {
		let clothId = $(this).data("cloth-id");

		if ($(this).is(".active")) {
			let cloth = cloths[activeModelType].filter(function (x) {return x.ID == clothId} )[0];
			let clothFields = cloth.fields;
			let modal = $("#clothInfo");
			let thumbs = modal.find(".cloth-info-thumbs");
			thumbs.html("");
			cloth.gallery.forEach(function (img) {
									thumbs.append("<div class=\"cloth-info-thumb\"><img src=\"" + img + "\" alt=\"\"></div>");
								});
			modal.find(".cloth-info-thumb:first-child").trigger("click");
			modal.find(".cloth-info-title").text(cloth.post_title);
			modal.find(".cloth-info-name").text(cloth.post_title);
			modal.find(".cloth-info-vendor-code").text(cloth.vendor_code);
			modal.find(".cloth-info-cat").text(clothFields.категория);
			modal.find(".cloth-info-unit").text(clothFields.единица_измерения);
			modal.find(".cloth-info-transparent").text(clothFields.прозрачность + "%");
			modal.find(".cloth-info-width").text(clothFields.ширина_рулона);
			modal.find(".cloth-info-structure").text(clothFields.структура);
			modal.find(".cloth-info-weight").text(clothFields.вес_гм2);
			modal.find(".cloth-info-wet-rooms").text(clothFields.пригодность_для_влажных_помещений ? "Да" : "Нет");
			modal.find(".cloth-info-fade-resistance").text(clothFields.стойкость_к_выгоранию);
			modal.find(".cloth-info-wash").text(clothFields.уход_и_чистка);
			modal.find(".cloth-info-color").text(clothFields.цвет);
			modal.find(".cloth-info-country").text(clothFields.страна_происхождения);
			modal.find(".cloth-info-certification").text(clothFields.сертификация ? "Да" : "Нет");
			modal.modal("show");

		} else {
			setCloth(clothId);
		}
		return false;
	});

	function setCloth(id) {
		if ( !id ) id = activeCloth;
		let active = document.getElementById('clo_'+id);
		let div = document.querySelector('div.cloth-list');
		let spare = document.querySelector('li.cloth-list-item:not([hidden])');
		if (active && active.hidden) {			// Active become hidden
			if ( spare )  {
				active = spare;
			} else {
				active = false;
			}
		} else if ( !spare ) {
			active = false
		}
		if ( active ) {
			document.querySelectorAll('li.cloth-list-item.active').forEach( function(l) { l.className = l.className.replace(/\s*active/g,'') });
			active.className += ' active';
			activeCloth = active.dataset.clothId;
			setLocation('?type='+activeModelType+'&cloth=' + activeCloth);
			getClothData();

			let dvBox = div.getBoundingClientRect();		// Place active tile into viewport
			let liBox = active.getBoundingClientRect();
			let [wx,wy] = [document.documentElement.scrollLeft, document.documentElement.scrollTop];		// Prevent window jerking
			if ( dvBox.top > liBox.top ) {					// Sticks out from above?
				active.scrollIntoView(true);
				window.scrollTo(wx,wy);
			} else if ( dvBox.top + div.offsetHeight < liBox.top + active.offsetHeight ) {		// Sticks out from below?
				active.scrollIntoView(false);
				window.scrollTo(wx,wy);
			}

			getPrice();
		} else {
			setLocation(document.location.origin);
		}
		checkListComplete();
	}

	function getClothData() {
		$activeClothUrl = cloths[activeModelType].filter(x=>x.ID == activeCloth);
		let clothColor = $activeClothUrl[0].fields[ fieldsOpt.find( function(o) { return o.name=='colorCode' } ).field ];
		activeClothOpacity = $activeClothUrl[0].fields[ fieldsOpt.find( function(o) { return o.name=='opacity' } ).field ];
		activeModelType = $activeClothUrl[0].fields[ fieldsOpt.find( function(o) { return o.name=='type' } ).field ];
		if ( activeClothColors.indexOf(clothColor) < 0 ) activeClothColors.push(clothColor);
	}

	function createWindowColors() {
		let content = document.getElementById('color-frame');
		content.innerHTML = '';
		for (color in windows) {
			let isActive = activeWindowColor === color ? "active" : "";
			let e = hex2hsl(windows[color].color);
			let borderColor = lightenDarkenColor(windows[color].color, 100);
			if ((e[0] < 0.55 && e[2] >= 0.5) || (e[0] >= 0.55 && e[2] >= 0.75)) {
				borderColor = lightenDarkenColor(windows[color].color, -80);
			}
			let ctrl = createObj('div', {'className':'window-color '+isActive,'title':windows[color].name,
								'data-toggle':'tooltip','data-color-name':color,'data-placement':'top',
								'style.backgroundColor':'#'+windows[color].color,'style.color':'#'+borderColor,'style.borderColor':'#'+borderColor,
								'onclick':function() { let color = this.dataset.colorName;
												content.querySelectorAll('div.window-color.active').forEach( 
																		function(d) { d.className = d.className.replace(/\s*active/g,'')} 
																										   );
												if ( windows[color] ) {
													this.className += ' active';
													activeWindowColor = color;
												}
											},
									});
			content.appendChild(ctrl);
		}
	}

	createWindowColors();

    /**
     * Modals
     */
    $("[data-infom-target]").on("click", function () {
        let target = $(this).data("infom-target");
        let container = $(".modals");
        $("[data-info]", container).hide();
        $("[data-info=" + target + "]", container).show();
        container.addClass("show");
        return false;
    });
    $("[data-dismiss]", ".modals").on("click", function () {
        let container = $(".modals");
        $(this).parents("[data-info]").hide();
        container.removeClass("show");
    });

    if ("undefined" != typeof PhotoSwipe) {
        initPhotoSwipe(".js-builder-photos");
    }

    /**
     * Clothes
     */
// // // //	//	Obsoleted call
//     let activeClothOpacity = $("[name=opacity]:checked").val();
//     let activeClothColors = [];
//     $("[name=color]:checked").each(function () {
//         activeClothColors.push($(this).val());
//     });
//     $("[name=opacity]").change(function () {
//         activeClothOpacity = this.value;
//         updateClothList();
//     });
//     $("[name=color]").change(function () {
//         activeClothColors = [];
//         $("[name=color]:checked").each(function () {
//             activeClothColors.push($(this).val());
//         });
//         updateClothList();
//     });
//     $(document).on("click", ".cloth-info-thumb", function () {
//         let src = $(this).find("img").attr("src");
//         let full = $(".cloth-info-full-image .zoom");
//         full.attr("src", src);
//         //full.parent().attr('href', src);
//         $(this).parent().find(".cloth-info-thumb").removeClass("active");
//         $(this).addClass("active");
//         imageZoom("clothImg", "clothImgResult");
// 
//     });

    $(".js-cloth-list-open").on("click", function () {
        buildClothGrid();
        return false;
    });
    $(window).resize(buildClothGrid);

	if (canvas){
		filterPulldInit();
		setCloth();
	}
        

	function buildClothGrid() {
		let cl = $(".js-cloth-list");
		if (cl.find("li").length > 0) {
			let li = $("li", cl).removeClass("right").removeClass("bottom");

			let per_line_x = Math.floor(cl.width() / li.outerWidth()),
				per_line_y = Math.floor(cl.height() / li.outerHeight());

			$("li:nth-child(" + per_line_x + "n)", cl).addClass("right");
			$("li:nth-child(" + per_line_x + "n-1)", cl).addClass("right");

			let botStart = (per_line_y - 2) * per_line_x;
			let botEnd = (per_line_y * per_line_x);
			for (let n = botStart; n < botEnd; n++) {
				$("li:nth-child(" + (n + 1) + ")", cl).addClass("bottom");
			}
		}
	}

	function updateClothList() {
		let countCloth = 0;
		let model = "lvt";
		if (activeModelMount !== "open") {
			if (activeModelEquip === "default") {
				model = "mini";
			} else {
				model = "uni";
			}
		}

		let clothList = document.querySelector('ul.cloth-list');
		clothList.innerHTML = '';

		cloths[activeModelType].forEach( function (cloth) {
// 			if (parseInt(activeClothOpacity) === 1 && parseInt(cloth.fields.прозрачность) === 0) {
// 				return;
// 			}
// 			if (parseInt(activeClothOpacity) === 0 && parseInt(cloth.fields.прозрачность) > 0) {
// 				return;
// 			}
// 			if (activeClothColors.length !== 0 && !activeClothColors.includes(cloth.fields.цвет_для_фильтра)) {
// 				return;
// 			}
// 			if (cloth.fields["изображение_" + model] === undefined || cloth.fields["изображение_" + model] === false) {
// 				return;
// 			}
// 			cloth.title = (cloth.post_title).replace("зебра", "");//(cloth.post_title).replace(/[^0-9]/gim, "");
			
					let li = createObj('li', {'className':'cloth-list-item', 'id':'clo_'+cloth.ID,
										'style.backgroundImage':'url(\''+cloth.gallery[0]+'\')',
										'title':cloth.title,
										'data-cloth-id':cloth.ID,
										'data-texture-lvt':cloth.texture_lvt,
										'data-texture-mini':cloth.texture_mini,
										'data-texture-uni':cloth.texture_uni,
										'data-cat':cloth.fields['категория'],
										'data-short-title':cloth.title,
										'data-title':cloth.post_title,
										'data-vendor-code':cloth.vendor_code,
										'data-color-cloth':cloth.fields['цвет']
									});
					li.appendChild( createObj('i',{'className':'clo-info','aria-hidden':true,'innerHTML':'<img src="'+template_url+'/images/icons/findglass.svg" />'}) );
					li.appendChild( createObj('input',{'type':'radio','hidden':true,'name':'cloth','value':cloth.ID,'className':'form-check-input'}));
					clothList.appendChild(li);
					countCloth++;
				});

		document.getElementById('filterRst').click();
		document.getElementById('countCloth').innerText = countCloth;
		$(".builder-loading").addClass("d-none");
		clothList.className = clothList.className.replace(/\s*d\-none/g,'');
		filterPulldInit();
		setCloth();
	}

	function getAjaxCloth( postfix ) {
		$.ajax({
			url: "/wp-admin/admin-ajax.php",
			type: "POST",
			data: {
				action: "getCloth",
				type: activeModelType
			},
			beforeSend: function () {
				$('.builder-loading').removeClass("d-none");
				$("ul.cloth-list").addClass("d-none");
				document.getElementById('countCloth').innerText = '...';
			},
			success: function (data) {
				cloths[activeModelType] = data;
				updateClothList();
			}
		});
	}

    /**
     * Prices
     */
    activeWidth = $("[name=size_width]").val();
    activeHeight = $("[name=size_height]").val();
    activeControl = $("[name=control]:checked").val();
    activeCount = $("[name=count]").val();
    $("[name=control]").change(function () {
        activeControl = this.value;
        if (activeControl === "electro") {
            $(".js-order-confirm-electro").text("электро");
        } else {
            if (activeControl === "left") {
                $(".js-order-confirm-electro").text("слева");
            } else {
                
                $(".js-order-confirm-electro").text("справа");
            }
        }
        getPrice();
    });
    $("[name=control]:checked").trigger("change");
    $("[name=size_width]").change(function () {
        activeWidth = parseInt(this.value);
        this.value = activeWidth;
        $(".js-order-confirm-width").text(activeWidth);
        getPrice();
    });
    $("[name=size_height]").change(function () {
        activeHeight = parseInt(this.value);
        this.value = activeHeight;
        $(".js-order-confirm-height").text(activeHeight);
        getPrice();
    });
    $("[name=count]").change(function () {
        activeCount = parseInt(this.value);
        this.value = activeCount;
        getPrice();
    });

    function getPrice() {
        let $activeCloth = $(".cloth-list .cloth-list-item[data-cloth-id=" + activeCloth + "]");
        let model = "";
        if (activeModelType === "zebra") {
            if (activeModelMount === "open") {
                model = "LVT-ЗЕБРА";
            } else {
                if (activeModelEquip === "default") {
                    model = "MINI-ЗЕБРА";
                } else {
                    model = "UNI2-ЗЕБРА";
                }
            }
        } else {
            if (activeModelMount === "open") {
                model = "LVT";
            } else {
                if (activeModelEquip === "default") {
                    model = "MINI";
                } else {
                    model = "UNI 2";
                }
            }
        }
        $(".js-order-confirm-model").text(model);
        $.ajax({
            url: "/wp-admin/admin-ajax.php",
            type: "POST",
            data: {
                action: "getPrice",
                model: model,
                electro: activeControl === "electro",
                equip: activeModelEquip,
                category: $activeCloth.data("cat"),
                width: activeWidth,
                height: activeHeight,
                count: activeCount
            },
            beforeSend: function () {
                $(".js-min-width").text("...");
                $(".js-max-width").text("...");
                $(".js-min-height").text("...");
                $(".js-max-height").text("...");
                $(".js-order-item-price").text("...");
                //$(".js-order-cart-price").text("...");
                $(".js-order-confirm-price").text("...");
                $(".js-order-confirm-count").text("...");
            },
            success: function (data) {
                let max_width = data.sizes_guarantee !== undefined ? data.sizes_guarantee.width : data.sizes_range.max_width;
                let max_height = data.sizes_guarantee !== undefined ? data.sizes_guarantee.height : data.sizes_range.max_height;
              
              
                $(".js-width-range").html("Min " + data.sizes_range.min_width + " см<br>Max " + max_width/*data.sizes_range.max_width*/ + " см");
                $(".js-height-range").html("Min " + data.sizes_range.min_height + " см<br>Max " + max_height/*data.sizes_range.max_height*/ + " см");
                $(".js-order-item-price").text(data.price);
                //let cartPrice = $(".js-order-cart-price");
                //cartPrice.text(parseInt(cartPrice.data('sum')) + data.price * activeCount);
                $(".js-order-confirm-price").text(data.price * activeCount);
                $(".js-order-confirm-count").text(activeCount);
                $(".js-sizes-error").text("");
                
                
                if(activeModelMount === "flap"){
                    $(".js-order-confirm-width-gb").closest('li').css("display","none");
                    $(".js-order-confirm-height-gb").closest('li').css("display","none");
                    $(".js-order-confirm-width:eq(1)").closest('li').css("display","block");
                    $(".js-order-confirm-height:eq(1)").closest('li').css("display","block");
                    $(".js-order-confirm-width").text(activeWidth);
                   
                    if(model == "UNI 2"){
                        $(".js-order-confirm-width:eq(1)").text(parseInt(activeWidth)  + 1.8);
                    }
                    else{
                        $(".js-order-confirm-width:eq(1)").text(parseInt(activeWidth)  + 3.5);
                       
                    }
                    
                    $(".js-order-confirm-height").text(activeHeight);

                }
                else{
                    $(".js-order-confirm-width-gb").closest('li').css("display","block");
                    $(".js-order-confirm-height-gb").closest('li').css("display","block");
                    $(".js-order-confirm-width:eq(1)").closest('li').css("display","none");
                    $(".js-order-confirm-height:eq(1)").closest('li').css("display","none");
                    $(".js-order-confirm-width").text(activeWidth);
                    $(".js-order-confirm-height").text(activeHeight);
                   	$(".js-order-confirm-width:eq(0)").closest('li')
                      .after('<li>Габаритный размер по ширине: <span class="js-order-confirm-width">'+ activeWidth +'</span>см.</li>')
                  	$(".js-order-confirm-width:eq(0)").closest('li').remove();
                  	
                }
                if(model == "UNI 2"){
                    $(".js-order-confirm-width-gb").text(parseInt(activeWidth) - 1.8);
                }
                else{
                    $(".js-order-confirm-width-gb").text(parseInt(activeWidth) - 3.5);
                }
                $(".js-order-confirm-height-gb").text(activeHeight);
                $(".js-order-confirm-height-upr").text(parseInt(activeHeight) * 3 / 4);
                
                if(data.imgs != null && data.imgs !="indefined"){
                    var textBlock = '<div class=\'text-center\'>';
                        for(var i = 0;i<data.imgs.length;i++){
                            textBlock+='<img class=\'img-fluid\' src=\'' + data.imgs[i] +' \'/>';
                        }
                    textBlock+='</div>';
                        if(data.imgs.length > 0){
                            $(".info-order-js-img").empty();
                            $(".info-order-js-img").html(textBlock);
                        }
                }
                if (data.is_guarantee === false) {
                    let text = "Не гарантийный размер.";
                    if (data.sizes_guarantee.height || data.sizes_guarantee.width) {
                        text += " Гарантийный размер";
                    }
                    if (data.sizes_guarantee.height) {
                        text += " до " + data.sizes_guarantee.height + " по высоте";
                    }
                    if (data.sizes_guarantee.width) {
                        if (data.sizes_guarantee.height) {
                            text += " и/или ";
                        }
                        text += " до " + data.sizes_guarantee.width + " по ширине";
                    }
                    $(".js-sizes-error").text(text);
                }
                if (data.is_real === false) {
                    let text = "Нет возможности сделать такой размер.";
                    if (data.sizes_real.height || data.sizes_real.width) {
                        text += " Возможен размер";
                    }
                    if (data.sizes_real.height) {
                        text += " до " + data.sizes_real.height + " по высоте";
                    }
                    if (data.sizes_real.width) {
                        if (data.sizes_real.height) {
                            text += " и/или";
                        }
                        text += " до " + data.sizes_real.width + " по ширине";
                    }
                    $(".js-sizes-error").text(text);
                }
            }
        });
    }


    /**
     * Orders
     */
	$("[data-infom-target='order']").on("click", function () {
        $("#all-right").prop('checked', false);
		$(".btn-order").addClass("disabled");
    });
	$("#all-right").on("click", function () {
		if($(this).is(':checked')) $(".btn-order").removeClass("disabled");
		else $(".btn-order").addClass("disabled");
	});
    $(document).on("click", ".btn-order:not(.disabled)", function (e) {
        e.preventDefault();
		if($("#all-right").is(":checked")) {
			$.ajax({
				url: "/wp-admin/admin-ajax.php",
				type: "POST",
				data: {
					action: "addOrder",
					equip: activeModelEquip,
					control: activeControl,
					mount: activeModelMount,
					type: activeModelType,
					cloth: activeCloth,
					width: activeWidth,
					height: activeHeight,
					count: activeCount
				},
				success: function (data) {
					if(data.status === "success") {
						let cartCount = $(".js-order-cart-count");
						cartCount.text(parseInt(cartCount.text()) + 1 * activeCount);
						let cartPrice = $(".js-order-cart-price");
                        cartPrice.text(parseInt(cartPrice.data('sum')) + data.price * activeCount);
                        $("#goToCart").removeClass("fade").fadeIn(300);
						$("[data-info='order'] [data-dismiss]").trigger("click");
					}

				}
			});
		}
    });

    if (canvas){
        builder();
    }
       
    function builder() {
// 		renderer always declared
        let maxAnisotropy = renderer.capabilities.getMaxAnisotropy();

        let camera = new THREE.PerspectiveCamera(40, canvas.clientWidth / canvas.clientHeight, 0.1, 1000);
		camera.position.set(0, 790, 0);
		camera.up.set(0, 0, 1);
		camera.lookAt(0, 0, 0);

        let scene = new THREE.Scene();
        let light = new THREE.AmbientLight(0xFFFFFF, 1);
// 		light.castShadow = true;
        scene.add(light);
        scene.background = new THREE.Color(activeBGColor);

		let planeGeometry = new THREE.PlaneGeometry(1, 1, 1, 1);
        let objects = {};
//         objects = {};
        let imageObjects = {};

        let loader = new THREE.TextureLoader();

        let imageMaterials = {};
        let scaleObjects = {};

        for (color in windows) {
            let url = template_url + "/images/builder/windows/" + color + "-" + activeState + ".png";
            createMaterial(url);
        }
        
//		addImage("interior", 1, 0.98, -19);
// 		updateImage("interior", template_url + "/images/builder/interior.png");
		addImage("interior", 1, 1, -8);
		updateImage("interior", template_url + "/images/builder/zebra-int.png");
		addImage("window", 2, 1.25, -49, -10);
		addImage("model", 4, 1.25, -49, -10);
		addImage("furniture", 5, 1.25, -49, -10);
		addImage("material", 6, 1.25, -49, -10);

		setTimeout( function() { camera.position.x=50; objects.interior.position.x=40 }, 100 );

		function addImage(name, zIndex, scale, x, y) {
			if (zIndex === undefined) zIndex = 0;
			if ( scale === undefined ) scale = 0;

			if (x === undefined) x = 0;
			if (y === undefined) y = 0;
			let material = new THREE.MeshPhongMaterial({
				transparent: true
			});
			let imageMesh = new THREE.Mesh(planeGeometry, material);
			imageMesh.rotation.x = THREE.Math.degToRad(-90);
			imageMesh.rotation.z = THREE.Math.degToRad(-180);
			imageMesh.position.set(x, zIndex, y);
			objects[name] = imageMesh;
			imageObjects[name] = "";
			scaleObjects[name] = scale;
			scene.add(imageMesh);
		}

		function updateImage(name, url, zIndex) {
			if (zIndex === undefined) zIndex = 0;
			if (imageObjects[name] !== url && objects[name] !== undefined) {
				imageObjects[name] = url;
				if (imageMaterials[url] !== undefined) {
					setMaterial(objects[name], imageMaterials[url], scaleObjects[name]);
				} else {
					createMaterial(url, objects[name], scaleObjects[name]);
				}

				if (zIndex !== 0) {
					objects[name].position.y = zIndex;
				}
			}
		}

        function createMaterial(url, object, scale) {
			if (!url) return;
            loader.load(url, function (texture) {
                texture.anisotropy = maxAnisotropy;
                texture.minFilter = THREE.LinearFilter;
                imageMaterials[url] = new THREE.MeshPhongMaterial({
                    map: texture,
                    transparent: true,
                    shininess : 1
                });
                if (object !== undefined)
                    setMaterial(object, imageMaterials[url], scale);
            });
        }

        function setMaterial(object, material, scale) {
            object.material = material;
            object.material.needsUpdate = true;
            object.scale.set((material.map.image.width / 2) * scale, (material.map.image.height / 2) * scale, 1);
// 			objects.interior.scale.x=1000;
        }

        function resizeRendererToDisplaySize() {
            let width = canvas.clientWidth;
            let height = canvas.clientHeight;
            let needResize = canvas.width !== width || canvas.height !== height;
            if (needResize) {
                renderer.setSize(width, height, false);
                camera.aspect = canvas.clientWidth / canvas.clientHeight;
                camera.updateProjectionMatrix();
            }
            return needResize;
        }

        function render() {
            scene.background.set(activeBGColor);
            resizeRendererToDisplaySize(renderer);
            updateImages();
            renderer.render(scene, camera);
            requestAnimationFrame(render);
            //renderer.clear();
        }

        function updateImages() {
            let modelUrl = activeModelType + "/" + activeModelColor + "-";
            let model = "";
            let clothLoadPost = true;
            let $activeCloth = $(".cloth-list .cloth-list-item [data-cloth-id=" + activeCloth + "]");
            if (activeModelMount === "open") {
                activeState = "CLOSE";
                modelUrl += "lvt-";
                model = "lvt";
                if (activeModelEquip === "default") {
                    modelUrl += "classic";
                } else {
                    clothLoadPost = false;
                    modelUrl += "cassette";
                }
            } else {
                if (activeModelEquip === "default") {
                    activeState = "OPEN";
                    model = "mini";
                    modelUrl += "mini";
                } else {
                    activeState = "OPENCLOSE";
                    model = "uni";
                    modelUrl += "uni";
                }
            }

            updateImage("window", template_url + "/images/builder/windows/" + activeWindowColor + "-" + activeState + ".png");
            updateImage("model", template_url + "/images/builder/models/" + modelUrl + ".png");
            updateImage("furniture", template_url + "/images/builder/models/furniture/" + modelUrl + ".png");
              if($activeClothUrl !== null){
                  updateImage("material", $activeClothUrl[0]['texture_' + model], clothLoadPost ? 6 : 3);
                  $activeClothUrl = null;
             }
             else{
                updateImage("material", $activeCloth.data("texture-" + model), clothLoadPost ? 6 : 3);
            }
        }
        render();
    }
});


let initPhotoSwipe = function (gallerySelector) {
    let parseThumbnailElements = function (el) {
        let thumbElements = el.childNodes,
            numNodes = thumbElements.length,
            items = [],
            figureEl,
            linkEl,
            size,
            item;

        for (let i = 0; i < numNodes; i++) {
            figureEl = thumbElements[i];
            if (figureEl.nodeType !== 1) {
                continue;
            }
            linkEl = figureEl.children[0];
            if (!linkEl.getAttribute('data-size') || linkEl.getAttribute('data-size') === 'auto') {
                size = [0, 0];
            } else {
                size = linkEl.getAttribute("data-size").split("x");
            }
            item = {
                src: linkEl.getAttribute("href"),
                w: parseInt(size[0], 10),
                h: parseInt(size[1], 10)
            };
            if (figureEl.children.length > 1) {
                item.title = figureEl.children[1].innerHTML;
            }
            if (linkEl.children.length > 0) {
                item.msrc = linkEl.children[0].getAttribute("src");
            }
            item.el = figureEl;
            items.push(item);
        }

        return items;
    };

    let closest = function closest(el, fn) {
        return el && (fn(el) ? el : closest(el.parentNode, fn));
    };

    let onThumbnailsClick = function (e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        let eTarget = e.target || e.srcElement;

        let clickedListItem = closest(eTarget, function (el) {
            return (el.tagName && el.tagName.toUpperCase() === "FIGURE");
        });

        if (!clickedListItem) {
            return;
        }

        let clickedGallery = clickedListItem.parentNode,
            childNodes = clickedListItem.parentNode.childNodes,
            numChildNodes = childNodes.length,
            nodeIndex = 0,
            index;

        for (let i = 0; i < numChildNodes; i++) {
            if (childNodes[i].nodeType !== 1) {
                continue;
            }
            if (childNodes[i] === clickedListItem) {
                index = nodeIndex;
                break;
            }
            nodeIndex++;
        }

        if (index >= 0) {
            openPhotoSwipe(index, clickedGallery);
        }
        return false;
    };

    let photoswipeParseHash = function () {
        let hash = window.location.hash.substring(1),
            params = {};

        if (hash.length < 5) {
            return params;
        }

        let lets = hash.split("&");
        for (let i = 0; i < lets.length; i++) {
            if (!lets[i]) {
                continue;
            }
            let pair = lets[i].split("=");
            if (pair.length < 2) {
                continue;
            }
            params[pair[0]] = pair[1];
        }

        if (params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };

    let openPhotoSwipe = function (index, galleryElement, disableAnimation, fromURL) {
        let pswpElement = document.querySelectorAll(".pswp")[0],
            gallery,
            options,
            items;

        items = parseThumbnailElements(galleryElement);

        options = {
            galleryUID: galleryElement.getAttribute("data-pswp-uid"),

            getThumbBoundsFn: function (index) {
                let thumbnail = items[index].el.getElementsByTagName("img")[0],
                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                    rect = thumbnail.getBoundingClientRect();

                return {x: rect.left, y: rect.top + pageYScroll, w: rect.width};
            }

        };

        if (fromURL) {
            if (options.galleryPIDs) {
                for (let j = 0; j < items.length; j++) {
                    if (items[j].pid === index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                options.index = parseInt(index, 10) - 1;
            }
        } else {
            options.index = parseInt(index, 10);
        }

        if (isNaN(options.index)) {
            return;
        }

        if (disableAnimation) {
            options.showAnimationDuration = 0;
        }

        gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Zebra, items, options);
        gallery.listen('imageLoadComplete', function (index, item) {
            let linkEl = item.el.children[0];
            if (!linkEl.getAttribute('data-size') || linkEl.getAttribute('data-size') === 'auto') {
                let img = new Image();
                img.src = linkEl.getAttribute('href');

                linkEl.setAttribute('data-size', img.naturalWidth + 'x' + img.naturalHeight);
                item.w = img.naturalWidth;
                item.h = img.naturalHeight;
                gallery.invalidateCurrItems();
                gallery.updateSize(true);
            }
        });
        gallery.init();
    };

    let galleryElements = document.querySelectorAll(gallerySelector);

    for (let i = 0, l = galleryElements.length; i < l; i++) {
        galleryElements[i].setAttribute("data-pswp-uid", i + 1);
        galleryElements[i].onclick = onThumbnailsClick;
    }

    let hashData = photoswipeParseHash();
    if (hashData.pid && hashData.gid) {
        openPhotoSwipe(hashData.pid, galleryElements[hashData.gid - 1], true, true);
    }
};

function setLocation(curLoc) {
	try {
		history.pushState(null, null, curLoc);
		return;
	} catch (e) {
	}
	location.hash = "#" + curLoc;
}

// utils
function hex2hsl(hex) {
    let r = parseInt(hex.substring(0, 2), 16) / 255;
    let g = parseInt(hex.substring(2, 4), 16) / 255;
    let b = parseInt(hex.substring(4, 6), 16) / 255;
    let max = Math.max(r, g, b), min = Math.min(r, g, b);
    let h, s, l = (max + min) / 2;
    if (max === min) {
        h = s = 0;
    } else {
        let d = max - min;
        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
        switch (max) {
            case r:
                h = (g - b) / d + (g < b ? 6 : 0);
                break;
            case g:
                h = (b - r) / d + 2;
                break;
            case b:
                h = (r - g) / d + 4;
                break;
        }
        h /= 6;
    }
    return [h, s, l]; // H - цветовой тон, S - насыщенность, L - светлота
}

function lightenDarkenColor(col, amt) {
    let usePound = false;
    if (col[0] === "#") {
        col = col.slice(1);
        usePound = true;
    }
    let num = parseInt(col, 16);
    let r = (num >> 16) + amt;
    if (r > 255) r = 255;
    else if (r < 0) r = 0;

    let b = ((num >> 8) & 0x00FF) + amt;
    if (b > 255) b = 255;
    else if (b < 0) b = 0;

    let g = (num & 0x0000FF) + amt;
    if (g > 255) g = 255;
    else if (g < 0) g = 0;

    return (usePound ? "#" : "") + (g | (b << 8) | (r << 16)).toString(16);
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}