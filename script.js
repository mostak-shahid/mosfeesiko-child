jQuery(document).ready(function($){    
    $(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$('.mos-sticky-header').addClass('tiny');
		} else {
			$('.mos-sticky-header').removeClass('tiny');
		}
	});   
    $('.counter').counterUp();
    $(".beer-slider").each(function (index, el) {
        $(el).BeerSlider({
            start: $(el).data("start")
        })
    });
    $(".slick-slider").slick();
});