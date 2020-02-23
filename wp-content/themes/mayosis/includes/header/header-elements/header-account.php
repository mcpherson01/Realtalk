<?php
defined('ABSPATH') or die();
 global $current_user;
wp_get_current_user();
$bgremovelogin= get_theme_mod( 'login_logout_bg_remove' );
$loginlink= get_theme_mod( 'login_url' );
$logintext= get_theme_mod( 'login_text','Login' );
$logouttext= get_theme_mod( 'logout_text','Logout' );
$accountmenus = get_theme_mod( 'my_account_repeater',  array() ); 
?>
<ul id="account-button" class="mayosis-option-menu hidden-xs hidden-sm">
   <?php
	if (!is_user_logged_in())
		{ ?> 
<li class="menu-item">
            <?php

            if ($bgremovelogin == 'remove'): ?>
    <a href="<?php
		echo esc_url($loginlink); ?>"><i class="zil zi-user"></i> <?php echo esc_html($logintext); ?></a>
            <?php else : ?>

                <a href="<?php
                echo esc_url($loginlink); ?>" class="login-button"><i class="zil zi-user"></i> <?php echo esc_html($logintext); ?></a>
            <?php endif; ?>
</li>

<?php
		}
	  else
		{ ?>

		<li class="dropdown cart_widget cart-style-one menu-item my-account-menu">
    <a href="#" data-toggle="dropdown"><i class="zil zi-user"></i> <?php echo esc_html($current_user->display_name ); ?></a>
     <?php wp_nav_menu( 
	array( 
	'theme_location' => 'account-menu', 
	'menu_class' => 'dropdown-menu my-account-list',
	'fallback_cb' => 'mayosis_menu_walker::fallback',
	'walker'  => new mayosis_menu_walker()
	) 
); ?>
  
</li>

<?php } ?>
</ul>

<div id="account-mob" class="mayosis-option-menu hidden-md hidden-lg">
    <?php
	if (!is_user_logged_in())
		{ ?> 
		<div id="mayosis-sidemenu">
		  <ul>
               <li class="menu-item">
                <a href="<?php
            		echo esc_url($loginlink); ?>"><i class="zil zi-user"></i> <?php echo esc_html($logintext); ?></a>
            </li>
        </ul>
</div>
<?php } else { ?>
 <?php wp_nav_menu( 
	array( 
	'theme_location' => 'account-menu', 
	'container_id' => 'mayosis-sidemenu',
	'fallback_cb' => 'mayosis_menu_walker::fallback',
	'walker'  => new mayosis_accordion_navwalker()
	) 
); ?>

<?php } ?>
   
</div>