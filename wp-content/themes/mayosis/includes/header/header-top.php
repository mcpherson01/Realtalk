<?php

$topheaderlayout = get_theme_mod( 'main_top_header_layout','one');
$topmiddlealign = get_theme_mod( 'top_middle_header_align','flexleft');
$topleftalign = get_theme_mod( 'top_left_header_align','flexleft');
$toprightalign = get_theme_mod( 'top_right_header_align','flexright');
$topmobilealign = get_theme_mod( 'top_mobile_header_align','flexright');
?>

      <?php if ($topheaderlayout == 'two'): ?>
        <div class="to-flex-row th-flex-equal-sides">
      <?php else : ?>
          <div class="to-flex-row  th-flex-flex-middle">
       <?php endif; ?>
      <div class="to-flex-col th-col-left hidden-sm hidden-xs <?php echo  esc_html($topleftalign); ?>">
         
              <?php mayosis_header_elements('topbar_elements_left'); ?>
         
      </div>

      <div class="to-flex-col th-col-center hidden-sm hidden-xs <?php echo  esc_html($topmiddlealign); ?>">
          
              <?php mayosis_header_elements('topbar_elements_center'); ?>
        
      </div><!-- center -->

      <div class="to-flex-col th-col-right hidden-sm hidden-xs <?php echo  esc_html($toprightalign); ?>">
         
              <?php mayosis_header_elements('topbar_elements_right'); ?>
          
      </div><!-- .to-flex-col right -->

    
      <div class="to-flex-col hidden-md hidden-lg flex-grow <?php echo  esc_html($topmobilealign); ?>">
              <?php mayosis_header_elements('header_mobile_elements_top'); ?>
      </div>

    </div><!-- .to-flex-row -->


