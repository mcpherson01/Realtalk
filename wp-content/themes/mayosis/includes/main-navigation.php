<?php
$menu_position = get_theme_mod( 'menu_position','text-right');
?>
<div class="main-navigation <?php echo esc_attr($menu_position); ?>">                     
<?php wp_nav_menu( 
	array( 
	'theme_location' => 'main-menu', 
	'container_id' => 'mayosis-menu',
	'fallback_cb' => 'mayosis_menu_walker::fallback',
	'walker'  => new mayosis_menu_walker()
	) 
); ?>
</div>