 <?php
 global $post;
  global $current_user;
  $user_id  = empty( $user_id ) ? get_current_user_id() : $user_id;
 $logininnerlogo= get_theme_mod( 'dash_inner_logo', get_template_directory_uri().'/images/logo.png' );
 ?>
 <?php
                            if ( is_user_logged_in() ) { ?>
					    <div class="extended-dasboard-tab">
					      <div class="logo-dashboard">
        
              <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo_box">
                  <img src="<?php echo esc_url($logininnerlogo);  ?>" class="img-responsive" alt="<?php esc_html( 'Logo', 'mayosis' ); ?>"/>
                  </a>
    </div>
        					   <ul class="nav nav-pills">
                                  <li class="active"><a href="#profile" data-toggle="tab"><i class="zil zi-user"></i> <?php esc_html_e('Profile','mayosis'); ?></a></li>
                                  <li><a href="#purchase" data-toggle="tab"><i class="zil zi-bars"></i> <?php esc_html_e('Purchase History','mayosis'); ?></a></li>
                                  <li><a href="#download" data-toggle="tab"><i class="zil zi-cube"></i> <?php esc_html_e('Download History','mayosis'); ?></a></li>
                                   <li><a href="#follow-recent" data-toggle="tab"><i class="zil zi-grid"></i> <?php esc_html_e('Followed Items','mayosis'); ?></a></li>
                                   <?php if( class_exists( 'EDD_All_Access' ) ) { ?>
                                   <li><a href="#access-pass" data-toggle="tab"><i class="zil zi-circle-dot"></i> <?php esc_html_e('Access Pass','mayosis'); ?></a></li>
                                   <?php } ?>
                                    <?php if( class_exists( 'EDD_Recurring' ) ) { ?>
                                    <li><a href="#subscription" data-toggle="tab"><i class="zil zi-tag"></i> <?php esc_html_e('Subscription','mayosis'); ?></a></li>
                                    <?php } ?>
                                </ul>
					        <div class="user-information-ex-dashboard">
     <a href="#" data-toggle="dropdown"> <?php echo get_avatar( $user_id,40 ) ?> <?php echo esc_html($current_user->display_name ); ?></a>
</div>
					    </div>
					   <?php }?>
					   <div class="extended-tab-content">
					   	<div class="tab-content user--dasboard--box clearfix">
			 			 <div class="tab-pane active" id="profile">
			 			      <?php echo do_shortcode('[edd_profile_editor]');?>
			 			     </div>
			 			     
			 			     <div class="tab-pane" id="purchase">
			 			      <?php echo do_shortcode('[purchase_history]');?>
			 			     </div>
			 			     
			 			     <div class="tab-pane" id="download">
			 			      <?php echo do_shortcode('[download_history]');?>
			 			     </div>
			 			     
			 			     
			 			      <div class="tab-pane" id="follow-recent">
			 			        <?php echo do_shortcode('[following_posts]'); ?>
			 			        
			 			     </div>
			 			     <?php if( class_exists( 'EDD_All_Access' ) ) { ?>
			 			      <div class="tab-pane" id="access-pass">
			 			        <?php echo do_shortcode('[edd_aa_customer_passes]'); ?>
			 			        
			 			     </div>
			 			     <?php } ?>
			 			     <?php if( class_exists( 'EDD_Recurring' ) ) { ?>
			 			     <div class="tab-pane" id="subscription">
			 			        <?php echo do_shortcode('[edd_subscriptions]'); ?>
			 			        
			 			     </div>
			 			     <?php } ?>
					</div>
					</div>