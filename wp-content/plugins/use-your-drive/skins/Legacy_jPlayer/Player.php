<?php

namespace TheLion\UseyourDrive\MediaPlayers;

class Legacy_jPlayer extends \TheLion\UseyourDrive\MediaplayerSkin {

    public $url;
    public $template_path = __DIR__ . '/Template.php';

    public function __construct($processor) {
        parent::__construct($processor);

        $this->url = plugins_url('', __FILE__);

        add_action('wp_footer', array(&$this, 'load_custom_css'), 100);
        add_action('admin_footer', array(&$this, 'load_custom_css'), 100);
    }

    public function load_scripts() {
        wp_register_script('Legacy_jPlayer.Playlist', $this->get_url() . '/js/jplayer.playlist.min.js',  array('jquery'), USEYOURDRIVE_VERSION);
        wp_register_script('UseyourDrive.Legacy_jPlayer.jPlayer', $this->get_url() . '/js/jquery.jplayer.min.js', array('jquery','Legacy_jPlayer.Playlist'), USEYOURDRIVE_VERSION, true);
        wp_register_script('UseyourDrive.Legacy_jPlayer.Player', $this->get_url() . '/js/Player.js', array('UseyourDrive.Legacy_jPlayer.jPlayer', 'jquery-ui-slider','UseyourDrive'), USEYOURDRIVE_VERSION, true);

        wp_enqueue_script('UseyourDrive.Legacy_jPlayer.Player');

        $localize_mediaplayer = array(
            'player_url' => $this->get_url(),
        );

        wp_localize_script('UseyourDrive.Legacy_jPlayer.Player', 'Legacy_jPlayer_vars', $localize_mediaplayer);
    }

    public function load_styles() {
        wp_register_style('UseyourDrive.Legacy_jPlayer.Player.CSS', $this->get_url() . '/css/style.css', false, USEYOURDRIVE_VERSION);
        wp_enqueue_style('UseyourDrive.Legacy_jPlayer.Player.CSS');
    }

    public function load_custom_css() {
        $css_html = '<!-- Custom UseyourDrive Legacy Player CSS Styles -->' . "\n";
        $css_html .= '<style type="text/css" media="screen">' . "\n";
        $css = '';

        $colors = $this->get_processor()->get_setting('colors');

        $css = file_get_contents(__DIR__ . '/css/skin.' . $colors['style'] . '.min.css');
        $css = preg_replace_callback('/%(.*)%/iU', array(&$this, 'fill_placeholder_styles'), $css);

        $css_html .= \TheLion\UseyourDrive\Helpers::compress_css($css);
        $css_html .= '</style>' . "\n";

        echo $css_html;
    }

    public function fill_placeholder_styles($matches) {

        $colors = $this->get_processor()->get_setting('colors');

        if (isset($colors[$matches[1]])) {
            return $colors[$matches[1]];
        }

        return 'initial';
    }

}

/* Backwards compatability for < WP 5.0 */
if (function_exists('determine_locale') === false) {

    function determine_locale() {
        return get_locale();
    }

}
