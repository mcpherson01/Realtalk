<?php

if (!defined('ABSPATH'))
	{
	exit; // Exit if accessed directly.
	}
$bgremovelogin= get_theme_mod( 'login_logout_bg_remove' );
$loginlink= get_theme_mod( 'login_url' );
$logintext= get_theme_mod( 'login_text','Login' );
$logouttext= get_theme_mod( 'logout_text','Logout' );
?>
<?php

if ($bgremovelogin == 'remove'): ?>
<?php
	if (!is_user_logged_in())
		{ ?> 
		
		<li class="menu-item"><a href="<?php
		echo esc_url($loginlink); ?>" class="" data-toggle="tooltip" data-placement="bottom"><i class="zil zi-user"></i> <?php echo esc_html($logintext); ?> </a></li>
				<?php
		}
	  else
		{ ?>
				<li class="menu-item"><a href="<?php
		echo esc_url(wp_logout_url(home_url('/'))); ?>" class=""><i class="zil zi-sign-out"></i> <?php echo esc_html($logouttext); ?></a></li><?php
		} ?>
				<?php
else: ?>
				<?php
	if (!is_user_logged_in())
		{ ?> <li class="menu-item"><a href="<?php
		echo esc_url($loginlink); ?>" class="login-button" data-toggle="tooltip" data-placement="bottom"><i class="zil zi-user"></i> <?php echo esc_html($logintext); ?></a></li>
				<?php
		}
	  else
		{ ?>
				<li class="menu-item"><a href="<?php
		echo esc_url(wp_logout_url(home_url('/'))); ?>" class="login-button"><i class="zil zi-sign-out"></i> <?php echo esc_html($logouttext); ?></a></li><?php
		} ?>
				<?php
endif; ?>