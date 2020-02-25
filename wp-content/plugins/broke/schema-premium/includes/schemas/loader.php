<?php
/**
 * Schema Types Loader
 *
 * @since 1.0.0
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Auto load schema types 
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/types/*.php' ) as $filename ) {
	require_once $filename;
}

// Auto load schema sub-types
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/Article/*.php' ) as $filename ) {
	require_once $filename;
}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/Article/SocialMediaPosting/*.php' ) as $filename ) {
		require_once $filename;
	}
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/Event/*.php' ) as $filename ) {
	require_once $filename;
}
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/*.php' ) as $filename ) {
	require_once $filename;
}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/Store/*.php' ) as $filename ) {
		require_once $filename;
	}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/LocalBusiness/LegalService/*.php' ) as $filename ) {
		require_once $filename;
	}
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/Place/*.php' ) as $filename ) {
    require_once $filename;
}
    foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/Place/Accommodation/*.php' ) as $filename ) {
        require_once $filename;
    }
foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/SoftwareApplication/*.php' ) as $filename ) {
	require_once $filename;
}
	foreach ( glob ( SCHEMAPREMIUM_PLUGIN_DIR . 'includes/schemas/sub-types/WebPage/*.php' ) as $filename ) {
	require_once $filename;
}
