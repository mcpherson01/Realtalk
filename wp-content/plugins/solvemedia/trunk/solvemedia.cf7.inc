<?php

/*
 * Copyright (c) 2012 by Solve Media, Inc.
 * Author: Ilia Fishbein
 * Function: Portion of the WordPress plugin related to Contact Form 7
 *
 * $Id$
 */

add_action( 'wpcf7_init', 'wpcf7_add_shortcode_solvemedia' );

function wpcf7_add_shortcode_solvemedia() {
	wpcf7_add_form_tag( 'solvemedia', 'wpcf7_solvemedia_shortcode_handler', true );
}

function wpcf7_solvemedia_shortcode_handler( $tag ) {
	$tag = new WPCF7_FormTag( $tag );

	if ( empty( $tag->name ) ) {
		return '';
	}

	global $adcopy_opt;

	if ( class_exists( 'WPCF7_FormTag' ) ) {
		$tag = new WPCF7_FormTag( $tag );
		if ( empty( $tag->name ) ) {
			return '';
		}
	} else {
		if ( 'solvemedia' != $tag['type'] ) {
			return;
		}
	}

	$theme = $adcopy_opt['re_theme_cf7'];

	$html  = solvemedia_wp_get_html( '', $theme ) . '</span>';
	$html .= '<span><span class="wpcf7-form-control-wrap solvemedia ' . $tag->name . '"></span>';

	return $html;
}

/* Validation filter */

add_filter( 'wpcf7_validate_solvemedia', 'wpcf7_solvemedia_validation_filter', 10, 2 );

function wpcf7_solvemedia_validation_filter( $result, $tag ) {
	$tag = new WPCF7_FormTag( $tag );

	global $adcopy_opt, $wpcf7_contact_form;

	$response = solvemedia_wp_check_answer();

	if ( 1 !== intval( $response->is_valid ) ) {
		$result->invalidate( $tag, wpcf7_get_message( 'captcha_not_match' ) );
	}

	return $result;
}

function adcopy_enqueue_scripts() {
	global $WP_type, $adcopy_opt, $wp_plugin_url;

	if ( ! $adcopy_opt['re_contact_form_7'] ) {
		return; }

	wp_enqueue_script( 'puzzle_reload',
		$wp_plugin_url . '/solvemedia/puzzle_reload.js',
		array( 'jquery', 'jquery-form' )
	);
}

add_action( 'init', 'adcopy_enqueue_scripts' );

/* Tag generator */

add_action( 'wpcf7_admin_init', 'wpcf7_add_tag_generator_solvemedia', 15 );

function wpcf7_add_tag_generator_solvemedia() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add(
		'solvemedia',
		__( 'solvemedia', 'contact-form-7' ),
		'wpcf7_tag_generator_solvemedia'
	);
}

function wpcf7_tag_generator_solvemedia( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() );
?>
<div class="control-box">
<fieldset>
<legend><?php echo sprintf( esc_html( $description ), $desc_link ); ?></legend>

<table class="form-table">
<tbody>
	<tr>
		<th scope="row"><label for="<?php echo esc_attr( $args['content'] . '-name' ); ?>"><?php echo esc_html( __( 'Name', 'contact-form-7' ) ); ?></label></th>
		<td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr( $args['content'] . '-name' ); ?>" /></td>
	</tr>
</tbody>
</table>
</fieldset>
</div>

<div class="insert-box">
	<input type="text" name="solvemedia" class="tag code" readonly="readonly" onfocus="this.select()" />

	<div class="submitbox">
	<input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
	</div>

	<br class="clear" />
<?php
}
