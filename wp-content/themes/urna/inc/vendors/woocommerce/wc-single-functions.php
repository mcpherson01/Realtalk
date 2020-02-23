<?php

if(!class_exists('WooCommerce')) return;

//remove heading tab single product
if(!function_exists('urna_product_description_heading')){
  add_filter('woocommerce_product_description_heading',
  'urna_product_description_heading');

  function urna_product_description_heading() {
      return '';
  }
}

if ( ! function_exists( 'urna_woocommerce_setup_support' ) ) {
    add_action( 'after_setup_theme', 'urna_woocommerce_setup_support' );
    function urna_woocommerce_setup_support() {
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );

        if( class_exists( 'YITH_Woocompare' ) ) {
            update_option( 'yith_woocompare_compare_button_in_products_list', 'no' ); 
            update_option( 'yith_woocompare_compare_button_in_product_page', 'no' ); 
        }        

        if( class_exists( 'YITH_WCWL' ) ) {
            update_option( 'yith_wcwl_button_position', 'shortcode' ); 
        }
        if( class_exists( 'YITH_WCBR' ) ) {
            update_option( 'yith_wcbr_single_product_brands_content', 'name' );
        }
        add_filter( 'woocommerce_get_image_size_gallery_thumbnail', function( $size ) {
 
            $tbay_thumbnail_width       = get_option( 'tbay_woocommerce_thumbnail_image_width', 100);
            $tbay_thumbnail_height      = get_option( 'tbay_woocommerce_thumbnail_image_height', 100);
            $tbay_thumbnail_cropping    = get_option( 'tbay_woocommerce_thumbnail_cropping', 'yes');
            $tbay_thumbnail_cropping    = ($tbay_thumbnail_cropping == 'yes') ? true : false;

            return array(
                'width'  => $tbay_thumbnail_width,
                'height' => $tbay_thumbnail_height,
                'crop'   => $tbay_thumbnail_cropping,
            );
        } );

        $ptreviews_width       = get_option( 'tbay_photo_reviews_thumbnail_image_width', 100);
        $ptreviews_height      = get_option( 'tbay_photo_reviews_thumbnail_image_height', 100);
        $ptreviews_cropping    = get_option( 'tbay_photo_reviews_thumbnail_image_cropping', 'yes');

        $ptreviews_cropping    = ($ptreviews_cropping == 'yes') ? true : false;

        add_image_size( 'tbay_photo_reviews_thumbnail_image', $ptreviews_width, $ptreviews_height, $ptreviews_cropping );
    }
}

// share box
if ( !function_exists('urna_tbay_woocommerce_share_box') ) {
    function urna_tbay_woocommerce_share_box() {

        if( wp_is_mobile() ) return;

        if ( urna_tbay_get_config('enable_code_share',false)  && urna_tbay_get_config('enable_product_social_share', false) ) {
            ?>
              <div class="tbay-woo-share">
                <div class="addthis_inline_share_toolbox"></div>
              </div>
            <?php
        }
    }
    add_filter( 'woocommerce_single_product_summary', 'urna_tbay_woocommerce_share_box', 50 );
}


/*Hook class single product*/

// Number of products per page
if ( !function_exists('urna_tbay_woocommerce_class_single_product') ) {
    function urna_tbay_woocommerce_class_single_product($styles) {
        global $product;
        $attachment_ids = $product->get_gallery_image_ids();
        $count = count( $attachment_ids);

        $sidebar_configs    = urna_tbay_get_woocommerce_layout_configs();
        $images_layout      = $sidebar_configs['thumbnail'];

        $active_stick       = '';

        if( isset($images_layout) ) {

          if( isset($count) && $images_layout == 'stick' && ($count > 0) ) {
            $active_stick = ' active-stick';
          }

          switch ($images_layout) {
            case 'centered':
              $styles = ' style-stick style-centered';
              break;            
            case 'full':
              $styles = ' style-full';
              break;
            
            default:
              $styles = 'style-'.$images_layout;
              break;
          }
          
        }

        $styles .= $active_stick;

        return $styles;
    }
    add_filter( 'woo_class_single_product', 'urna_tbay_woocommerce_class_single_product' );
}


if ( !function_exists('urna_tbay_woocommerce_tabs_style_product') ) {
    function urna_tbay_woocommerce_tabs_style_product($tabs_layout) {

        if ( is_singular( 'product' ) ) {
          $sidebar_configs  = urna_tbay_get_woocommerce_layout_configs();
          $tabs_style       = urna_tbay_get_config('style_single_tabs_style', 'tabs');

          if ( isset($_GET['tabs_product']) ) {
              $tabs_layout = $_GET['tabs_product'];
          } else { 
              $tabs_layout = $tabs_style;
          }  

          return $tabs_layout;
        }
    }
    add_filter( 'woo_tabs_style_single_product', 'urna_tbay_woocommerce_tabs_style_product' );
}



/**
* Function For Multi Layouts Single Product 
*/
//-----------------------------------------------------
/**
 * Override Output the product tabs.
 *
 * @subpackage  Product/Tabs
 */
if ( !function_exists('urna_override_woocommerce_output_product_data_tabs') ) {
  function woocommerce_output_product_data_tabs() {

     if( wp_is_mobile() && urna_tbay_get_config('enable_tabs_mobile', false) ) {
        wc_get_template( 'single-product/tabs/tabs-mobile.php' );
        return;
     }

      $tabs_layout   =  apply_filters( 'woo_tabs_style_single_product', 10, 2 );

      if( isset($tabs_layout) ) {

        if( $tabs_layout == 'tabs' ) {
          wc_get_template( 'single-product/tabs/tabs.php' );
        } else {
          wc_get_template( 'single-product/tabs/tabs-'.$tabs_layout.'.php' );
        }
      }
  }
}

/*product time countdown*/
if(!function_exists('urna_woo_product_single_time_countdown')){

    add_action( 'woocommerce_single_product_summary', 'urna_woo_product_single_time_countdown', 28 );

    function urna_woo_product_single_time_countdown() {

        global $product;

        $style_countdown   = urna_tbay_get_config('enable_product_countdown',false);

        if ( isset($_GET['countdown']) ) {
            $countdown = $_GET['countdown'];
        }else {
            $countdown = $style_countdown;
        }  

        if(!$countdown || !$product->is_on_sale() ) {
          return '';
        }


        wp_enqueue_script( 'jquery-countdowntimer' );
        $time_sale = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
        $_id = urna_tbay_random_key();
 
        $day        = apply_filters( 'urna_single_time_countdown_day', esc_html__('d', 'urna') );
        $hours      = apply_filters( 'urna_single_time_countdown_hour', esc_html__('h', 'urna') );
        $mins       = apply_filters( 'urna_single_time_countdown_mins', esc_html__('m', 'urna') );
        $secs       = apply_filters( 'urna_single_time_countdown_secs', esc_html__('s', 'urna') );
        ?>
        <?php if ( $time_sale ): ?>
            <div class="tbay-time-wrapper">
              <div class="time tbay-time">
                  <div class="title"><?php esc_html_e('Deal end in: ','urna'); ?></div>
                  <div class="tbay-countdown" data-id="<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>" id="countdown-<?php echo esc_attr($_id); ?>-<?php echo esc_attr($product->get_id()); ?>" data-countdown="countdown" data-date="<?php echo date('m', $time_sale).'-'.date('d', $time_sale).'-'.date('Y', $time_sale).'-'. date('H', $time_sale) . '-' . date('i', $time_sale) . '-' .  date('s', $time_sale) ; ?>"  data-days="<?php echo esc_attr($day); ?>" data-hours="<?php echo esc_attr( $hours ); ?>" data-mins="<?php echo esc_attr($mins); ?>" data-secs="<?php echo esc_attr( $secs ); ?>">
                  </div>
              </div> 


              <?php if($product->get_manage_stock()) {?>
                <div class="stock">
                  <?php
                    $total_sales    = $product->get_total_sales();
                    $stock_quantity   = $product->get_stock_quantity();

                    if($stock_quantity > 0) {
                      $total_quantity   = (int)$total_sales + (int)$stock_quantity;
                      $sold         = (int)$total_sales / (int)$total_quantity;
                      $percentsold    = $sold*100;
                    }
                  ?>
                  <?php if($stock_quantity > 0) { ?>
                    <span class="tb-sold"><?php echo esc_html__('Sold', 'urna'); ?> : <span class="totals-sold"><?php echo esc_html($total_sales) ?></span></span>
                  <?php } else { ?>
                    <span class="tb-sold"><?php echo esc_html__('Sold out', 'urna'); ?></span>
                  <?php } ?>

                  <?php if( isset($percentsold) ) { ?>
                    <div class="progress">
                      <div class="progress-bar active" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo esc_attr($percentsold); ?>%">
                      </div>
                    </div>
                  <?php } ?>
                </div>
              <?php } ?>

            </div> 
        <?php endif; ?> 
        <?php
    }
}

/*product nav*/

/*Get display product nav*/
if ( !function_exists('urna_tbay_woocommerce_product_nav_display_mode') ) {
    function urna_tbay_woocommerce_product_nav_display_mode($mode) {
        $mode = urna_tbay_get_config('product_nav_display_mode', 'image');

        $mode = (isset($_GET['display_nav_mode'])) ? $_GET['display_nav_mode'] : $mode;

        return $mode;
    }
    add_filter( 'urna_woo_nav_display_mode', 'urna_tbay_woocommerce_product_nav_display_mode' );
}


/*Get display product nav*/

if ( !function_exists('urna_render_product_nav') ) {
  function urna_render_product_nav($post, $position){
      if($post){
          $product = wc_get_product($post->ID);
          $img = '';
          if(has_post_thumbnail($post)){
              $img = get_the_post_thumbnail($post, 'woocommerce_gallery_thumbnail');
          }
          $link = get_permalink($post);

          $left_content = ($position == 'left') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';
          $right_content = ($position == 'right') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';
          echo "<div class='". esc_attr( $position ) ." psnav'>";

          echo trim($left_content); 
          echo "<div class='product_single_nav_inner single_nav'>
                    <a href=". esc_url($link) .">
                        <span class='name-pr'>". esc_html($post->post_title) ."</span>
                    </a>
                </div>";    
            echo trim($right_content);   
          echo "</div>";
      }
  }
}

if ( !function_exists('urna_woo_product_nav_image') ) {
  function urna_woo_product_nav_image(){
    if ( urna_tbay_get_config('show_product_nav', false) ) {
          $display_mode = apply_filters( 'urna_woo_nav_display_mode', 10,2 );
          if(isset($display_mode) && $display_mode != 'image') return;

          $prev = get_previous_post();
          $next = get_next_post();

          echo '<div class="product-nav pull-right">';  
          echo '<div class="link-images visible-lg">';
          urna_render_product_nav($prev, 'left');
          urna_render_product_nav($next, 'right');
          echo '</div>';

          echo '</div>';
    }
  }

  add_action( 'woocommerce_before_single_product_summary', 'urna_woo_product_nav_image', 1 );
}


/*Product nav icon*/
if ( !function_exists('urna_woo_product_nav_icon') ) {
  function urna_woo_product_nav_icon(){
        if ( urna_tbay_get_config('show_product_nav', false) ) {

            $display_mode = apply_filters( 'urna_woo_nav_display_mode', 10,2 );

            $output = '';

            if( !is_singular( 'product' ) || (isset($display_mode) && $display_mode == 'image') ) return;

            $prev = get_previous_post();
            $next = get_next_post();

            $output .= '<div class="product-nav-icon pull-right">';  
            $output .= '<div class="link-icons">';
            $output .= urna_render_product_nav_icon($prev, 'left');
            $output .= urna_render_product_nav_icon($next, 'right');
            $output .= '</div>';

            $output .= '</div>';

            return $output;
        }
  }
}

if ( !function_exists('urna_render_product_nav_icon') ) {
  function urna_render_product_nav_icon($post, $position){
      if($post){
          $product = wc_get_product($post->ID);
          $output = '';
          $img = '';
          if(has_post_thumbnail($post)){
              $img = get_the_post_thumbnail($post, 'woocommerce_gallery_thumbnail');
          }
          $link = get_permalink($post);

          $output .= "<div class='". esc_attr( $position ) ."-icon icon-wrapper'>";
            $output .= "<div class='text'>";

                $output .= ($position == 'left') ? "<a class='img-link left' href=". esc_url($link) ."><span class='product-btn-icon'></span>". esc_html__('Prev', 'urna') . "</a>" :'';                  

                $output .= ($position == 'right') ? "<a class='img-link right' href=". esc_url($link) .">". esc_html__('Next', 'urna') . "<span class='product-btn-icon'></span></a>" :'';  


            $output .= "</div>";
            $output .= "<div class='image psnav'>";
            $output .= ($position == 'left') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';  
            $output .= "<div class='product_single_nav_inner single_nav'>
                        <a href=". esc_url($link) .">
                            <span class='name-pr'>". esc_html($post->post_title) ."</span>
                            <span class='price'>" . $product->get_price_html() . "</span>
                        </a>
                    </div>";
            $output .= ($position == 'right') ? "<a class='img-link' href=". esc_url($link) .">". trim($img). "</a>" :'';   
            $output .= "</div>";
          $output .= "</div>";

          return $output;
      }
  }
}

if ( !function_exists('urna_tbay_woocommerce_product_menu_bar') ) {
    function urna_tbay_woocommerce_product_menu_bar($menu_bar) {
          $menu_bar   = urna_tbay_get_config('enable_sticky_menu_bar', false);

          if ( isset($_GET['sticky_menu_bar']) ) {
              $menu_bar = $_GET['sticky_menu_bar'];
          }

          return $menu_bar;
    }
    add_filter( 'woo_product_menu_bar', 'urna_tbay_woocommerce_product_menu_bar' );
}

/**Sticky Menu Bar**/

if(!function_exists('urna_sticky_menu_bar')){
  if(!wp_is_mobile() ) {
    add_action( 'woocommerce_before_single_product', 'urna_sticky_menu_bar', 30 );

    add_action( 'urna_sticky_menu_bar_product_summary', 'woocommerce_template_single_title', 5 );
    add_action( 'urna_sticky_menu_bar_product_summary', 'woocommerce_template_loop_rating', 10 );
    add_action( 'urna_sticky_menu_bar_product_summary', 'urna_woo_product_single_one_page', 15 );


    add_action( 'urna_sticky_menu_bar_product_price_cart', 'woocommerce_template_single_price', 5 );
    add_action( 'urna_sticky_menu_bar_product_price_cart', 'urna_sticky_menu_bar_custom_add_to_cart', 10 );
  }
  function urna_sticky_menu_bar() {
    global $post, $product;

      $menu_bar   =  apply_filters( 'woo_product_menu_bar', 10, 2 );

      if(  !$menu_bar ) return;



      $img = '';
      if(has_post_thumbnail($post)){
          $img = get_the_post_thumbnail($post, 'woocommerce_gallery_thumbnail');
      }

      ?>

      <div id="sticky-menu-bar">
        <div class="container">
          <div class="row">
            <div class="menu-bar-left col-md-7">
                <div class="media">
                  <div class="media-left media-top pull-left">
                    <?php echo trim($img); ?>
                  </div>
                  <div class="media-body">
                    <?php 
                      do_action( 'urna_sticky_menu_bar_product_summary' );
                    ?>
                  </div>
                </div>
            </div>
            <div class="menu-bar-right col-md-5">
                <?php 
                  do_action( 'urna_sticky_menu_bar_product_price_cart');
                ?>
            </div>
          </div>
        </div>
      </div>

      <?php

  }
}

function urna_sticky_menu_bar_custom_add_to_cart() {
  global $product; 

    if( !$product->is_in_stock() ) {
      echo wc_get_stock_html( $product );
    } else {
      ?> 
        <a id="sticky-custom-add-to-cart" href="javascript:void(0);"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></a>
    <?php 
  }
}

if(!function_exists('urna_woo_product_single_one_page')){
    function urna_woo_product_single_one_page() {

        $menu_bar   =  apply_filters( 'woo_product_menu_bar', 10, 2 );

        if( isset($menu_bar) && $menu_bar ) {
          global $product;
          $id = $product->get_id();
          wp_enqueue_script( 'jquery-onepagenav' );
          ?>

          <ul id="onepage-single-product" class="nav nav-pills">
            <li class="onepage-overview"><a href="#tbay-header"><?php esc_html_e('Overview','urna'); ?></a></li>
            <li class="onepage-description"><a href="#woocommerce-tabs"><?php esc_html_e('Specifications','urna'); ?></a></li>   
 
            <?php if( urna_tbay_get_config('enable_product_releated', true) ) : ?>
              <li><a href="#product-related"><?php esc_html_e('Related Products','urna'); ?></a></li>  
            <?php endif; ?>         
          </ul>

          <?php
          
        }
    }
}

/*product one page body class*/
if ( ! function_exists( 'urna_woo_product_body_class_single_one_page' ) ) {
  function urna_woo_product_body_class_single_one_page( $classes ) {

    $menu_bar   =  apply_filters( 'woo_product_menu_bar', 10, 2 );

    if( isset($menu_bar) && $menu_bar && is_product() ) {
      $classes[] = 'tbay-body-menu-bar';
    }
    return $classes;

  }
  add_filter( 'body_class', 'urna_woo_product_body_class_single_one_page',99 );
}


if(!function_exists('urna_add_product_id_before_add_to_cart_form')){
add_action('woocommerce_before_add_to_cart_button','urna_add_product_id_before_add_to_cart_form', 99);
  function  urna_add_product_id_before_add_to_cart_form() {
      global $product;
      $id = $product->get_id();

      ?> 

      <?php if( intval( urna_tbay_get_config('enable_buy_now', false) ) && $product->get_type() !== 'external' ) : ?>
        <div id="shop-now" class="has-buy-now">
      <?php else: ?> 
        <div id="shop-now">
      <?php endif; ?>

      <?php
  }
}

if(!function_exists('urna_close_after_add_to_cart_form')){
  add_action('woocommerce_after_add_to_cart_button','urna_close_after_add_to_cart_form', 99);
  function  urna_close_after_add_to_cart_form() {
      ?>
        </div>
      <?php
  }
}

/** 
 * remove on single product panel 'Additional Information' since it already says it on tab.
 */
add_filter('woocommerce_product_additional_information_heading', 'urna_supermaket_product_additional_information_heading');
 
function urna_supermaket_product_additional_information_heading() {
    echo '';
}

if(!function_exists('urna_related_products_args')){
  add_filter( 'woocommerce_output_related_products_args', 'urna_related_products_args' );
    function urna_related_products_args( $args ) {

    $args['posts_per_page'] = urna_tbay_get_config('number_product_releated', 4); // 4 related products

    return $args;
  }
}


if ( !function_exists('urna_tbay_get_video_product') ) {
  add_action( 'woocommerce_before_single_product_summary', 'urna_tbay_get_video_product', 30 );
  function  urna_tbay_get_video_product() {
    global $post, $product;


    if( get_post_meta( $post->ID, '_video_url', true ) ) {
      $video = urna_tbay_VideoUrlType(get_post_meta( $post->ID, '_video_url', true ));

      if( $video['video_type'] == 'youtube' ) {
        $url  = 'https://www.youtube.com/embed/'.$video['video_id'].'?autoplay=1';
        $icon = '<i class="linear-icon-play" aria-hidden="true"></i>'.esc_html__('Watch Video','urna');

      }elseif(( $video['video_type'] == 'vimeo' )) {
        $url = 'https://player.vimeo.com/video/'.$video['video_id'].'?autoplay=1';
        $icon = '<i class="linear-icon-play" aria-hidden="true"></i>'.esc_html__('Watch Video','urna');

      }

    }

    ?>

    <?php if( !empty($url) ) : ?>

      <div class="modal fade" id="productvideo">
        <div class="modal-dialog">
          <div class="modal-content tbay-modalContent">

            <div class="modal-body">
              
              <div class="close-button">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="embed-responsive embed-responsive-16by9">
                          <iframe class="embed-responsive-item"></iframe>
              </div>
            </div>

          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <button type="button" class="tbay-modalButton" data-toggle="modal" data-tbaySrc="<?php echo esc_attr($url); ?>" data-tbayWidth="640" data-tbayHeight="480" data-target="#productvideo"  data-tbayVideoFullscreen="true"><?php echo trim($icon); ?></button>

    <?php endif; ?>
  <?php
  }
}

if ( !function_exists('urna_add_product_size_guide_hook') ) {
  function urna_add_product_size_guide_hook() {
      $active = urna_tbay_get_config('enable_size_guide', false);

      global $post;

      if ( !$active || !metadata_exists( 'post', $post->ID, '_product_size_guide_image' ) )  return;

      $attachment_id = get_post_meta( $post->ID, '_product_size_guide_image', true );
      if( empty($attachment_id) )  return;

      add_filter( 'woocommerce_reset_variations_link', 'urna_add_product_size_guide', 25 );
      add_filter( 'woocommerce_before_single_variation', 'urna_add_product_size_guide_content', 25 );
  }

  add_action( 'woocommerce_before_single_product' ,'urna_add_product_size_guide_hook' , 100 );
}

if ( !function_exists('urna_add_product_size_guide') ) {

  function urna_add_product_size_guide() {

    $active = urna_tbay_get_config('enable_size_guide', false);
    $icon = urna_tbay_get_config('size_guide_icon', '');

    global $post;

    if ( !$active || !metadata_exists( 'post', $post->ID, '_product_size_guide_image' ) )  return;

      $attachment_id = get_post_meta( $post->ID, '_product_size_guide_image', true );

      $title = urna_tbay_get_config('size_guide_title', false);

      $image = wp_get_attachment_image( $attachment_id, 'full' );
    ?> 

    <button type="button" class="btn-size-guide" data-toggle="modal" data-target="#product-size-guide">
        <?php 
          if( !empty($icon) ) {
            echo '<i class="'.$icon.'"></i>';
          }
        ?>
      <?php echo trim($title); ?>
    </button>
    <a class="reset_variations" href="#"><?php esc_html_e( 'Clear', 'urna' ) ?></a>
    <?php
  }
}


if ( !function_exists('urna_add_product_size_guide_content') ) {

  function urna_add_product_size_guide_content() {

    $active = urna_tbay_get_config('enable_size_guide', false);
    $icon = urna_tbay_get_config('size_guide_icon', '');

    global $post;

    if ( !$active || !metadata_exists( 'post', $post->ID, '_product_size_guide_image' ) )  return;

      $attachment_id = get_post_meta( $post->ID, '_product_size_guide_image', true );

      if( empty($attachment_id) ) return;

      $title = urna_tbay_get_config('size_guide_title', false);

      $image = wp_get_attachment_image( $attachment_id, 'full' );
    ?> 



    <!-- Modal -->
    <div id="product-size-guide" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="linear-icon-cross2"></i></button>
            <h4 class="modal-title"><?php echo trim($title); ?></h4>
          </div>
          <div class="modal-body">
            <?php echo trim($image); ?>
          </div>
        </div>

      </div>
    </div>
    <?php
  }
}

if (!function_exists('urna_tbay_display_custom_tab_builder') ) {
  function urna_tbay_display_custom_tab_builder($tabs) {
    global $tabs_builder;
    $tabs_builder = true;
    $args = array(
      'name'        => $tabs,
      'post_type'   => 'tbay_customtab',
      'post_status' => 'publish',
      'numberposts' => 1
    );

    $tabs = array();

    $posts = get_posts($args);
    foreach ( $posts as $post ) {
      $tabs['title'] = $post->post_title;
      $tabs['content'] = do_shortcode( $post->post_content );
      return $tabs;
    }
    $tabs_builder = false;
  }
}


if ( !function_exists( 'urna_tbay_product_review_tab' ) ) {
    function urna_tbay_product_review_tab($tabs) {
        if ( !urna_tbay_get_config('enable_product_review_tab', true) && isset($tabs['reviews']) ) {
            unset( $tabs['reviews'] ); 
        }
        return $tabs;
    }
}
add_filter( 'woocommerce_product_tabs', 'urna_tbay_product_review_tab', 100 );


/*Custom tabs*/
if ( !function_exists( 'urna_tbay_product_remove_aditional_tab' ) ) {
    function urna_tbay_product_remove_aditional_tab($tabs) {

        $tab = urna_tbay_get_config('custom_tab_type', '');

        if ( (!urna_tbay_get_config('enable_custom_tab', false) || empty($tab)) && isset($tabs['custom_tab']) ) {
            unset( $tabs['custom_tab'] ); 
        }


        return $tabs;
    }
}
add_filter( 'woocommerce_product_tabs', 'urna_tbay_product_remove_aditional_tab', 120 );


/**
 * Add a custom product data tab
 */

if ( !function_exists( 'urna_product_aditional_tab' ) ) {
    add_filter( 'woocommerce_product_tabs', 'urna_product_aditional_tab', 110 );
    function urna_product_aditional_tab( $tabs ) {
        $tab = urna_tbay_get_config('custom_tab_type', '');

        $output_tab       =    urna_tbay_display_custom_tab_builder($tab);
        
        $tabs['custom_tab'] = array(
            'title'     => $output_tab['title'],
            'priority'  => 50,
            'callback'  => 'urna_product_custom_tab_content',
        );

        return $tabs;
    }
}

if ( !function_exists( 'urna_product_custom_tab_content' ) ) {
    function urna_product_custom_tab_content() {
        $tab = urna_tbay_get_config('custom_tab_type', '');

        $output_tab       =    urna_tbay_display_custom_tab_builder($tab);

        echo trim($output_tab['content']);
        
    }
}


if ( !function_exists( 'urna_product_single_edit_layout_width_full' ) ) {
    function urna_product_single_edit_layout_width_full() {
        $sidebar_configs  = urna_tbay_get_woocommerce_layout_configs();
        $images_layout    = $sidebar_configs['thumbnail'];

        if( isset($images_layout) && ($images_layout =='full' || $images_layout == 'carousel' ) ) {

            remove_action('woocommerce_single_product_summary', 'urna_tbay_woocommerce_share_box', 50);
            add_action('woocommerce_single_product_summary', 'urna_tbay_woocommerce_share_box', 35);

        }

    }

    add_action('woocommerce_before_single_product', 'urna_product_single_edit_layout_width_full');
}


if ( !function_exists( 'urna_tbay_enable_zoom_image' ) ) {
    function urna_tbay_enable_zoom_image() {
        $active = urna_tbay_get_config('enable_zoom_image', true);

        if ( isset($_GET['enable_zoom_image']) ) {
          $active = $_GET['enable_zoom_image'];
        }

        return $active;
    }
}
add_filter( 'urna_zoom_image', 'urna_tbay_enable_zoom_image', 120 );

if ( !function_exists( 'urna_remove_support_zoom_image' ) ) {
  function urna_remove_support_zoom_image() {
    $active = apply_filters( 'urna_zoom_image', 10,2 );

    if( !$active ) {
      wp_dequeue_script( 'zoom' );
    }
  }

  add_action('woocommerce_before_single_product', 'urna_remove_support_zoom_image', 60);
}

/**
 * Add a confirm password field to the checkout registration form.
 */
if ( !function_exists( 'urna_woocommerce_confirm_password_checkout' ) ) {
  function urna_woocommerce_confirm_password_checkout( $checkout ) {
      if ( get_option( 'woocommerce_registration_generate_password' ) == 'no' ) {

          $fields = $checkout->get_checkout_fields();

          $fields['account']['account_confirm_password'] = array(
              'type'              => 'password',
              'label'             => esc_html__( 'Confirm password', 'urna' ),
              'required'          => true,
              'placeholder'       => _x( 'Confirm Password', 'placeholder', 'urna' )
          );

          $checkout->__set( 'checkout_fields', $fields );
      }
  }
  add_action( 'woocommerce_checkout_init', 'urna_woocommerce_confirm_password_checkout', 10, 1 );
}

/**
 * Validate that the two password fields match.
 */
if ( !function_exists( 'urna_woocommerce_confirm_password_validation' ) ) {
  function urna_woocommerce_confirm_password_validation( $posted ) {
      $checkout = WC()->checkout;
      if ( ! is_user_logged_in() && ( $checkout->must_create_account || ! empty( $posted['createaccount'] ) ) ) {
          if ( strcmp( $posted['account_password'], $posted['account_confirm_password'] ) !== 0 ) {
              wc_add_notice( esc_html__( 'Passwords do not match.', 'urna' ), 'error' );
          }
      }
  }
  add_action( 'woocommerce_after_checkout_validation', 'urna_woocommerce_confirm_password_validation', 10, 2 );
}

if ( !function_exists( 'urna_wc_register_form_password_repeat' ) ) {
  function urna_wc_register_form_password_repeat() {

    if( 'yes' === get_option( 'woocommerce_registration_generate_password' ) || class_exists('WCMp') )  return;

    ?>
    <p class="form-row form-row-wide">
      <input type="password" class="input-text" placeholder="<?php esc_attr_e('Confirm Password', 'urna'); ?>" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
    </p>
    <?php
  } 
  add_action( 'woocommerce_register_form', 'urna_wc_register_form_password_repeat', 0 );
}

// ----- validate password match on the registration page
if ( !function_exists( 'urna_registration_errors_validation' ) ) {
  function urna_registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
    global $woocommerce;
    extract( $_POST );
    if ( strcmp( $password, $password2 ) !== 0 ) {
      return new WP_Error( 'registration-error', esc_html__( 'Passwords do not match.', 'urna' ) );
    }
    return $reg_errors;
  }
  add_filter('woocommerce_registration_errors', 'urna_registration_errors_validation', 10,3);
}


/*Add custom html before, after button add to cart*/
if(!function_exists('urna_action_woocommerce_before_add_to_cart_button')){
  function urna_action_woocommerce_before_add_to_cart_button(  ) { 
      $content = urna_tbay_get_config('html_before_add_to_cart_btn');
      echo trim($content);
  }
  add_action( 'woocommerce_before_add_to_cart_form', 'urna_action_woocommerce_before_add_to_cart_button', 10, 0 ); 
}
if(!function_exists('urna_action_woocommerce_after_add_to_cart_button')){
  function urna_action_woocommerce_after_add_to_cart_button(  ) { 
      $content = urna_tbay_get_config('html_after_add_to_cart_btn');
      echo trim($content); 
  }
  add_action( 'woocommerce_after_add_to_cart_form', 'urna_action_woocommerce_after_add_to_cart_button', 999, 0 ); 
}

/*Add The WooCommerce Total Sales Count*/
if(!function_exists('urna_single_product_add_total_sales_count')){ 
  function urna_single_product_add_total_sales_count() { 
    global $product;

    if( !intval( urna_tbay_get_config('enable_total_sales', true) ) || $product->get_type() == 'external' ) return;

    $count = get_post_meta($product->get_id(),'total_sales', true); 

    $text = sprintf( '<span class="rate-sold"><span class="count">%s</span> <span class="sold-text">%s</span></span>',
        number_format_i18n($count),
        esc_html__('sold', 'urna')
    );

    echo trim($text);
  }
  add_action( 'urna_woo_after_single_rating', 'urna_single_product_add_total_sales_count', 10 ); 
}


/*Photo Reviews Size*/
if(!function_exists('urna_photo_reviews_thumbnail_photo_size')){ 
  function urna_photo_reviews_thumbnail_photo_size($image_src, $image_post_id) { 
    $img_src     = wp_get_attachment_image_src($image_post_id, 'tbay_photo_reviews_thumbnail_image');

    return $img_src[0];
  }
  add_filter( 'woocommerce_photo_reviews_thumbnail_photo', 'urna_photo_reviews_thumbnail_photo_size', 10, 2 );
}

if(!function_exists('urna_photo_reviews_large_photo_size')){ 
  function urna_photo_reviews_large_photo_size($image_src, $image_post_id) { 
    $img_src     = wp_get_attachment_image_src($image_post_id, 'full');

    return $img_src[0];
  }
  add_filter( 'woocommerce_photo_reviews_large_photo', 'urna_photo_reviews_large_photo_size', 10, 2 );
}