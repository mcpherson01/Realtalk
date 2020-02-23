<?php
namespace Elementor;

function eae_elementor_init(){
    Plugin::instance()->elements_manager->add_category(
        'mayosis-ele-cat',
        [
            'title'  => 'Mayosis Elements',
            'icon' => 'font'
        ],
        1
    );
}
add_action('elementor/init','Elementor\eae_elementor_init');



