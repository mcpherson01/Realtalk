<?php

namespace TheLion\UseyourDrive;

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

class Gutenberg {

    /**
     *
     * @var \TheLion\UseyourDrive\Main 
     */
    private $_main;

    public function __construct(Main $_main) {
        $this->_main = $_main;

        if ($this->has_gutenberg()) {
            add_action('init', array(&$this, 'init_block'));
        }
    }

    public function has_gutenberg() {
        return function_exists('register_block_type');
    }

    public function init_block() {

        wp_register_script('UseyourDrive.ShortcodeGeneratorBlock', USEYOURDRIVE_ROOTPATH . '/includes/blocks/editor-script.js', array('wp-blocks', 'wp-element'), false, USEYOURDRIVE_VERSION);
        wp_register_style('UseyourDrive.ShortcodeGeneratorBlock.Style', USEYOURDRIVE_ROOTPATH . '/includes/blocks/style.css', array('wp-edit-blocks'), USEYOURDRIVE_VERSION);
        wp_register_style('UseyourDrive.ShortcodeGeneratorBlock.EditorStyle', USEYOURDRIVE_ROOTPATH . '/includes/blocks/editor-style.css', array('wp-edit-blocks'), USEYOURDRIVE_VERSION);

        register_block_type('useyourdrive/shortcodegenerator', array(
            'editor_script' => 'UseyourDrive.ShortcodeGeneratorBlock',
            'editor_style' => 'UseyourDrive.ShortcodeGeneratorBlock.EditorStyle',
            'style' => 'UseyourDrive.ShortcodeGeneratorBlock.Style',
        ));
    }

}
