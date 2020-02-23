<?php
/**
 * Font Preview Template
 */
  if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$font_url = get_post_meta( $post->ID, 'sample_font_url', true );
?>
<div id="mayosis_font_pallate">
    <div class="mayosis_text_type_box">
    <input id="mayosis_font_title" name="title" value="The quick brown fox jumps over the lazy dog" placeholder="Enter your custom text here">
    </div>
   
     <div class="mayosis_font_size_value">
             <div class="mayosis-font-case-control">
          <label class="fontcaselabel"><input type="radio" name="fontcase" class="fontcase" value="textcapitalize" checked><i class="font-capitalize"></i></label>
        <label class="fontcaselabel"><input type="radio" name="fontcase" class="fontcase" value="textlowercase"><i class="font-lowercase"></i></label>
      <label class="fontcaselabel"><input type="radio" name="fontcase" class="fontcase" value="textuppercase"><i class="font-uppercase"></i></label>
      
    </div>
    <div class="sizevalue"><span id="rangervalue">24</span><?php esc_html_e('px','mayosis');?></div>
            <input type="range" min="24" max="72" step="1" value="0" id="mayo_font_ranger" name="font"/>
             
         
            </div>
        </div>
        <div class="mayosis-font-preview-box">
            <div class="mayosis-font-item">
        <span class="mayos_font_title"><?php the_title();?></span>
        <div id="mayo_font_preview" class="mayo_font_preview"></div>
        </div>
        
      
      
        
        
        </div>
        
          
           
        <script>
       
        jQuery(document).ready(function($){
     
     


             $("#mayo_font_ranger").on("input",function () {
            $('#mayo_font_preview').css("font-size", $(this).val() + "px");
    });


var slider = document.getElementById("mayo_font_ranger");
var output = document.getElementById("rangervalue");
output.innerHTML = slider.value;
slider.oninput = function() {
  output.innerHTML = this.value;
}

$("#mayo_font_preview").fontface({
  fontName : "mayosispreviewfont",
  fontFamily : ["mayosispreviewfont"],
  filePath : "<?php echo esc_url($font_url);?>",
});

        var $titleInput = $("#mayosis_font_title");

//Select the preview h1 tag
var $previewTitle = $("#mayo_font_preview");

// Every second update the preview
var previewTimer = setInterval(updatePreview, 1000);

function updatePreview(){  
   //Get the user's input
  
  var titleValue = $titleInput.val(); 
  //Set the user input as the preview title. 
  $previewTitle.text(titleValue);
   
}


$('.fontcase').change(function() {
  var className = $('.fontcase:checked').val().toLowerCase().replace(/\s+/, "-");
  $(".mayo_font_preview").attr('class', 'mayo_font_preview ' + className);
});


});
        </script>