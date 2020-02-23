<div style="position: relative; z-index: 1;" id="slider-nav"> <a href="#" class="slider-link-1"><?php echo esc_html( get_option('ebusiness_slider_1_button') ); ?></a> </div>
<div id="sections">
    <ul>
        <li>
            <div class="slider-left-2">
                <div class="slider-left">
                    <h2><?php echo esc_html( get_option('ebusiness_slider_1_title') ); ?></h2>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/slider-line-<?php echo esc_attr( get_option('ebusiness_color_scheme') ); ?>.gif" alt="line" class="slider-line" />
                    <div style="clear: both;"></div>
                    <?php echo wp_kses_post( get_option('ebusiness_slider_1_content') ); ?> </div>
                <?php if (get_option('ebusiness_slider_1_readmore') == 'false') { ?>
                <?php { echo ''; } ?>
                <?php } else { echo '<a href="' . esc_attr(get_option('ebusiness_slider_1_readmore_url')) . '"><img src="' . get_template_directory_uri() . '/images/readmore-' . esc_attr( get_option('ebusiness_color_scheme') ) . '.gif" alt="read more" class="readmore" /></a>'; } ?>
            </div>
            <div class="slider-right">

            <?php if (get_option('ebusiness_slider_1_type') == 'Video') : ?>
            <div style="background: #DCDBDB; padding: 8px;"><?php echo get_option('ebusiness_slider_1_video'); ?></div>
             <?php else : ?>
                <img src="<?php echo esc_attr( et_new_thumb_resize( et_multisite_thumbnail(esc_url( get_option('ebusiness_slider_1_image') )), 334, 192, '', true ) ); ?>" alt="slider image" class="slider_image" />
            <?php endif; ?>

            </div>
        </li>
    </ul>
</div>