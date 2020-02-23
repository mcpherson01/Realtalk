jQuery(document).ready(function($){
    $('#image-gallery').lightSlider({
        gallery:true,
        item:1,
        thumbItem:6,
        slideMargin: 0,
        speed:500,
        auto:false,
        loop:true,
        onSliderLoad: function() {
            $('#image-gallery').removeClass('cS-hidden');
        }  
    });
            
    $('#vertical').lightSlider({
      gallery:true,
      item:1,
      vertical:true,
      verticalHeight:500,
       adaptiveHeight:true,
      thumbItem:6,
      thumbMargin:4,
      slideMargin:0
    }); 
    
    $('#without-thumb').lightSlider({
      gallery:false,
      item:1,
      slideMargin:0,
      pager:false,
    }); 
    
    $('#carousel-gallery').lightSlider({
      gallery:false,
      item:4,
      slideMargin:10,
      pager:true,
    });
    
    var slider = $("#carousel-testimonial").lightSlider({
          controls: false,
          gallery:false,
            item:3,
            adaptiveHeight:true,
            responsive : [
            {
                breakpoint:800,
                settings: {
                    item:2,

                  }
            },
            {
                breakpoint:480,
                settings: {
                    item:1,
                  }
            }
        ]
        });
        $('.slideControls .slidePrev').click(function() {
            slider.goToPrevSlide();
        });

        $('.slideControls .slideNext').click(function() {
            slider.goToNextSlide();
        });
});