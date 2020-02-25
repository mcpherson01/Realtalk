<?php

/**
 * This class configures the parameters advanced
 *
 * @author        Alexander Vitkalov <nechin.va@gmail.com>
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>, GitHub: https://github.com/alexkovalevv
 * @copyright (c) 01.10.2018, Webcraftic
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WSFIP_Configurate {

	/**
	 * @param WCL_Plugin $plugin
	 *
	 * @throws \Exception
	 */
	public function __construct( $plugin ) {
		if ( ! $plugin instanceof WCL_Plugin ) {
			throw new \Exception( 'Invalid $plugin argument type passed.' );
		}
		$this->plugin = $plugin;
		$this->registerActionsAndFilters();
	}

	/**
	 * Register actions and filters
	 */
	public function registerActionsAndFilters() {
		if ( ! is_admin() ) {
			add_action( 'init', [ $this, 'init' ] );
		}
	}

	/**
	 * WP init action
	 */
	public function init() {
		// Post thumbnails
		if ( $this->plugin->getPopulateOption( 'optimize_img', 'all' ) == 'all' || $this->plugin->getPopulateOption( 'optimize_img', 'all' ) == 'thumbs' ) {
			add_filter( 'wp_get_attachment_image_attributes', [
				$this,
				'addImageAttributesForThumbnail'
			], 10, 2 );
		}

		// Post images
		if ( $this->plugin->getPopulateOption( 'optimize_img', 'all' ) || $this->plugin->getPopulateOption( 'optimize_img', 'all' ) == 'post' ) {
			add_filter( 'the_content', [ $this, 'optimizeContentImage' ], 999, 1 );

			// Add support for AdvancedCustomFields
			add_filter( 'acf/load_value/type=textarea', [ $this, 'optimizeContentImage' ], 20 );
			add_filter( 'acf/load_value/type=wysiwyg', [ $this, 'optimizeContentImage' ], 20 );

			add_filter( 'acf_load_value-textarea', [ $this, 'optimizeContentImage' ], 20 );
			add_filter( 'acf_load_value-wysiwyg', [ $this, 'optimizeContentImage' ], 20 );
		}

		if ( ! is_feed() ) {
			// Link title
			if ( $this->plugin->getPopulateOption( 'link_title', false ) ) {
				add_filter( 'the_content', [ $this, 'optimizeLinkTitle' ], 999 );

				// Add support for AdvancedCustomFields
				add_filter( 'acf/load_value/type=textarea', [ $this, 'optimizeLinkTitle' ], 20 );
				add_filter( 'acf/load_value/type=wysiwyg', [ $this, 'optimizeLinkTitle' ], 20 );

				add_filter( 'acf_load_value-textarea', [ $this, 'optimizeLinkTitle' ], 20 );
				add_filter( 'acf_load_value-wysiwyg', [ $this, 'optimizeLinkTitle' ], 20 );
			}

			if ( $this->plugin->getPopulateOption( 'disable_srcset', false ) ) {
				$this->disableResponsiveImages();
			}

			// Woocommerce
			if ( $this->plugin->getPopulateOption( 'wc_title', false ) ) {
				add_filter( 'wp_get_attachment_image_attributes', [
					$this,
					'optimizeAttachmentImageAttributes'
				], 20, 2 );
			}

			if ( ! $this->plugin->getPopulateOption( 'wc_title', false ) ) {
				add_filter( 'wp_get_attachment_image_attributes', [
					$this,
					'optimizeDynamicAttachmentImageAttributes'
				], 20, 2 );
			}
		}
	}

	/**
	 * Add image attributes title and alt to post thumbnails
	 *
	 * @param      $attr
	 * @param null $attachment
	 *
	 * @return mixed
	 */
	public function addImageAttributesForThumbnail( $attr, $attachment = null ) {
		if ( empty( $attr['alt'] ) ) {
			$attr['title'] = trim( $this->replaceParameters( $this->plugin->getPopulateOption( 'title_scheme', '%title' ), $attr['src'] ) );

			$attr['alt'] = trim( $this->replaceParameters( $this->plugin->getPopulateOption( 'alt_scheme', '%name - %title' ), $attr['src'] ) );
		} else {
			if ( $this->plugin->getPopulateOption( 'sync_method', 'both' ) == 'both' || $this->plugin->getPopulateOption( 'sync_method', 'both' ) == 'alt' ) {
				$attr['title'] = trim( strip_tags( $attachment->post_title ) );
			} else {
				$attr['title'] = trim( $this->replaceParameters( $this->plugin->getPopulateOption( 'title_scheme', '%title' ), $attr['src'] ) );
			}
		}

		$attr['alt']   = apply_filters( 'wbcr/sfip/alt', $attr['alt'] );
		$attr['title'] = apply_filters( 'wbcr/sfip/title', $attr['title'] );

		return $attr;
	}

	/**
	 * Handle post images
	 *
	 * @param $content
	 *
	 * @return mixed|string
	 */
	public function optimizeContentImage( $content ) {
		if ( empty( $content ) || ! class_exists( 'DOMDocument' ) ) {
			return $content;
		}

		if ( get_post_type() == 'tribe_events' // exclude for Events Calendar
		     || is_feed() // exclude for feeds
		     || strstr( strtolower( $content ), 'arforms' ) // exclude for ARForms
		     || strstr( strtolower( $content ), 'arf_form' ) // exclude for ARForms
		     || strstr( strtolower( $content ), 'spb_gallery' ) // exclude for spb_gallery_widget
		     || isset( $_GET['dslc'] ) // exclude for LiveComposer
		) {
			return $content;
		}

		$charset = $this->plugin->getPopulateOption( 'encoding', false );
		if ( empty( $charset ) ) {
			$charset = ( ( defined( 'DB_CHARSET' ) ) ? DB_CHARSET : 'utf-8' );
		}

		$charset              = apply_filters( 'wbcr/sfip/charset', $charset );
		$encoding_declaration = sprintf( '<?xml encoding="%s" ?>', $charset );

		$document = new DOMDocument();
		//if ( function_exists( 'mb_convert_encoding' ) && $this->plugin->getPopulateOption( 'encoding_mode', 'entities' ) != 'off' ) {
		//$content = @mb_convert_encoding( $content, 'HTML-ENTITIES', $charset );
		//} else {
		$content = $encoding_declaration . $content;
		//}
		@$document->loadHTML( $content );

		if ( ! $document ) {
			return $content;
		}

		/*
		 * Recommendation by BasTaller
		 * @url https://wordpress.org/support/topic/proposal-for-best-replacement/
		 */
		$fig_tags = $document->getElementsByTagName( 'figure' );

		if ( ! $fig_tags->length ) {
			foreach ( $fig_tags as $tag ) {
				$caption  = $tag->nodeValue;
				$img_tags = $tag->getElementsByTagName( 'img' );

				if ( empty( $caption ) ) {
					continue;
				}

				foreach ( $img_tags as $img_tag ) {
					$img_tag->setAttribute( 'title', $caption );
				}
			}
		}

		$img_tags = $document->getElementsByTagName( 'img' );
		if ( ! $img_tags->length ) {
			return $content;
		}

		foreach ( $img_tags as $tag ) {
			$data_src = trim( $tag->getAttribute( 'data-src' ) );
			$src      = trim( $tag->getAttribute( 'src' ) );

			if ( ! empty( $data_src ) ) {
				$src = $data_src;
			}

			$image_id = $this->getImageIDByURL( $src );

			// Override Area
			if ( $this->plugin->getPopulateOption( 'override_alt', false ) ) {
				$alt = trim( $this->replaceParameters( $this->plugin->getPopulateOption( 'alt_scheme', '%name - %title' ), $src, $image_id ) );
				$alt = apply_filters( 'wbcr/sfip/alt', $alt );
				$tag->setAttribute( 'alt', $alt );
			} else {
				$alt = trim( $tag->getAttribute( 'alt' ) );
				$alt = apply_filters( 'wbcr/sfip/alt', $alt );
			}

			if ( $this->plugin->getPopulateOption( 'override_title', false ) ) {
				$title = trim( $this->replaceParameters( $this->plugin->getPopulateOption( 'title_scheme', '%title' ), $src, $image_id ) );
				$title = apply_filters( 'wbcr/sfip/title', $title );
				$tag->setAttribute( 'title', $title );
			} else {
				$title = trim( $tag->getAttribute( 'title' ) );
				$title = apply_filters( 'wbcr/sfip/title', $title );
			}

			// Check attributes
			if ( ! empty( $alt ) && empty( $title ) && ( $this->plugin->getPopulateOption( 'sync_method', 'both' ) == 'both' || $this->plugin->getPopulateOption( 'sync_method', 'both' ) == 'alt' ) ) {
				$alt = apply_filters( 'wbcr/sfip/title', $alt );
				$tag->setAttribute( 'title', $alt );
				$title = $alt;
			} else if ( empty( $alt ) && ! empty( $title ) && ( $this->plugin->getPopulateOption( 'sync_method', 'both' ) == 'both' || $this->plugin->getPopulateOption( 'sync_method', 'both' ) == 'title' ) ) {
				$title = apply_filters( 'wbcr/sfip/alt', $title );
				$tag->setAttribute( 'alt', $title );
				$alt = $title;
			}

			// Set if empty after sync
			if ( empty( $alt ) ) {
				$alt = trim( $this->replaceParameters( $this->plugin->getPopulateOption( 'alt_scheme', '%name - %title' ), $src, $image_id ) );
				$alt = apply_filters( 'wbcr/sfip/alt', $alt );
				$tag->setAttribute( 'alt', $alt );
			}

			if ( empty( $title ) ) {
				$title = trim( $this->replaceParameters( $this->plugin->getPopulateOption( 'title_scheme', '%title' ), $src, $image_id ) );
				$title = apply_filters( 'wbcr/sfip/title', $title );
				$tag->setAttribute( 'title', $title );
			}
		}

		$return = $document->saveHTML();
		$return = str_replace( $encoding_declaration, '', $return );

		return preg_replace( '/^<!DOCTYPE.+?>/', '', str_replace( [ '<html>', '</html>', '<body>', '</body>' ], [
			'',
			'',
			'',
			''
		], $return ) );
	}

	/**
	 * Optimize link title
	 *
	 * @param $content
	 *
	 * @return mixed|string
	 */
	public function optimizeLinkTitle( $content ) {
		if ( empty( $content ) || ! class_exists( 'DOMDocument' ) ) {
			return $content;
		}

		$charset = $this->plugin->getPopulateOption( 'encoding', false );
		if ( empty( $charset ) ) {
			$charset = ( defined( 'DB_CHARSET' ) ? DB_CHARSET : 'utf-8' );
		}

		$charset              = apply_filters( 'wbcr/sfip/charset', $charset );
		$encoding_declaration = sprintf( '<?xml encoding="%s" ?>', $charset );

		$document = new DOMDocument();
		//if ( function_exists( 'mb_convert_encoding' ) && $this->plugin->getPopulateOption( 'encoding_mode', 'entities' ) != 'off' ) {
		//$content = @mb_convert_encoding( $content, 'HTML-ENTITIES', $charset );
		//} else {
		$content = $encoding_declaration . $content;
		//}

		@$document->loadHTML( $content );
		if ( ! $document ) {
			return $content;
		}

		$tags = $document->getElementsByTagName( 'a' );
		if ( ! $tags->length || $tags->length == 0 ) {
			return $content;
		}

		foreach ( $tags as $tag ) {
			$title = trim( $tag->getAttribute( 'title' ) );

			if ( empty( $title ) ) {
				$new_title = '';

				if ( ! empty( $tag->textContent ) ) {
					$new_title = $tag->textContent;
				} else if ( $tag->hasChildNodes() ) {
					$child_nodes = $tag->childNodes;

					if ( ! $child_nodes->length || $child_nodes->length == 0 ) {
						continue;
					}

					foreach ( $child_nodes as $sub_child_nodes ) {
						if ( ! empty( $sub_child_nodes->textContent ) ) {
							$new_title = $sub_child_nodes->textContent;
							break;
						} else if ( $sub_child_nodes->tagName == 'img' ) {
							$title = trim( $sub_child_nodes->getAttribute( 'title' ) );

							if ( ! empty( $title ) ) {
								$new_title = $title;
								break;
							}
						}
					}
				}

				$tag->setAttribute( 'title', $new_title );
			}
		}

		$return = $document->saveHTML();
		$return = str_replace( $encoding_declaration, '', $return );

		return preg_replace( '/^<!DOCTYPE.+?>/', '', str_replace( [ '<html>', '</html>', '<body>', '</body>' ], [
			'',
			'',
			'',
			''
		], $return ) );
	}

	/**
	 * Disable responsive images
	 */
	public function disableResponsiveImages() {
		add_filter( 'wp_calculate_image_sizes', '__return_null' );
		add_filter( 'wp_calculate_image_srcset', '__return_null' );
		add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );

		remove_filter( 'the_content', 'wp_make_content_images_responsive' );
	}

	/**
	 * Handle WooCommerce products
	 *
	 * @param $attr
	 * @param $attachment
	 *
	 * @return mixed
	 */
	public function optimizeAttachmentImageAttributes( $attr, $attachment ) {
		$post = get_post();
		if ( get_post_type( $post ) !== 'product' || empty( $attachment ) ) {
			return $attr;
		}

		// Get title
		$title = $post->post_title;
		if ( trim( $title ) != '' ) {
			$attr['alt']   = apply_filters( 'wbcr/sfip/wc-alt', $title );
			$attr['title'] = apply_filters( 'wbcr/sfip/wc-title', $title );
		}

		return $attr;
	}

	/**
	 * Handle WooCommerce products
	 *
	 * @param $attr
	 * @param $attachment
	 *
	 * @return array
	 */
	public function optimizeDynamicAttachmentImageAttributes( $attr, $attachment ) {
		$post = get_post();
		if ( get_post_type( $post ) !== 'product' ) {
			return $attr;
		}

		$alt      = $attr['alt'];
		$title    = $attr['title'];
		$src      = $attr['src'];
		$image_id = $attachment->ID;

		// Override area
		if ( $this->plugin->getPopulateOption( 'wc_override_alt', false ) ) {
			$alt = trim( $this->replaceParameters( $this->plugin->getPopulateOption( 'wc_alt_scheme', '%name - %title' ), $src, $image_id ) );
			$alt = apply_filters( 'wbcr/sfip/wc-alt', $alt );
		} else {
			$alt = apply_filters( 'wbcr/sfip/wc-alt', $alt );
		}

		if ( $this->plugin->getPopulateOption( 'wc_override_title', false ) ) {
			$title = trim( $this->replaceParameters( $this->plugin->getPopulateOption( 'wc_title_scheme', '%title' ), $src, $image_id ) );
			$title = apply_filters( 'wbcr/sfip/wc-title', $title );
		} else {
			$title = apply_filters( 'wbcr/sfip/wc-title', $title );
		}

		// Check attributes
		if ( ! empty( $alt ) && empty( $title ) && ( $this->plugin->getPopulateOption( 'wc_sync_method', 'both' ) == 'both' || $this->plugin->getPopulateOption( 'wc_sync_method', 'both' ) == 'alt' ) ) {
			$alt   = apply_filters( 'wbcr/sfip/wc-title', $alt );
			$title = $alt;
		} else if ( empty( $alt ) && ! empty( $title ) && ( $this->plugin->getPopulateOption( 'wc_sync_method', 'both' ) == 'both' || $this->plugin->getPopulateOption( 'wc_sync_method', 'both' ) == 'title' ) ) {
			$title = apply_filters( 'wbcr/sfip/wc-alt', $title );
			$alt   = $title;
		}

		// Set if empty after sync
		if ( empty( $alt ) ) {
			$alt = trim( $this->replaceParameters( $this->plugin->getPopulateOption( 'wc_alt_scheme', '%name - %title' ), $src, $image_id ) );
			$alt = apply_filters( 'wbcr/sfip/wc-alt', $alt );
		}

		if ( empty( $title ) ) {
			$title = trim( $this->replaceParameters( $this->plugin->getPopulateOption( 'wc_title_scheme', '%title' ), $src, $image_id ) );
			$title = apply_filters( 'wbcr/sfip/wc-title', $title );
		}

		$new_attr = [
			'alt'   => $alt,
			'title' => $title,
		];

		return array_merge( $attr, $new_attr );
	}

	/**
	 * Replacements by scheme
	 *
	 * @param      $content
	 * @param bool $src
	 * @param bool $image_id
	 *
	 * @return mixed
	 */
	public function replaceParameters( $content, $src = false, $image_id = false ) {
		$post = get_post();

		$cats = '';
		if ( strrpos( $content, '%category' ) !== false ) {

			if ( get_post_type( $post ) == 'product' ) {
				$categories = get_the_terms( $post->ID, 'product_cat' );
				if ( ! $categories || is_wp_error( $categories ) ) {
					$categories = [];
				}

				$categories = array_values( $categories );

				foreach ( array_keys( $categories ) as $key ) {
					_make_cat_compat( $categories[ $key ] );
				}
			} else {
				$categories = get_the_category();
			}

			if ( $categories ) {
				$i = 0;
				foreach ( $categories as $cat ) {
					if ( $i == 0 ) {
						$cats = $cat->slug . $cats;
					} else {
						$cats = $cat->slug . ', ' . $cats;
					}
					++ $i;
				}
			}
		}

		$tags = '';
		if ( strrpos( $content, '%tags' ) !== false ) {
			$posttags = get_the_tags();

			if ( $posttags ) {
				$i = 0;
				foreach ( $posttags as $tag ) {
					if ( $i == 0 ) {
						$tags = $tag->name . $tags;
					} else {
						$tags = $tag->name . ', ' . $tags;
					}
					++ $i;
				}
			}
		}

		if ( $src ) {
			$info = @pathinfo( $src );
			$src  = @basename( $src, '.' . $info['extension'] );

			$src = str_replace( '-', ' ', $src );
			$src = str_replace( '_', ' ', $src );
		} else {
			$src = '';
		}

		if ( is_numeric( $image_id ) ) {
			$attachment = wp_prepare_attachment_for_js( $image_id );

			if ( is_array( $attachment ) ) {
				$content = str_replace( '%media_title', $attachment['title'], $content );
				$content = str_replace( '%media_alt', $attachment['alt'], $content );
				$content = str_replace( '%media_caption', $attachment['caption'], $content );
				$content = str_replace( '%media_description', $attachment['description'], $content );
			}
		}

		$content = str_replace( '%media_title', $post->post_title, $content );
		$content = str_replace( '%media_alt', $post->post_title, $content );
		$content = str_replace( '%media_caption', $post->post_title, $content );
		$content = str_replace( '%media_description', $post->post_title, $content );

		$content = str_replace( '%name', $src, $content );
		$content = str_replace( '%title', $post->post_title, $content );
		$content = str_replace( '%category', $cats, $content );
		$content = str_replace( '%tags', $tags, $content );
		$content = str_replace( '%excerpt', $post->post_excerpt, $content );

		if ( function_exists( 'wpseo_init' ) ) {
			$content = str_replace( '%yoast_keyword', get_post_meta( $post->ID, '_yoast_wpseo_focuskw', true ), $content );
		}

		return $content;
	}

	/**
	 * Get Image ID by URL
	 *
	 * @param string $url
	 *
	 * @return int|bool
	 */
	public static function getImageIDByURL( $url ) {
		global $wpdb;

		$sql = $wpdb->prepare( 'SELECT `ID` FROM `' . $wpdb->posts . '` WHERE `guid` = \'%s\';', esc_sql( $url ) );

		$attachment = $wpdb->get_col( $sql );
		$array_key  = array_key_exists( 0, $attachment ) ? $attachment[0] : false;
		if ( is_numeric( $array_key ) ) {
			return (int) $attachment[0];
		}

		return false;
	}

}