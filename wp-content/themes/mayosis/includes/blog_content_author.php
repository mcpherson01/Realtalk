<?php
defined('ABSPATH') or die(); ?>
<span class="toolspan"><?php esc_html_e("by","mayosis"); ?></span> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta('ID') )); ?>" class="blog--layout--contents"><?php the_author(); ?></a>