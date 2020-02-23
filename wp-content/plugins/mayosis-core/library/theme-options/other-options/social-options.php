<?php
Mayosis_Option::add_panel( 'other_options_extra', array(
	'title'       => __( 'Other Options', 'mayosis' ),
	'description' => __( 'Mayosis Other Options.', 'mayosis' ),
	'priority' => '9',
) );

Mayosis_Option::add_section( 'social_options_all', array(
	'title'       => __( 'Social Options', 'mayosis' ),
	'panel'       => 'other_options_extra',

) );

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'facebook_url',
	'label'    => __( 'Facebook URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://facebook.com/',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'twitter_url',
	'label'    => __( 'Twitter URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://twitter.com/',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'instagram_url',
	'label'    => __( 'Instagram URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://instagram.com/',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'pinterest_url',
	'label'    => __( 'Pinterest URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://pinterest.com/',
));


Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'youtube_url',
	'label'    => __( 'Youtube URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://youtube.com/',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'linkedin_url',
	'label'    => __( 'Linked In URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://linkedin.com/',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'github_url',
	'label'    => __( 'Github URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://github.io/',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'slack_url',
	'label'    => __( 'Slack URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://slack.com/',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'envato_url',
	'label'    => __( 'Envato URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://envato.com/',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'behance_url',
	'label'    => __( 'Behance URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://behance.com/',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'dribbble_url',
	'label'    => __( 'Dribbble URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://dribble.com/',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'vimeo_url',
	'label'    => __( 'Vimeo URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://vimeo.com/',
));

Mayosis_Option::add_field( 'mayo_config',  array(
	'type'     => 'link',
	'settings' => 'spotify_url',
	'label'    => __( 'Spotify URL', 'mayosis' ),
	'section'  => 'social_options_all',
	'default'  => 'https://spotify.com/',
));