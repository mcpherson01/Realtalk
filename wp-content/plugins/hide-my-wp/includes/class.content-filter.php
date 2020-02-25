<?php

/**
 * Filters content to match new rules set by the user.
 *
 * @author        Alex Kovalev <alex@byonepress.com><wordpress.webraftic@gmail.com>
 * @since         1.0.0
 * @package       core
 * @copyright (c) 2018, Webcraftic Ltd
 *
 */
class WHM_ContentFilter {

	/**
	 * @var array
	 */
	private $filters;

	/**
	 * @var array
	 */
	private $patterns;


	/**
	 * @var array
	 */
	public $filters_for_hooks;

	/**
	 * @var array
	 */
	public $filters_for_content;

	/**
	 * @var array
	 */
	public $patterns_for_hooks;

	/**
	 * @var array
	 */
	public $patterns_for_content;
	/**
	 * @var array
	 */
	public $content_recovery_patterns;
	/**
	 * @var array
	 */
	public $content_recovery_filters;

	public function __construct() {
		$this->reload();
		$this->bindHooks();
	}

	public function reload() {
		$this->filters                   = WCL_Plugin::app()->getPopulateOption( 'replace_content_filters' );
		$this->patterns                  = WCL_Plugin::app()->getPopulateOption( 'replace_content_patterns' );
		$this->content_recovery_patterns = WCL_Plugin::app()->getPopulateOption( 'recovery_content_patterns' );
		$this->content_recovery_filters  = WCL_Plugin::app()->getPopulateOption( 'recovery_content_filters' );

		if ( is_admin() ) {
			if ( ! empty( $this->filters ) ) {
				$this->filters_for_hooks   = $this->filters['admin']['hooks'];
				$this->filters_for_content = $this->filters['admin']['content'];
			}
			if ( ! empty( $this->patterns ) ) {
				$this->patterns_for_hooks   = $this->patterns['admin']['hooks'];
				$this->patterns_for_content = $this->patterns['admin']['content'];
			}
		} else {
			if ( ! empty( $this->filters ) ) {
				$this->filters_for_hooks   = $this->filters['public']['hooks'];
				$this->filters_for_content = $this->filters['public']['content'];
			}
			if ( ! empty( $this->patterns ) ) {
				$this->patterns_for_hooks   = $this->patterns['public']['hooks'];
				$this->patterns_for_content = $this->patterns['public']['content'];
			}
		}
	}

	/**
	 * Searches for `$search` in `$content` (using either `preg_match()`
	 * or `strpos()`, depending on whether `$search` is a valid regex pattern or not).
	 * If something is found, it replaces `$content` using `$re_replace_pattern`,
	 * effectively creating our named markers (`%%{$marker}%%`.
	 * These are then at some point replaced back to their actual/original/modified
	 * contents using `restoreMarkedContent()`.
	 *
	 * @param string $marker               Marker name (without percent characters).
	 * @param string $search               A string or full blown regex pattern to search for in $content. Uses `strpos()` or `preg_match()`.
	 * @param string $re_replace_pattern   Regex pattern to use when replacing contents.
	 * @param string $content              Content to work on.
	 *
	 * @return string
	 */
	public function replaceContentsWithMarkerIfExists( $marker, $search, $re_replace_pattern, $content ) {
		$is_regex = WHM_Helpers::strIsValidRegex( $search );
		if ( $is_regex ) {
			$found = preg_match( $search, $content );
		} else {
			$found = ( false !== strpos( $content, $search ) );
		}

		if ( $found ) {
			$content = preg_replace_callback( $re_replace_pattern, function ( $matches ) use ( $marker ) {
				$text = '%%' . $marker . wp_hash( WHM_WP_PLUGIN_URL ) . '%%' . base64_encode( $matches[0] );
				$text .= '%%' . $marker . '%%';

				return $text;
			}, $content );
		}

		return $content;
	}

	/**
	 * Complements `replaceContentsWithMarkerIfExists()`.
	 *
	 * @param string $marker    Marker.
	 * @param string $content   Markup.
	 *
	 * @return string
	 */
	public function restoreMarkedContent( $marker, $content ) {
		if ( false !== strpos( $content, $marker ) ) {
			$content = preg_replace_callback( '#%%' . $marker . wp_hash( WHM_WP_PLUGIN_URL ) . '%%(.*?)%%' . $marker . '%%#is', function ( $matches ) {
				return base64_decode( $matches[1] );
			}, $content );
		}

		return $content;
	}

	/**
	 * Hides everything between hmwp_ignore tags.
	 *
	 * @param string $content   Content to process.
	 *
	 * @return string
	 */
	public function hideIgnoreTag( $content ) {
		return $this->replaceContentsWithMarkerIfExists( 'HMWPIGNORE', '/<!--\s?hmwp_ignore\s?-->/', '#<!--\s?hmwp_ignore\s?-->.*?<!--\s?/\s?hmwp_ignore\s?-->#is', $content );
	}

	/**
	 * Unhide hmwp_ignore tags.
	 *
	 * @param string $content   Content to process.
	 *
	 * @return string
	 */
	public function restoreIgnoreTag( $content ) {
		return $this->restoreMarkedContent( 'HMWPIGNORE', $content );
	}

	/**
	 * Binds hooks.
	 *
	 * @return bool
	 */
	public function bindHooks() {
		$is_hide_mode               = WHM_Helpers::isHideModeActive();
		$server_configuration_error = WCL_Plugin::app()->getPopulateOption( 'server_configuration_error' );
		$donot_hidemywp             = defined( 'WHM_DO_NOT_HIDE_WP' ) && WHM_DO_NOT_HIDE_WP;

		if ( ! $is_hide_mode || $server_configuration_error || $donot_hidemywp ) {
			return false;
		}

		// hooks to filer paths
		$hooks = [
			//'script_loader_src',
			//'style_loader_src',
			'admin_url',
			'stylesheet_uri',
			'stylesheet_directory_uri',
			'template_directory_uri',
			'plugins_url',
			'includes_url',
			'site_url',
			'wp_redirect'

			// 'bloginfo',
			// 'the_content'
		];

		$hooks = apply_filters( 'wbcr_hmwp_content_filter_hooks', $hooks );

		foreach ( $hooks as $hook ) {
			add_filter( $hook, [ $this, 'filterHooks' ], 9999, 1 );
		}

		// buffering to filter the page content

		// we don't call the function 'ob_end_flush' because it calls automatically at the request end
		add_action( 'after_setup_theme', [ $this, 'startBuffering' ], 0 );
		add_action( 'init', [ $this, 'init' ], 1 );

		/**
		 * Minify and Combine fix conflicts
		 */
		add_filter( 'wmac_filter_cssjs_alter_url', [ $this, 'recoveryUrlsForMac' ] );
		add_filter( 'wmac_minified_variants', [ $this, 'minifiedVariantsForMacfunction' ] );

		return true;
	}


	/**
	 * Init action
	 */
	public function init() {
		if ( ! is_admin() ) {

			// Remove default site description
			if ( WCL_Plugin::app()->getPopulateOption( 'remove_default_description' ) ) {
				add_filter( 'get_bloginfo_rss', [ $this, 'removeDefaultDescription' ], 10, 2 );
			}

			// Remove body classes
			if ( WCL_Plugin::app()->getPopulateOption( 'remove_body_class' ) ) {
				add_filter( 'body_class', [ $this, 'removeBodyClass' ], 9 );
			}

			// Remove post classes
			if ( WCL_Plugin::app()->getPopulateOption( 'remove_post_class' ) ) {
				add_filter( 'post_class', [ $this, 'removePostClass' ], 9 );
			}

			// Remove menu classes
			if ( WCL_Plugin::app()->getPopulateOption( 'remove_menu_class' ) ) {
				add_filter( 'nav_menu_css_class', [ $this, 'removeMenuClass' ], 9 );
				add_filter( 'nav_menu_item_id', [ $this, 'removeMenuClass' ], 9 );
				add_filter( 'page_css_class', [ $this, 'removeMenuClass' ], 9 );
			}
		}
	}

	/**
	 * Принудительно заставляем компонент Minify and Combine минифицировать файлы
	 * с расшиременим .min.js и .min.css. Это позволяет скрывать имена файлов и пути к ним, удалять информацию об используемых скриптах.
	 *
	 * @param array $variants
	 *
	 * @return array
	 */
	public function minifiedVariantsForMacfunction( $variants ) {
		return [
			'js/jquery/jquery.js'
		];
	}

	/**
	 * Исправление проблем для компонента Minify and Combine,
	 * мы восстанавливаем старые url, чтобы Minify and Combine мог построить правильные пути
	 * к файлам ресурсов.
	 *
	 * @param string $url
	 *
	 * @return mixed
	 */
	public function recoveryUrlsForMac( $url ) {
		if ( ! empty( $this->content_recovery_filters ) ) {
			$url = str_replace( $this->content_recovery_filters['patterns'], $this->content_recovery_filters['replacements'], $url );
		}

		if ( ! empty( $this->content_recovery_patterns ) ) {
			$url = preg_replace( $this->content_recovery_patterns['patterns'], $this->content_recovery_patterns['replacements'], $url );
		}

		return $url;
	}

	public function filterHooks( $value ) {
		if ( empty( $value ) ) {
			return $value;
		}

		$raw_value = $value;

		if ( ! empty( $this->filters_for_hooks ) ) {
			$value = str_replace( $this->filters_for_hooks['patterns'], $this->filters_for_hooks['replacements'], $value );
		}

		if ( ! empty( $this->patterns_for_hooks ) ) {
			$value = preg_replace( $this->patterns_for_hooks['patterns'], $this->patterns_for_hooks['replacements'], $value );

			// В случае ошибки возвращаем неотфильрованный контент
			if ( is_null( $value ) ) {
				$value = $raw_value;
			}
		}

		return $value;
	}

	public function startBuffering() {
		ob_start( [ $this, 'filterContent' ] );
	}

	public function filterContent( $content ) {
		if ( ! WHM_Helpers::isHideModeActive() ) {
			return $content;
		}

		if ( empty( $content ) ) {
			return $content;
		}

		$raw_content = $content;

		// Если при ajax запросе не нужно делать замену контента, то выводим контент без замены
		if ( ! WCL_Plugin::app()->getPopulateOption( 'replace_in_ajax' ) && wp_doing_ajax() ) {
			return $content;
		}

		$content = $this->hideIgnoreTag( $content );

		if ( ! empty( $this->filters_for_content ) ) {
			$content = str_replace( $this->filters_for_content['patterns'], $this->filters_for_content['replacements'], $content );
		}

		if ( ! empty( $this->patterns_for_content ) ) {
			$content = preg_replace( $this->patterns_for_content['patterns'], $this->patterns_for_content['replacements'], $content );

			// В случае ошибки возвращаем неотфильрованный контент
			if ( is_null( $content ) ) {
				$content = $raw_content;
			}
		}

		$content = $this->restoreIgnoreTag( $content );

		return $content;
	}

	/**
	 * Remove default description
	 *
	 * @param $blog_info
	 *
	 * @return string
	 */
	public function removeDefaultDescription( $blog_info, $show ) {
		if ( $show == 'name' || $show == 'description' ) {
			if ( $blog_info == __( 'Just another WordPress site' ) ) {
				return '';
			}

			return str_replace( 'WordPress', '', $blog_info );
		}

		return $blog_info;
	}

	/**
	 * Remove body classes
	 * Save only page class
	 *
	 * @param $classes
	 *
	 * @return array|string
	 */
	public function removeBodyClass( $classes ) {
		if ( is_array( $classes ) ) {
			$allow_classes = [
				'home',
				'blog',
				'category',
				'tag',
				'rtl',
				'author',
				'archive',
				'single',
				'search',
				'custom-background'
			];
			$new_classes   = [];
			foreach ( $classes as $class ) {
				if ( in_array( $class, $allow_classes ) ) {
					$new_classes[] = $class;
				}
			}
		} else {
			$new_classes = '';
		}

		return $new_classes;
	}

	/**
	 * Remove post classes
	 * Save only post format, post_types and sticky
	 *
	 * @param $classes
	 *
	 * @return array|string
	 */
	public function removePostClass( $classes ) {
		$post_types  = get_post_types();
		$new_classes = [];
		if ( is_array( $classes ) ) {
			foreach ( $classes as $class ) {
				if ( ( $class != 'format-standard' && WHM_Helpers::strStartsWith( $class, 'format-' ) ) || $class == 'sticky' ) {
					$new_classes[] = $class;
				}
				foreach ( $post_types as $post_type ) {
					if ( $class == $post_type ) {
						$new_classes[] = $class;
					}
				}
			}
		} else {
			$new_classes = '';
		}

		return $new_classes;
	}

	/**
	 * Remove menu classes
	 *
	 * @param $classes
	 *
	 * @return array|string
	 */
	public function removeMenuClass( $classes ) {
		$new_classes = [];
		if ( is_array( $classes ) ) {
			foreach ( $classes as $class ) {
				if ( WHM_Helpers::strStartsWith( $class, 'current_' ) ) {
					$new_classes[] = $class;
				}
			}
		} else {
			$new_classes = '';
		}

		return $new_classes;
	}
}

WHM_Plugin::$content_filter = new WHM_ContentFilter();
