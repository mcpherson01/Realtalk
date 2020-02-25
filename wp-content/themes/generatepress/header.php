<?php
/**
 * The template for displaying the header.
 *
 * @package GeneratePress
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<meta name="title" content="Realtalk Digital; The Home of RealtalkGames Youtube Explainer">
	<meta name="description" content="Realtalk Digital; The Home of RealtalkGames Youtube Explainer.https://realtalk.digital,  facebook.com/realtalkgames, twitter.com/7GiveMeTheWorld">
	<meta name="keywords" content="Half-life Alyx, Half-life Alyx Gordon Freeman, Half-life Alyx Gordon Freeman Gabe Newell, Half-life Alyx Gordon Freeman Gabe Newell Valve, Half-life Alyx Gordon Freeman Valve Gabe Newell, Half-life Alyx Gabe NewellHalf-life Alyx Gabe Newell Gordon Freeman, Half-life Alyx Gabe Newell Gordon Freeman Valve, Half-life Alyx Gabe Newell ValveHalf-life Alyx Gabe Newell Valve Gordon Freeman, Half-life Alyx ValveHalf-life Alyx Valve Gordon Freeman, Half-life Alyx Valve Gordon Freeman Gabe Newell,Half-life Alyx Valve, Half-life Alyx Valve Gabe Newell,Half-life Alyx Valve Gabe Newell Gordon FreemanHalf-life Gordon Freeman,Half-life Gordon Freeman Alyx,Half-life Gordon Freeman Alyx Gabe Newell,Half-life Gordon Freeman Alyx Gabe Newell Valve,Half-life Gordon Freeman,Half-life Gordon Freeman Alyx,realtalk, gaming, explanations,youtube,bioshock,fallout,steam,video,playthrough,realitymasher,james,mcpherson,simple,what,happened,games,videogaming,streaming,funnf,vids,narrator,vimeo,google,wiki,haly-life,steam,valve,official,trailer,content,footage,gameplay,explained,outlast,new,cool,funny,best">
	<meta name="robots" content="index, follow">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="English">
	<meta name="revisit-after" content="1 days">	
	<meta name="author" content="James McPherson">
	
	<script type="application/javascript">var googletag=googletag||{};googletag.cmd=googletag.cmd||[];googletag.cmd.push(function(){googletag.pubads().disableInitialLoad()});</script><script type="application/javascript" src="//ap.lijit.com/www/headerauction/headersuite.min.js?configId=5567"></script>
	<script src="//ap.lijit.com/www/delivery/fpi.js?z=688073&width=160&height=600"></script> 
	<script src="//ap.lijit.com/www/delivery/fpi.js?z=688839&width=320&height=50"></script> 

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php generate_do_microdata( 'body' ); ?>>
	<?php
	/**
	 * wp_body_open hook.
	 *
	 * @since 2.3
	 */
	do_action( 'wp_body_open' );

	/**
	 * generate_before_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked generate_do_skip_to_content_link - 2
	 * @hooked generate_top_bar - 5
	 * @hooked generate_add_navigation_before_header - 5
	 */
	do_action( 'generate_before_header' );

	/**
	 * generate_header hook.
	 *
	 * @since 1.3.42
	 *
	 * @hooked generate_construct_header - 10
	 */
	do_action( 'generate_header' );

	/**
	 * generate_after_header hook.
	 *
	 * @since 0.1
	 *
	 * @hooked generate_featured_page_header - 10
	 */
	do_action( 'generate_after_header' );
	?>

	<div id="page" class="hfeed site grid-container container grid-parent">
		<?php
		/**
		 * generate_inside_site_container hook.
		 *
		 * @since 2.4
		 */
		do_action( 'generate_inside_site_container' );
		?>
		<div id="content" class="site-content">
			<?php
			/**
			 * generate_inside_container hook.
			 *
			 * @since 0.1
			 */
			do_action( 'generate_inside_container' );
