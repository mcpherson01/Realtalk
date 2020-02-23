<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>/">
    <div>
        <input type="image" id="searchsubmit" value="<?php esc_attr_e('Search','ColdStone') ?>" src="<?php echo get_template_directory_uri(); ?>/img/search-button-<?php echo esc_attr(get_option('coldstone_color_scheme')); ?>.gif" />
        <input type="text" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="s" />
    </div>
</form>