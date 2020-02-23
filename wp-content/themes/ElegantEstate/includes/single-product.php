<?php $custom = get_post_custom($post->ID);
$et_price = isset($custom["price"][0]) ? $custom["price"][0] : '';
if ($et_price <> '') $et_price = get_option('elegantestate_cur_sign') . $et_price;
$et_description = isset($custom["description"][0]) ? $custom["description"][0] : '';

$et_property_type = isset($custom["et_property_type"][0]) ? $custom["et_property_type"][0] : '';
$et_bedrooms_number = isset($custom["et_bedrooms_number"][0]) ? $custom["et_bedrooms_number"][0] : '';
$et_bathrooms_number = isset($custom["et_bathrooms_number"][0]) ? $custom["et_bathrooms_number"][0] : '';
$et_garages_number = isset($custom["et_garages_number"][0]) ? $custom["et_garages_number"][0] : '';
$et_square_footage = isset($custom["et_square_footage"][0]) ? $custom["et_square_footage"][0] : '';

$et_band =  isset($custom["et_band"][0]) ? $custom["et_band"][0] : '';
$integrate_gmaps = ( isset($custom["integrate_gmaps"][0]) && $custom["integrate_gmaps"][0] == 1 ) ? true : false;
/*$latidude = isset($custom["et_latitude"][0]) ? $custom["et_latitude"][0] : '40.713279732514515';
$longtitude = isset($custom["et_longtitude"][0]) ? $custom["et_longtitude"][0] : '-74.00542840361595'; */
$et_address = isset($custom["et_address"][0]) ? $custom["et_address"][0] : '270 Park Ave. New York';

$custom["thumbs"] = isset($custom["thumbs"][0]) ? unserialize($custom["thumbs"][0]) : array();
$custom["thumbs_alt"] = isset($custom["_thumbs_alt"][0]) ? unserialize($custom["_thumbs_alt"][0]) : array();
$et_title_attribute = the_title_attribute( array( 'echo' => false ) ); ?>

<?php if ($et_band <> '') { ?>
   <span class="band<?php echo( esc_attr( ' ' . $et_band ) ); ?>"></span>
<?php }; ?>

<?php if (!empty($custom["thumbs"])) { ?>
   <div id="product-slider">
      <div id="product-slides">
         <?php for ($i = 0; $i <= count($custom["thumbs"])-1; $i++) { ?>
            <div class="item-slide">
               <a href="<?php echo esc_url($custom["thumbs"][$i]); ?>" rel="gallery" class="fancybox" title="<?php the_title(); ?>">
              <?php echo et_new_thumb_resize( et_multisite_thumbnail($custom["thumbs"][$i]), 293, 293, ( isset( $custom["thumbs_alt"][$i] ) && '' !== $custom["thumbs_alt"][$i] ? $custom["thumbs_alt"][$i] : $et_title_attribute ) ); ?>
                  <span class="overlay"></span>
               </a>
            </div> <!-- .item-slide -->
         <?php }; ?>
      </div> <!-- #product-slides -->

      <?php if ($et_price <> '') { ?>
         <span class="price2"><span><?php echo esc_html($et_price); ?></span></span>
      <?php }; ?>
   </div> <!-- #product-slider -->
<?php }; ?>

<div class="product-info">
   <h1 class="title"><?php the_title(); ?></h1>

   <div class="product-types clearfix">
      <?php if ($et_property_type <> '') { ?>
         <span class="type-icon small"><?php echo esc_html($et_property_type); ?></span>
      <?php } ?>
      <?php if ($et_bedrooms_number <> '') { ?>
         <span class="bed-icon"><?php echo esc_html($et_bedrooms_number); ?> <?php esc_html_e('Bedroom','ElegantEstate');  ?></span>
      <?php } ?>
      <?php if ($et_bathrooms_number <> '') { ?>
         <span class="bath-icon"><?php echo esc_html($et_bathrooms_number); ?> <?php esc_html_e('Bathroom','ElegantEstate');  ?></span>
      <?php } ?>
      <?php if ($et_garages_number <> '') { ?>
           <span class="garage-icon"><?php echo esc_html($et_garages_number); ?> <?php esc_html_e('Garage','ElegantEstate');  ?></span>
        <?php } ?>
      <?php if ($et_square_footage <> '') { ?>
         <span class="ruler-icon"><?php echo esc_html($et_square_footage); ?> <?php esc_html_e('ft2','ElegantEstate');  ?></span>
      <?php } ?>
   </div> <!-- .product-types -->

   <div class="description">
      <p><?php echo($et_description); ?></p>
   </div> <!-- .description -->

   <a href="<?php echo get_option('elegantestate_contact_agent'); ?>" class="readmore"><span><?php esc_html_e('Contact An Agent','ElegantEstate'); ?></span></a>

</div> <!-- #product-info -->

<div class="clear"></div>

<?php if (count($custom["thumbs"]) > 1) { ?>
   <div id="product-thumbs" class="clearfix">
      <div id="product-thumb-items">
         <div id="smallthumbs">
            <?php for ($i = 0; $i <= count($custom["thumbs"])-1; $i++) { ?>
               <a href="#" class="small-controller<?php if($i==0) echo(' active'); if ($i==count($custom["thumbs"])-1) echo(' last') ?>" rel="<?php echo($i+1); ?>">
                  <?php echo et_new_thumb_resize( et_multisite_thumbnail($custom["thumbs"][$i]), 49, 49, ( isset( $custom["thumbs_alt"][$i] ) && '' !== $custom["thumbs_alt"][$i] ? $custom["thumbs_alt"][$i] : $et_title_attribute ) ); ?>
                  <span class="overlay"></span>
               </a>
            <?php }; ?>
         </div>
         <a href="#" id="left-arrow"><?php esc_html_e('Previous','ElegantEstate');?></a>
         <a href="#" id="right-arrow"><?php esc_html_e('Next','ElegantEstate');?></a>
      </div> <!-- #product-thumb-items -->
   </div> <!-- #product-thumbs -->
<?php }; ?>

<?php the_content(); ?>
<div class="clear"></div>

<?php if ($integrate_gmaps) { ?>
   <div id="gmaps-border">
      <div id="gmaps-container"></div>
   </div> <!-- end #gmaps-border -->

   <script type="text/javascript" src="<?php echo esc_url( add_query_arg( array( 'key' => et_pb_get_google_api_key() ), is_ssl() ? 'https://maps.googleapis.com/maps/api/js' : 'http://maps.googleapis.com/maps/api/js' ) ); ?>"></script>
   <script type="text/javascript">
      //<![CDATA[
      var map;
      var geocoder;

      initialize();

      function initialize() {
         geocoder = new google.maps.Geocoder();
         geocoder.geocode({
            'address': '<?php echo esc_js($et_address); ?>',
            'partialmatch': true}, geocodeResult);
      }

      function geocodeResult(results, status) {

         if (status == 'OK' && results.length > 0) {
            var latlng = new google.maps.LatLng(results[0].geometry.location.b,results[0].geometry.location.c);
         var myOptions = {
            zoom: 10,
            center: results[0].geometry.location,
            mapTypeId: google.maps.MapTypeId.ROADMAP
         };

         map = new google.maps.Map(document.getElementById("gmaps-container"), myOptions);
            var marker = new google.maps.Marker({
            position: results[0].geometry.location,
            map: map,
            title:"<?php the_title(); ?>"
         });

            var contentString = '<div id="content">'+
            '<h3 id="firstHeading" class="firstHeading" style="padding-bottom: 15px;">'+marker.title+'</h3>'+
            '<div id="bodyContent">'+
            '<p><a target="_blank" href="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q='+escape(results[0].formatted_address)+'&amp;ie=UTF8&amp;view=map">'+results[0].formatted_address+'</a>'+
            '</p>'+
            '</div>'+
            '</div>';
            //&amp;sll=29.67226,-94.873971

            var infowindow = new google.maps.InfoWindow({
               content: contentString,
               maxWidth: 300
            });

            google.maps.event.addListener(marker, 'click', function() {
               infowindow.open(map,marker);
            });

            google.maps.event.trigger(marker, "click");

         } else {
            //alert("Geocode was not successful for the following reason: " + status);
         }
      }
      //]]>
   </script>
<?php }; ?>

<?php wp_link_pages(array('before' => '<p><strong>'.esc_html__('Pages','ElegantEstate').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
<?php edit_post_link(esc_html__('Edit this page','ElegantEstate')); ?>