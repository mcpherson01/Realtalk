<?php
defined('ABSPATH') or die();
 global $current_user;
wp_get_current_user();
$loginlink= get_theme_mod( 'login_url' );
$logintext= get_theme_mod( 'login_text','Login' );
$logouttext= get_theme_mod( 'logout_text','Logout' );
$accountmenus = get_theme_mod( 'my_account_repeater',  array() ); 
?>
   <?php
	if (!is_user_logged_in())
		{ ?> 
<li class="menu-item">
    <a href="<?php
		echo esc_url($loginlink); ?>"><i class="fa fa-user-circle"></i> <?php echo esc_html($logintext); ?></a>
</li>

<?php
		}
	  else
		{ ?>

		<li class="dropdown cart_widget cart-style-one menu-item my-account-menu">
    <a href="#" data-toggle="dropdown"><i class="fa fa-user-circle"></i> <?php echo esc_html($current_user->user_login) ; ?></a>
    <ul class="dropdown-menu my-account-list">
        <?php foreach( $accountmenus as $menu ) : ?>
                <li>
                    <a href="<?php echo esc_url($menu['link_url']); ?>"><?php echo esc_html($menu['link_text']); ?></a>
                </li>
                <?php endforeach; ?>
                	<li class="menu-item"><a href="<?php
		echo esc_url(wp_logout_url(home_url('/'))); ?>" class=""><?php echo esc_html($logouttext); ?></a></li>
    </ul>
</li>

<?php } ?>