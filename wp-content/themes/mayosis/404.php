<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Mayosis
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
	
}
get_header(); ?>
	<div class="row page_breadcrumb">
	    	<div class="container">
	    <div class="col-md-12 col-xs-12">
	<h2 class="page_title_single"><?php esc_html_e("Sorry!! Something Went Wrong!!!", 'mayosis'); ?></h2>
						</div>
		</div>
		</div>
<section class="fourzerofour-area">
		<div class="container">
			<h1><?php esc_html_e("40 + 4 =", 'mayosis'); ?> <span><?php esc_html_e("404", 'mayosis'); ?></span></h1>
			<h3>
				<?php esc_html_e("The Page You Are Looking For is Missing, Misspelled or Doesn&#39;t Exist!", 'mayosis'); ?></h3>
			
		</div>
		<div class="fourzerofour-info container-fluid">
		    	<div class="container">
				<p><?php esc_html_e("We are Sorry For This Inconvenience! Don&#39;t Worry!!", 'mayosis'); ?> <br>
					<?php esc_html_e("Our", 'mayosis'); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>"> <?php esc_html_e("Homepage", 'mayosis'); ?></a> <?php esc_html_e("will Guide You Through All of Our Awesome Things, Or You Can Have A Quick Look at Our Products!!!", 'mayosis'); ?></p>
			</div>
			</div>
	</section>

<?php get_footer(); ?>