<?php
/**
 * Обычно в этом файле размещает код, который отвечает за уведомление, совместимость с другими плагинами,
 * незначительные функции, которые должны быть выполнены на всех страницах админ панели.
 *
 * В этом файле должен быть размещен код, которые относится только к области администрирования.
 *
 * @author        Alexander Kovalev <alex.kovalevv@gmail.com>, GitHub: https://github.com/alexkovalevv
 * @copyright (c) 01.10.2018, Webcraftic
 *
 * @version       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'LOADING_UPDATES_MANAGER_PREMIUM_AS_ADDON' ) ) {
	/**
	 * This action is executed when the component of the Clearfy plugin is activate and if this component is name ga_cache
	 */
	add_action( 'wbcr/clearfy/activated_component', function ( $component_name ) {
		if ( $component_name == 'updates-manager-premium' ) {

			$plugin = new WUPMP_Activation( WUPMP_Plugin::app() );
			$plugin->activate();

			if ( class_exists( 'WCL_Plugin' ) ) {
				if ( ! WCL_Plugin::app()->isActivateComponent( 'updates_manager' ) ) {
					WCL_Plugin::app()->activateComponent( 'updates_manager' );
				}
			}
		}
	} );

	/**
	 * This action is executed when the component of the Clearfy plugin is activate and if this component is name ga_cache
	 */
	add_action( 'wbcr_clearfy_deactivated_component', function ( $component_name ) {
		if ( $component_name == 'updates-manager-premium' ) {

			$plugin = new WUPMP_Activation( WUPMP_Plugin::app() );
			$plugin->deactivate();

			if ( class_exists( 'WCL_Plugin' ) ) {
				if ( WCL_Plugin::app()->isActivateComponent( 'updates_manager' ) ) {
					WCL_Plugin::app()->deactivateComponent( 'updates_manager' );
				}
			}
		}
	} );
}

/**
 * Добавляет ссылку на страницу отзывов плагина для виджета внизу интерфейса плагина.
 *
 * @param string $page_url      - ссылка на страницу отзывов по умолчанию
 * @param string $plugin_name   - имя плагина
 *
 * @return string
 */
/*function wbcr_upmp_rating_widget_url($page_url, $plugin_name)
{
	if( $plugin_name == WUPMP_Plugin::app()->getPluginName() ) {
		return 'https://goo.gl/v4QkW5';
	}

	return $page_url;
}

add_filter('wbcr_factory_pages_000_imppage_rating_widget_url', 'wbcr_upmp_rating_widget_url', 10, 2);*/

/**
 * Функция регистрирует все опции интерфейса текущего плагина, в плагине Clearfy,
 * в последствии плагина Clearfy может управлять ими, удалить, экспортировать,
 * использовать для быстрой настройки.
 *
 * @param array $options   - массив всех опций зарегистрированных в плагине Clearfy
 *
 * @return mixed
 */
/*function wbcr_upmp_group_options($options)
{
	$options[] = array(
		'name' => 'disable_comments',
		'title' => __('Disable comments on the entire site', 'image-optimizer'),
		'tags' => array('disable_all_comments'),
		'values' => array('disable_all_comments' => 'disable_comments')
	);
	$options[] = array(
		'name' => 'disable_comments_for_post_types',
		'title' => __('Select post types', 'image-optimizer'),
		'tags' => array()
	);
	$options[] = array(
		'name' => 'comment_text_convert_links_pseudo',
		'title' => __('Replace external links in comments on the JavaScript code', 'image-optimizer'),
		'tags' => array('recommended', 'seo_optimize')
	);

	return $options;
}

add_filter("wbcr_clearfy_group_options", 'wbcr_upmp_group_options');*/

/**
 * Добавляет кнопку быстрой настройки в плагине Clearfy. Кнопки быстрой настройки,
 * обычно используются для того, чтобы пользователь смог одним нажатием активировать полсотни настроек.
 *
 * @param array $mods   - массив, который содержит список всех режимов для быстрой настройки
 *
 * @return mixed
 */
/*function wbcr_upmp_allow_quick_mods($mods)
{
	$mods['test_quick_mode'] = array(
		'title' => __('One click test quick mode', 'image-optimizer'), // Название быстрого режима
		'icon' => 'dashicons-testimonial' // класс dashicons (https://developer.wordpress.org/resource/dashicons/#minus)
	);
	
	return $mods;
}

add_filter("wbcr_clearfy_allow_quick_mods", 'wbcr_upmp_allow_quick_mods');*/