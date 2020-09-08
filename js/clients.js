/**
 * Application Script
 * Chiffa © 2019 http://goweb.pro
 */
jQuery(function ($) {
    $(".product-list-item").each(function () {
        let gallery = $(this).data("gallery");
        let thumbs = $("<div class='d-none thumbs'></div>");
        $(this).append(thumbs);
        gallery.forEach(function (img) {
            let imgHtml = $("<figure class=\"photos-item photo-build\" itemprop=\"associatedMedia\" itemscope=\"\" itemtype=\"http://schema.org/ImageObject\"><a href=\"" + img + "\" itemprop=\"contentUrl\"><img src=\"" + img + "\" itemprop=\"thumbnail\" alt=\"Image description\"></a></figure>");
            thumbs.append(imgHtml);
        });
    });

    if ("undefined" != typeof PhotoSwipe) {
        initPhotoSwipe(".product-list-item .thumbs");
    }

    $(".product-list-item-image").on("click", function () {
        console.log($(this).parent().find(".photos-item"));
        $(this).parent().find(".photos-item").trigger("click");
    });
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
            if (!linkEl.getAttribute("data-size") || linkEl.getAttribute("data-size") === "auto") {
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

        console.log(items);
        gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Zebra, items, options);
        gallery.listen("imageLoadComplete", function (index, item) {
            let linkEl = item.el.children[0];
            if (!linkEl.getAttribute("data-size") || linkEl.getAttribute("data-size") === "auto") {
                let img = new Image();
                img.src = linkEl.getAttribute("href");

                linkEl.setAttribute("data-size", img.naturalWidth + "x" + img.naturalHeight);
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
