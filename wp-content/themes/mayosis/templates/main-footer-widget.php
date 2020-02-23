<?php
/**
 * The template for displaying the footer Widget.
 *
 * Contains the closing of the id=main div and all content after
 *
 *  @package mayosis
 */
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
$footerwidgetcolumn= get_theme_mod( 'footer_widget_column','four');
?>
<!-- Begin Footer Section-->
	<?php if($footerwidgetcolumn == 'one'): ?>
    <div class="footer-widget mx-one" >
        
				<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
					<?php dynamic_sidebar( 'footer-one' ); ?>
				<?php endif; ?>
    </div>
    <?php endif;?>

	<?php if($footerwidgetcolumn == 'two'): ?>
	<div class="footer-widget mx-one">
        	<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
					<?php dynamic_sidebar( 'footer-one' ); ?>
				<?php endif; ?>
    </div>
    <div class="footer-widget mx-two" >
        	<?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
					<?php dynamic_sidebar( 'footer-two' ); ?>
				<?php endif; ?>
    </div>
	<?php endif;?>
	
	
	<?php if($footerwidgetcolumn == 'three'): ?>
	<div class="footer-widget mx-one" >
        	<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
					<?php dynamic_sidebar( 'footer-one' ); ?>
				<?php endif; ?>
    </div>
    <div class="footer-widget mx-two" >
        <?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
					<?php dynamic_sidebar( 'footer-two' ); ?>
				<?php endif; ?>
    </div>
	<div class="footer-widget mx-three" >
        <?php if ( is_active_sidebar( 'footer-three' ) ) : ?>
					<?php dynamic_sidebar( 'footer-three' ); ?>
				<?php endif; ?>
    </div>
    
	<?php endif;?>
	
	
	<?php if($footerwidgetcolumn == 'four'): ?>
	<div class="footer-widget mx-one" >
        	<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
					<?php dynamic_sidebar( 'footer-one' ); ?>
				<?php endif; ?>
    </div>
    <div class="footer-widget mx-two" >
        <?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
					<?php dynamic_sidebar( 'footer-two' ); ?>
				<?php endif; ?>
    </div>
	<div class="footer-widget mx-three" >
        <?php if ( is_active_sidebar( 'footer-three' ) ) : ?>
					<?php dynamic_sidebar( 'footer-three' ); ?>
				<?php endif; ?>
    </div>
    
    <div class="footer-widget mx-four" >
         <?php if ( is_active_sidebar( 'footer-four' ) ) : ?>
					<?php dynamic_sidebar( 'footer-four' ); ?>
				<?php endif; ?>
    </div>
    
	<?php endif;?>
	
	
	<?php if($footerwidgetcolumn == 'five'): ?>
	<div class="footer-widget mx-one" >
        	<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
					<?php dynamic_sidebar( 'footer-one' ); ?>
				<?php endif; ?>
    </div>
    <div class="footer-widget mx-two" >
        <?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
					<?php dynamic_sidebar( 'footer-two' ); ?>
				<?php endif; ?>
    </div>
	<div class="footer-widget mx-three" >
        <?php if ( is_active_sidebar( 'footer-three' ) ) : ?>
					<?php dynamic_sidebar( 'footer-three' ); ?>
				<?php endif; ?>
    </div>
    
    <div class="footer-widget mx-four" >
         <?php if ( is_active_sidebar( 'footer-four' ) ) : ?>
					<?php dynamic_sidebar( 'footer-four' ); ?>
				<?php endif; ?>
    </div>
    
    <div class="footer-widget mx-five" >
         <?php if ( is_active_sidebar( 'footer-five' ) ) : ?>
					<?php dynamic_sidebar( 'footer-five' ); ?>
				<?php endif; ?>
    </div>
    
    
	<?php endif;?>
	
	
		
	<?php if($footerwidgetcolumn == 'six'): ?>
	<div class="footer-widget mx-one" >
        	<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
					<?php dynamic_sidebar( 'footer-one' ); ?>
				<?php endif; ?>
    </div>
    <div class="footer-widget mx-two" >
        <?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
					<?php dynamic_sidebar( 'footer-two' ); ?>
				<?php endif; ?>
    </div>
	<div class="footer-widget mx-three" >
        <?php if ( is_active_sidebar( 'footer-three' ) ) : ?>
					<?php dynamic_sidebar( 'footer-three' ); ?>
				<?php endif; ?>
    </div>
    
    <div class="footer-widget mx-four" >
        <?php if ( is_active_sidebar( 'footer-four' ) ) : ?>
					<?php dynamic_sidebar( 'footer-four' ); ?>
				<?php endif; ?>
    </div>
    
    <div class="footer-widget mx-five" >
         <?php if ( is_active_sidebar( 'footer-five' ) ) : ?>
					<?php dynamic_sidebar( 'footer-five' ); ?>
				<?php endif; ?>
    </div>
    
    <div class="footer-widget mx-six" >
         <?php if ( is_active_sidebar( 'footer-six' ) ) : ?>
					<?php dynamic_sidebar( 'footer-six' ); ?>
				<?php endif; ?>
    </div>
    
	<?php endif;?>
	
	
	