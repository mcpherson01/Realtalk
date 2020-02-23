<?php

if (!defined('ABSPATH'))
	{
	exit; // Exit if accessed directly.
	}
$topheadercart= get_theme_mod( 'top_cart','on' );
$topheaderlogin= get_theme_mod( 'top_login','on' );
$loginlink= get_theme_mod( 'login_url' );
?>
<ul id="cart-menu" class="nav navbar-nav top-cart-menu">
    	<?php

if ($topheadercart == 'on'): ?>
	<?php get_template_part( 'includes/cart-header-main' ); ?>
<?php
endif ?>

	<?php

if ($topheaderlogin == 'on'): ?>
<?php
	if (!is_user_logged_in())
		{ ?> <li class="menu-item pull-right"><a href="<?php
		echo esc_url($loginlink); ?>" class="login-button" data-toggle="tooltip" data-placement="bottom" title="Click for Login or Register"><i class="fa fa-user"></i> <?php
		esc_html_e("Login", "mayosis"); ?></a></li>
				<?php
		}
	  else
		{ ?>
				<li class="menu-item pull-right"><a href="<?php
		echo esc_url(wp_logout_url(home_url('/'))); ?>" class="login-button"><i class="fas fa-sign-out-alt"></i> <?php
		esc_html_e('Logout', 'mayosis'); ?></a></li><?php
		} ?>
<?php
endif ?>
</ul>
