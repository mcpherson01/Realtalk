<?php
defined('ABSPATH') or die();

?>
	<span class="toolspan"><?php esc_html_e("by","mayosis"); ?></span> <a href="<?php echo esc_url(add_query_arg( 'author_downloads', 'true', get_author_posts_url( get_the_author_meta('ID')) )); ?>"><?php the_author(); ?></a>