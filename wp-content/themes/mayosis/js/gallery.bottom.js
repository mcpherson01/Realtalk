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
      verticalHeight:295,
      thumbItem:6,
      thumbMargin:4,
      slideMargin:0
    }); 
    
    $('#without-thumb').lightSlider({
      gallery:true,
      item:1,
      slideMargin:0
    }); 
});