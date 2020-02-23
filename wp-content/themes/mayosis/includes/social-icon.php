<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $mayosis_options; 

$sociallinks= get_theme_mod('social_icons_repeat', array()); 

?>
<ul class="top-social-icon">
    <?php foreach( $sociallinks as $item ) : ?>
    					 	<li><a href="<?php echo esc_url($item['link_url']); ?>" target="_blank"><i class="fa fab <?php echo esc_html($item['link_icon']); ?>"></i></a></li>
    					<?php endforeach; ?>	
    			
    </ul>