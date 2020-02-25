<?php
/**
 * bbPress plugin integration
 *
 *
 * plugin url: https://wordpress.org/plugins/bbpress/
 * @since 1.1.2
 */
 
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

add_filter( 'schema_output_DiscussionForumPosting', 'schema_premium_bbp_extend_schema_output' );
/**
 * Extend Discussion Forum Posting markup for BBPress
 *
 * @since 1.1.2
 * @return array
 */
function schema_premium_bbp_extend_schema_output( $schema ) {
	
	if ( $schema['@type'] !== 'DiscussionForumPosting' )
		return $schema;
		
	if ( class_exists( 'bbPress' ) ) {
	    // bbPress is enabled 
		
		$reply_count = bbp_get_topic_reply_count();
		
		if ( $reply_count > 0 ) {
			$schema['interactionStatistic'] = array (
				  '@type'					=> 'InteractionCounter',
				  'interactionType'			=> 'https://schema.org/ReplyAction', //http://schema.org/CommentAction
				  'userInteractionCount'	=> $reply_count
			);
		}
	}
	
	return $schema;
}
