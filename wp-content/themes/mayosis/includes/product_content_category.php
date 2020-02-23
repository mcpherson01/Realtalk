<?php
defined('ABSPATH') or die();
	$download_cats = get_the_term_list( get_the_ID(), 'download_category', '', _x(' , ', '', 'mayosis' ), '' );
?>
	

                       	<span class="toolspan"><?php esc_html_e("in","mayosis"); ?></span> <?php echo '<span>' . $download_cats . '</span>'; ?>