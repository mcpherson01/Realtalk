<div id="sidebar">

    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php $logo = (get_option('egamer_logo') <> '') ? get_option('egamer_logo') : get_bloginfo('template_directory').'/images/logo.jpg'; ?>
		<img src="<?php echo esc_attr( $logo ); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="logo"/></a>

    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>

    <?php endif; ?>
</div>
</div>