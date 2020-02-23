<div id="sidebar">

    <div id="header"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo('name'); ?>"> <?php $logo = (get_option('basic_logo') <> '') ? get_option('basic_logo') : get_template_directory_uri().'/images/logo-'.get_option('basic_color_scheme').'.gif';?>
	<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="logo"/></a> </div>

    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Sidebar") ) : ?>
    <?php endif; ?>
</div>
</div>