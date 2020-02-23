	<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 *  @package mayosis
 */
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$footerwidgetswitch = get_theme_mod( 'footer_widget_hide','on');
$footeradditonalwidget= get_theme_mod( 'footer_additonal_widget','hide');
$footercopyright = get_theme_mod( 'copyright_footer','show');
$footercopyrighttxt = get_theme_mod( 'copyright_text');
$copyrighttype = get_theme_mod( 'copyright_type','single');
$footerbacktotop = get_theme_mod( 'footer_back_to_top_hide','on');
$dm_subscribe_widget_do_shortcode_priority = has_filter( 'widget_text', 'do_shortcode' );
	     $footercopyrighttxt = apply_filters( 'widget_text', $footercopyrighttxt );
	     if ( has_filter( 'widget_text_content', 'do_shortcode' ) && ! $dm_subscribe_widget_do_shortcode_priority ) {
                if ( ! empty( $instance['filter'] ) ) {
                    $footercopyrighttxt = shortcode_unautop( $footercopyrighttxt );
                }
                $footercopyrighttxt = do_shortcode( $footercopyrighttxt );
            }
?>
	<div class="clearfix"></div>
		<?php if($footerwidgetswitch== 'on'): ?>
	<footer class="main-footer container-fluid">
			<div class="container">
				<div class="footer-row">

	<?php get_template_part( 'templates/main-footer-widget'); ?>
	
	</div>
	<?php if($footeradditonalwidget== 'show'): ?>
	<div class="additional-footer">
	    <?php get_template_part( 'templates/additional-footer-widget'); ?>
	 </div>
	 <?php endif;?>
			</div>
		</footer>
<?php endif;?>
<?php if($footercopyright== 'show'): ?>
	<div class="copyright-footer container-fluid">
			<div class="container">
			    
<?php if($copyrighttype== 'columed'): ?>
<div class="row">
    <div class="copyright-columned">
        <div class="copyright-text text-left col-md-6 col-xs-12">
             <?php if ($footercopyrighttxt) :?>
			    <?php $allowed_html = [
                            'a'      => [
                                'href'  => [],
                                'title' => [],
                            ],
                            'br'     => [],
                            'em'     => [],
                            'strong' => [],
                        ]; ?>
			<?php echo  wp_kses($footercopyrighttxt,$allowed_html); ?>
				<?php else:?>
				<p class="copyright-text">© Copyright 2019 I <a href="https://teconce.com/item/mayosis-digital-marketplace-wordpress-theme/" target="_blank">Mayosis</a> Theme</p>
				<?php endif; ?>
        </div>
        
        <div class="copyright-col-right col-md-6 col-xs-12">
            <?php if ( is_active_sidebar( 'copyright-footer' ) ) : ?>
					<?php dynamic_sidebar( 'copyright-footer' ); ?>
				<?php endif; ?>
        </div>
    </div>
</div>
<?php else : ?>
	<div class="text-center copyright-full-width-text">
			    <?php if ($footercopyrighttxt) :?>
			    <?php $allowed_html = [
                            'a'      => [
                                'href'  => [],
                                'title' => [],
                            ],
                            'br'     => [],
                            'em'     => [],
                            'strong' => [],
                        ]; ?>
			<?php echo  wp_kses($footercopyrighttxt,$allowed_html); ?>
				<?php else:?>
				<p class="copyright-text text-center">© Copyright 2019 I Mayosis Theme by <a href="https://teconce.com/">TecOnce</a> I All Rights Reserved I Powered by <a href="https://wordpress.org/">WordPress</a></p>
				<?php endif; ?>
		</div>
	<?php endif; ?>
	
		</div>
		</div>
		<?php endif; ?>
	<!-- End Footer Section-->
</div>
</div>
	<?php if($footerbacktotop== 'on'){ ?>
	<a id="back-to-top" href="#" class="back-to-top" role="button"><i class="zil zi-chevron-up"></i></a>
	<?php } ?>
<?php wp_footer(); ?>
</body>
<!-- End Main Layout --> 

</html>