jQuery(function($){
	$('#true_loadmore').click(function(){
		var cur_html = $(this).html();
		$(this).text('Загружаю...');
		var data = {
			'action': 'loadmore',
			'query': true_posts,
			'file_content': file_content,
			'class_content': class_content,
			'page' : current_page
		};
		$.ajax({
			url: ajaxurl,
			data: data,
			type: 'POST',
			success: function(data) {
			    console.log(data);
				if(data) { 
					$('#true_loadmore').html(cur_html);
					$('.posts').append(data);
					current_page++;
					if (current_page == max_pages) $("#true_loadmore").remove();
				} else {
					$('#true_loadmore').remove();
				}
			}
		});
	});
	
	var $slider = jQuery('#lightgallery').slick({
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 1
	  });
	jQuery("#lightgallery").lightGallery({
		selector: '.slick-slide:not(.slick-cloned) .gallery-item'
	});
	$gallery = jQuery('#lightgallery');
	// $gallery.on('onBeforePrevSlide.lg',function(event,prevIndex,index,fromTouch,fromThumb){
    //     $slider.slick('slickPrev');
	// });
	// $gallery.on('onBeforeNextSlide.lg',function(event,prevIndex,index,fromTouch,fromThumb){
    //     $slider.slick('slickNext');
	// });
	// $gallery.on('onBeforePrevSlide.lg', function(e){
		
	// 	$slider.slider('slickPrev');
		
	// }, false);
	// $gallery.on('onBeforeNextSlide.lg', function(e){
	// 	
	// }, false);

	
});