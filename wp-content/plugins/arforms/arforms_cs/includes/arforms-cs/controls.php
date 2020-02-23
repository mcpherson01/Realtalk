<?php

global $armainhelper, $arformhelper, $arfversion, $wpdb, $arfform;
$arf_cs_control = array();

$forms = $arfform->getAll("is_template=0 AND (status is NULL OR status = '' OR status = 'published')", ' ORDER BY name');



$arf_forms = array();

$arf_forms[0]['value'] = '';
$arf_forms[0]['label'] = addslashes(__('- Select form -', 'ARForms'));

if (!empty($forms)) {
    $n = 1;
    foreach ($forms as $key => $forms_data) {
        $arf_forms[$n]['value'] = $forms_data->id;
        $arf_forms[$n]['label'] = $forms_data->name . ' [' . $forms_data->id . ']';
        $n++;
    }
}

$arf_cs_control['arf_forms'] = array(
    'type' => 'select',
    'ui' => array(
        'title' => addslashes(__('Select a form to insert into page', 'ARForms'))
    ),
    'options' => array(
        'choices' => $arf_forms
    )
);

$arf_cs_control['arf_forms_include_type'] = array(
    'type' => 'select',
    'ui' => array(
        'title' => addslashes(__('How you want to include this form into page?', 'ARForms'))
    ),
    'options' => array(
        'choices' => array(
            array('value' => 'internal', 'label' => addslashes(__('Internal', 'ARForms'))),
            array('value' => 'external', 'label' => addslashes(__('Modal(popup) window', 'ARForms'))),
        )
    )
);
$arf_cs_control['arf_link_type'] = array(
    'type' => 'select',
    'ui' => array(
        'title' => addslashes(__('Modal Trigger Type', 'ARForms'))
    ),
    'options' => array(
        'choices' => array(
            array('value' => 'onclick', 'label' => addslashes(__('On click', 'ARForms'))),
            array('value' => 'onload', 'label' => addslashes(__('On Page Load', 'ARForms'))),
            array('value' => 'scroll', 'label' => addslashes(__('On Page Scroll', 'ARForms'))),
            array('value' => 'timer', 'label' => addslashes(__('On Timer(Scheduled)', 'ARForms'))),
            array('value' => 'on_exit', 'label' => addslashes(__('On Exit(Exit Intent)', 'ARForms'))),
            array('value' => 'on_idle', 'label' => addslashes(__('On Idle', 'ARForms')))
        )
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external'
    )
);
$arf_cs_control['arf_onclick_type'] = array(
    'type' => 'select',
    'ui' => array(
        'title' => __('Click Types', 'ARForms')
    ),
    'options' => array(
        'choices' => array(
            array('value' => 'link', 'label' => addslashes(__('Link', 'ARForms'))),
            array('value' => 'button', 'label' => addslashes(__('Button', 'ARForms'))),
            array('value' => 'sticky', 'label' => addslashes(__('Sticky', 'ARForms'))),
            array('value' => 'fly', 'label' => addslashes(__('Fly (sidebar)', 'ARForms'))),
        )
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_link_type' => array('onclick')
    )
);

$arf_cs_control['arf_link_caption'] = array(
    'type' => 'text',
    'ui' => array(
        'title' => addslashes(__('Caption', 'ARForms'))
    ),
    'suggest' => addslashes(__('Caption', 'ARForms')),
    'content' => '',
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_link_type' => array('onclick')
    )
);

$arf_cs_control['arf_onload_time'] = array(
    'type' => 'text',
    'ui' => array(
        'title' => addslashes(__('Open popup after page load', 'ARForms'))
    ),
    'suggest' => addslashes(__('in second', 'ARForms')),
    'content' => '',
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_link_type' => 'timer'
    )
);

$arf_cs_control['arf_scroll_per'] = array(
    'type' => 'text',
    'ui' => array(
        'title' => addslashes(__('Open popup when user scroll % of page after page load', 'ARForms'))
    ),
    'suggest' => addslashes(__(' %  (eg. 100% - end of page)', 'ARForms')),
    'content' => '',
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_link_type' => 'scroll'
    )
);



$arf_cs_control['arf_link_position'] = array(
    'type' => 'select',
    'ui' => array(
        'title' => addslashes(__('Link Position', 'ARForms'))
    ),
    'options' => array(
        'choices' => array(
            array('value' => 'top', 'label' => addslashes(__('Top', 'ARForms'))),
            array('value' => 'bottom', 'label' => addslashes(__('Bottom', 'ARForms'))),
            array('value' => 'left', 'label' => addslashes(__('Left', 'ARForms'))),
            array('value' => 'right', 'label' => addslashes(__('Right', 'ARForms'))),
        )
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_onclick_type' => 'sticky'
    )
);

$arf_cs_control['arf_fly_position'] = array(
    'type' => 'select',
    'ui' => array(
        'title' => addslashes(__('Link Position', 'ARForms'))
    ),
    'options' => array(
        'choices' => array(
            array('value' => 'left', 'label' => addslashes(__('Left', 'ARForms'))),
            array('value' => 'right', 'label' => addslashes(__('Right', 'ARForms'))),
        )
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_onclick_type' => 'fly'
    )
);


$arf_cs_control['arf_background_overlay'] = array(
    'type' => 'select',
    'ui' => array(
        'title' => addslashes(__('Background Overlay', 'ARForms'))
    ),
    'options' => array(
        'choices' => array(
            array('value' => '0', 'label' => addslashes(__('0 (None)', 'ARForms'))),
            array('value' => '0.1', 'label' => addslashes(__('10%', 'ARForms'))),
            array('value' => '0.2', 'label' => addslashes(__('20%', 'ARForms'))),
            array('value' => '0.3', 'label' => addslashes(__('30%', 'ARForms'))),
            array('value' => '0.4', 'label' => addslashes(__('40%', 'ARForms'))),
            array('value' => '0.5', 'label' => addslashes(__('50%', 'ARForms'))),
            array('value' => '0.6', 'label' => addslashes(__('60%', 'ARForms'))),
            array('value' => '0.7', 'label' => addslashes(__('70%', 'ARForms'))),
            array('value' => '0.8', 'label' => addslashes(__('80%', 'ARForms'))),
            array('value' => '0.9', 'label' => addslashes(__('90%', 'ARForms'))),
            array('value' => '1', 'label' => addslashes(__('100%', 'ARForms'))),
        )
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_onclick_type' => array('link', 'button'),
        'arf_link_type' => array('onload', 'scroll', 'on_exit','onclick')
    )
);

$arf_cs_control['arf_background_overlay_color'] = array(
    'type' => 'color',
    'ui' => array(
        'title' => addslashes(__('Background Overlay', 'ARForms'))
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_onclick_type' => array('link', 'button'),
        'arf_link_type' => array('onload', 'scroll', 'on_exit','onclick')
    )
);

$arf_cs_control['arf_show_close_button'] = array(
    'type' => 'toggle',
    'ui' => array(
        'title' => addslashes(__('Show Close Button', 'ARForms'))
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external',
    )
);

$arf_cs_control['arf_button_background_color'] = array(
    'type' => 'color',
    'ui' => array(
        'title' => addslashes(__('Button Background Color', 'ARForms'))
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_onclick_type' => array('button', 'sticky', 'fly')
    )
);


$arf_cs_control['arf_button_text_color'] = array(
    'type' => 'color',
    'ui' => array(
        'title' => addslashes(__('Button Text Color', 'ARForms'))
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_onclick_type' => array('button', 'sticky', 'fly')
    )
);


$arf_cs_control['arf_popup_width'] = array(
    'type' => 'text',
    'ui' => array(
        'title' => addslashes(__('Width', 'ARForms'))
    ),
    'suggest' => addslashes(__('In px (Form width will be overwritten)', 'ARForms')),
    'content' => '',
    'condition' => array(
        'arf_forms_include_type' => 'external'
    )
);


$arf_cs_control['arf_fly_button_angle'] = array(
    'type' => 'select',
    'ui' => array(
        'title' => addslashes(__('Button angle', 'ARForms'))
    ),
    'options' => array(
        'choices' => array(
            array('value' => '0', 'label' => addslashes(__('0', 'ARForms'))),
            array('value' => '90', 'label' => addslashes(__('90', 'ARForms'))),
            array('value' => '-90', 'label' => addslashes(__('-90', 'ARForms'))),
        )
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_onclick_type' => array('fly')
    )
);



$arf_cs_control['arf_inact_time'] = array(
    'type' => 'text',
    'ui' => array(
        'title' => addslashes(__('Show after user is inactive for (in minutes)', 'ARForms'))
    ),
    'suggest' => addslashes(__('In Minute', 'ARForms')),
    'content' => '0.025',
    'condition' => array(
        'arf_forms_include_type' => 'external',
        'arf_link_type' => array('on_idle')
    )
);

$arf_cs_control['arf_modal_effect'] = array(
    'type' => 'select',
    'ui' => array(
        'title' => addslashes(__('Animation Effect', 'ARForms'))
    ),
    'options' => array(
        'choices' => array(
            array('value' => 'no_animation', 'label' => addslashes(__('No Animation','ARForms') )),
            array('value' => 'fade_in', 'label' => addslashes(__('Fade-In', 'ARForms'))),
            array('value' => 'slide_in_top', 'label' => addslashes(__('Slide In Top', 'ARForms'))),
            array('value' => 'slide_in_bottom', 'label' => addslashes(__('Slide In Bottom', 'ARForms'))),
            array('value' => 'slide_in_right', 'label' => addslashes(__('Slide In right', 'ARForms'))),
            array('value' => 'slide_in_left', 'label' => addslashes(__('Slide In Left', 'ARForms'))),
            array('value' => 'zoom_in', 'label' => addslashes(__('Zoom In','ARForms')))
        )
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external',
    )
);

$arf_cs_control['arf_show_full_screen'] = array(
    'type' => 'toggle',
    'ui' => array(
        'title' => addslashes(__('Show Full Screen Popup', 'ARForms'))
    ),
    'condition' => array(
        'arf_forms_include_type' => 'external',
    )
);



return $arf_cs_control;