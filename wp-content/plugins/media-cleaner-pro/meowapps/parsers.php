<?php

class MeowAppsPro_WPMC_Parsers {

	public function __construct() {

		// ACF
		if ( class_exists( 'ACF' ) )
			require_once( 'parsers/acf.php' );

		// ACF Widgets
		if ( function_exists( 'acfw_globals' ) )  // mm change
			require_once( 'parsers/acf_widgets.php' );

		// Divi (ElegantThemes)
		if ( function_exists( '_et_core_find_latest' ) )
			require_once( 'parsers/divi.php' );

		// Visual Composer (WPBakery)
		if ( class_exists( 'Vc_Manager' ) )
			require_once( 'parsers/wpbakery_vc.php' );

		// Fusion Builder (Avada)
		if ( function_exists( 'fusion_builder_map' ) )
			require_once( 'parsers/fusion_builder.php' );

		// Beaver Builders
		if ( class_exists( 'FLBuilderModel' ) )
			require_once( 'parsers/beaver_builder.php' );

		// Elementor
		if ( function_exists( 'elementor_load_plugin_textdomain' ) )
			require_once( 'parsers/elementor.php' );

		// Oxygen Builder
		if ( class_exists( 'Oxygen_VSB_Dynamic_Shortcodes' ) )
			require_once( 'parsers/oxygen_builder.php' );

		// Brizy
		if ( class_exists( 'Brizy_Editor_Post' ) )
			require_once( 'parsers/brizy.php' );

		// ZipList Recipe
		if ( function_exists( 'amd_zlrecipe_convert_to_recipe' ) )
			require_once( 'parsers/ziplist_recipe.php' );

		// UberMenu
		if ( class_exists( 'UberMenu' ) )
		require_once( 'parsers/ubermenu.php' );

		// X Theme
		if ( class_exists( 'X_Bootstrap' ) )
			require_once( 'parsers/theme-x.php' );

		// Easy Real Estate
		if ( class_exists( 'Easy_Real_Estate' ) )
			require_once( 'parsers/easy_real_estate.php' );
	}


}
