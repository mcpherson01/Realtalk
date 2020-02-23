<?php if (get_option('basic_home_link') == 'on') { ?>
	<li class="page_item home"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="title" title="home again woohoo"><?php esc_html_e('Home','Basic') ?></a></li>
<?php } ?>