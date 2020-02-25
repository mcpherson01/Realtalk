<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Страница общих настроек для этого плагина.
 *
 * Может быть использована только, если этот плагин используется как отдельный плагин, а не как аддон
 * дя плагина Clearfy. Если плагин загружен, как аддон для Clearfy, эта страница не будет подключена.
 *
 * Поддерживает режим работы с мультисаймами. Вы можете увидеть эту страницу в панели настройки сети.
 *
 * @author        Alexander Vitkalov <nechin.va@gmail.com>
 * @author        Alex Kovalev <alex.kovalevv@gmail.com>, Github: https://github.com/alexkovalevv
 *
 * @copyright (c) 2018 Webraftic Ltd
 */
class WSFIP_SettingsPage extends WCL_Page {

	/**
	 * {@inheritDoc}
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.0.0
	 * @return string
	 */
	public $id = "wsfip_settings";

	/**
	 * {@inheritDoc}
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.0.0
	 * @return string
	 */
	public $type = "options";

	/**
	 * {@inheritDoc}
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.0.0
	 * @return string
	 */
	public $page_menu_dashicon = 'dashicons-admin-settings';

	/**
	 * {@inheritDoc}
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.0.0
	 * @return string
	 */
	public $page_parent_page = "seo";

	/**
	 * {@inheritDoc}
	 *
	 * @var bool
	 */
	public $available_for_multisite = true;

	/**
	 * {@inheritDoc}
	 *
	 * @since  1.1.0
	 * @var bool
	 */
	public $show_right_sidebar_in_options = true;

	/**
	 * @param WCL_Plugin $plugin
	 */
	public function __construct( $plugin ) {
		$this->menu_title = __( 'SEO Friendly Images', 'seo-friendly-images' );
		parent::__construct( $plugin );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @author Alexander Kovalev <alex.kovalevv@gmail.com>
	 * @since  1.1.0
	 * @return string|void
	 */
	public function getPageTitle() {
		return __( 'SEO Friendly Images', 'seo-friendly-images' );
	}

	/**
	 *{@inheritDoc}
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function assets( $scripts, $styles ) {
		parent::assets( $scripts, $styles );
	}

	/**
	 * {@inheritDoc}
	 *
	 * @since 1.0.0
	 * @return mixed[]
	 */
	public function getPageOptions() {
		$options    = [];
		$wc_options = [];

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header"><strong>' . __( 'Settings for image attributes', 'seo-friendly-images' ) . '</strong><p>' . __( 'SEO Friendly Images Premium automatically adds "alt" and "title" attributes to all images and post thumbnails in your posts. The default options are a good starting point for the optimization and basically fine for most websites.', 'seo-friendly-images' ) . '</p></div>'
		];

		$options[] = [
			'type'    => 'dropdown',
			'way'     => 'buttons',
			'name'    => 'optimize_img',
			'title'   => __( 'Optimize images', 'seo-friendly-images' ),
			'data'    => [
				[ 'all', __( 'Post thumbnails and images', 'seo-friendly-images' ) ],
				[ 'thumbs', __( 'Post thumbnails', 'seo-friendly-images' ) ],
				[ 'post', __( 'Images', 'seo-friendly-images' ) ]
			],
			'default' => 'all',
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( "Which thumbnails or images (in post content) should be optimized.", 'seo-friendly-images' )
		];

		$options[] = [
			'type'    => 'dropdown',
			'way'     => 'buttons',
			'name'    => 'sync_method',
			'title'   => __( 'Sync method', 'seo-friendly-images' ),
			'data'    => [
				[ 'both', 'alt / title' ],
				[ 'alt', 'alt' ],
				[ 'titre', 'title' ]
			],
			'default' => 'both',
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Select sync method for "alt" and "title" attribute.<br>
<b>alt/title</b> - if one attribute is set use it also for the other one<br>
<b>alt</b> - if "alt" is set use it for the title attribute<br>
<b>title</b> - if "title" is set use it for the alt attribute', 'seo-friendly-images' )
		];

		$seo_title_hint = '';
		if ( function_exists( 'wpseo_init' ) ) {
			$seo_title_hint = __( "<br><b>%yoast_keyword</b> - replaces post focus keyword", 'seo-friendly-images' );
		}

		$options[] = [
			'type'        => 'textbox',
			'name'        => 'alt_scheme',
			'placeholder' => '%name - %title',
			'title'       => __( 'Alt scheme', 'seo-friendly-images' ),
			'hint'        => __( "default: <b>%name - %title</b><br>
possible variables:<br>
<b>%title</b> - replaces post title<br>
<b>%excerpt</b> - replaces post excerpt<br>
<b>%name</b> - replaces image filename (without extension)<br>
<b>%category</b> - replaces post category<br>
<b>%tags</b> - replaces post tags<br>
<b>%media_title</b> - replaces attachment title (could be empty if not set)<br>
<b>%media_alt</b> - replaces attachment alt-text (could be empty if not set)<br>
<b>%media_caption</b> - replaces attachment caption (could be empty if not set)<br>
<b>%media_description</b> - replaces attachment description (could be empty if not set)", 'seo-friendly-images' ) . $seo_title_hint,
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'default'     => '%name - %title'
		];

		$options[] = [
			'type'        => 'textbox',
			'name'        => 'title_scheme',
			'placeholder' => '%title',
			'title'       => __( 'Title scheme', 'seo-friendly-images' ),
			'hint'        => __( "default: <b>%title</b><br>
possible variables:<br>
<b>%title</b> - replaces post title<br>
<b>%excerpt</b> - replaces post excerpt<br>
<b>%name</b> - replaces image filename (without extension)<br>
<b>%category</b> - replaces post category<br>
<b>%tags</b> - replaces post tags<br>
<b>%media_title</b> - replaces attachment title (could be empty if not set)<br>
<b>%media_alt</b> - replaces attachment alt-text (could be empty if not set)<br>
<b>%media_caption</b> - replaces attachment caption (could be empty if not set)<br>
<b>%media_description</b> - replaces attachment description (could be empty if not set)", 'seo-friendly-images' ) . $seo_title_hint,
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'default'     => '%title'
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'override_alt',
			'title'   => __( 'Override "alt"', 'seo-friendly-images' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Override existing image alt attributes on the specific alt scheme.', 'seo-friendly-images' ),
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'override_title',
			'title'   => __( 'Override "title"', 'seo-friendly-images' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Override existing image title attributes on the specific title scheme.', 'seo-friendly-images' ),
			'default' => false
		];

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header"><strong>' . __( 'WooCommerce settings', 'seo-friendly-images' ) . '</strong><p>' . __( 'This settings are specially for images inside your WooCommerce Shop. In most cases you need to activate the override to use your custom settings.', 'seo-friendly-images' ) . '</p></div>'
		];

		$options[] = [
			'type'      => 'checkbox',
			'way'       => 'buttons',
			'name'      => 'wc_title',
			'title'     => __( 'WooCommerce', 'seo-friendly-images' ),
			'layout'    => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'      => __( 'Use the product name as alt and title for WooCommerce product images', 'seo-friendly-images' ),
			'default'   => false,
			'eventsOn'  => [
				'hide' => '#wbcr-sfip-wc-opt-fields'
			],
			'eventsOff' => [
				'show' => '#wbcr-sfip-wc-opt-fields'
			]
		];

		$wc_options[] = [
			'type'    => 'dropdown',
			'way'     => 'buttons',
			'name'    => 'wc_sync_method',
			'title'   => __( 'Sync method', 'seo-friendly-images' ),
			'data'    => [
				[ 'both', 'alt / title' ],
				[ 'alt', 'alt' ],
				[ 'titre', 'title' ]
			],
			'default' => 'both',
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Select sync method for "alt" and "title" attribute.<br>
<b>alt/title</b> - if one attribute is set use it also for the other one<br>
<b>alt</b> - if "alt" is set use it for the title attribute<br>
<b>title</b> - if "title" is set use it for the alt attribute', 'seo-friendly-images' )
		];

		$wc_options[] = [
			'type'        => 'textbox',
			'name'        => 'wc_alt_scheme',
			'placeholder' => '%name - %title',
			'title'       => __( 'Alt scheme', 'seo-friendly-images' ),
			'hint'        => __( "default: <b>%name - %title</b><br>
possible variables:<br>
<b>%title</b> - replaces post title<br>
<b>%excerpt</b> - replaces post excerpt<br>
<b>%name</b> - replaces image filename (without extension)<br>
<b>%category</b> - replaces post category<br>
<b>%tags</b> - replaces post tags<br>
<b>%media_title</b> - replaces attachment title (could be empty if not set)<br>
<b>%media_alt</b> - replaces attachment alt-text (could be empty if not set)<br>
<b>%media_caption</b> - replaces attachment caption (could be empty if not set)<br>
<b>%media_description</b> - replaces attachment description (could be empty if not set)", 'seo-friendly-images' ) . $seo_title_hint,
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'default'     => '%name - %title'
		];

		$wc_options[] = [
			'type'        => 'textbox',
			'name'        => 'wc_title_scheme',
			'placeholder' => '%title',
			'title'       => __( 'Title scheme', 'seo-friendly-images' ),
			'hint'        => __( "default: <b>%title</b><br>
possible variables:<br>
<b>%title</b> - replaces post title<br>
<b>%excerpt</b> - replaces post excerpt<br>
<b>%name</b> - replaces image filename (without extension)<br>
<b>%category</b> - replaces post category<br>
<b>%tags</b> - replaces post tags<br>
<b>%media_title</b> - replaces attachment title (could be empty if not set)<br>
<b>%media_alt</b> - replaces attachment alt-text (could be empty if not set)<br>
<b>%media_caption</b> - replaces attachment caption (could be empty if not set)<br>
<b>%media_description</b> - replaces attachment description (could be empty if not set)", 'seo-friendly-images' ) . $seo_title_hint,
			'layout'      => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'default'     => '%title'
		];

		$wc_options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'wc_override_alt',
			'title'   => __( 'Override "alt"', 'seo-friendly-images' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Override existing image alt attributes on the specific alt scheme.', 'seo-friendly-images' ),
			'default' => false
		];

		$wc_options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'wc_override_title',
			'title'   => __( 'Override "title"', 'seo-friendly-images' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Override existing image title attributes on the specific title scheme.', 'seo-friendly-images' ),
			'default' => false
		];

		$options[] = [
			'type'  => 'div',
			'id'    => 'wbcr-sfip-wc-opt-fields',
			'items' => $wc_options
		];

		$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header"><strong>' . __( 'Additional features', 'seo-friendly-images' ) . '</strong></div>'
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'link_title',
			'title'   => __( 'Set title for links', 'seo-friendly-images' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Use the power of SEO Friendly Images Premium also for seo friendly links. This will set the title for post links depending on the link text and only if there is no existing title.', 'seo-friendly-images' ),
			'default' => false
		];

		$options[] = [
			'type'    => 'checkbox',
			'way'     => 'buttons',
			'name'    => 'disable_srcset',
			'title'   => __( 'Disable srcset', 'seo-friendly-images' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Disable srcset attribute and responsive images in WordPress if you don\'t need them', 'seo-friendly-images' ),
			'default' => false
		];

		/*$options[] = [
			'type' => 'html',
			'html' => '<div class="wbcr-factory-page-group-header"><strong>' . __( 'Encoding and Parser', 'seo-friendly-images' ) . '</strong><p>' . __( 'Here you can configure the HTML-Parser of the plugin. You <u>only</u> need to change this settings if you have <u>problems with your encoding</u> after activating the plugin.', 'seo-friendly-images' ) . '</p></div>'
		];

		$options[] = [
			'type'    => 'textbox',
			'name'    => 'encoding',
			'title'   => __( 'Encoding', 'seo-friendly-images' ),
			'hint'    => __( 'Leave blank to use WordPress default encoding or type in something like "utf-8"', 'seo-friendly-images' ),
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'default' => ''
		];

		$options[] = [
			'type'    => 'dropdown',
			'way'     => 'buttons',
			'name'    => 'encoding_mode',
			'title'   => __( 'Encoding mode', 'seo-friendly-images' ),
			'data'    => [
				[ 'entities', __( 'HTML-ENTITIES (default)', 'seo-friendly-images' ) ],
				[ 'off', __( 'Disable convert encoding', 'seo-friendly-images' ) ]
			],
			'default' => 'entities',
			'layout'  => [ 'hint-type' => 'icon', 'hint-icon-color' => 'grey' ],
			'hint'    => __( 'Select encoding mode', 'seo-friendly-images' )
		];*/

		$formOptions   = [];
		$formOptions[] = [
			'type'  => 'form-group',
			'items' => $options
		];

		return $formOptions;
	}
}