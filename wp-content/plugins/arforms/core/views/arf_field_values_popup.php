<?php
global $armainhelper;

$states = $armainhelper->get_us_states();

$current_year = date("Y");

$from_year = "1935";

$year_display = array();
for ($yr_counter = $from_year; $yr_counter <= $current_year; $yr_counter++) {
    $year_display[] = (string) $yr_counter;
}

$country_codes = $armainhelper->get_country_codes();

ksort($country_codes);

$country_codes = array_keys($country_codes);

$preset_options = array(
    addslashes(__('Countries', 'ARForms')) => $armainhelper->get_countries(),
    addslashes(__('U.S. States', 'ARForms')) => array_values($states),
    addslashes(__('U.S. State Abbreviations', 'ARForms')) => array_keys($states),
    addslashes(__('Age Group', 'ARForms')) => array(
    addslashes(__('Under 18', 'ARForms')),
    addslashes(__('18-24', 'ARForms')),
    addslashes(__('25-34', 'ARForms')),
    addslashes(__('35-44', 'ARForms')),
    addslashes(__('45-54', 'ARForms')),
    addslashes(__('55-64', 'ARForms')),
    addslashes(__('65 or Above', 'ARForms'))
    ),
    addslashes(__('Satisfaction', 'ARForms')) => array(
        addslashes(__('Very Satisfied', 'ARForms')),
        addslashes(__('Satisfied', 'ARForms')),
        addslashes(__('Neutral', 'ARForms')),
        addslashes(__('Unsatisfied', 'ARForms')),
        addslashes(__('Very Unsatisfied', 'ARForms')),
        addslashes(__('N/A', 'ARForms'))
    ),
    addslashes(__('Days', 'ARForms')) => array(
        
        addslashes(__('1', 'ARForms')), 
        addslashes(__('2', 'ARForms')), 
        addslashes(__('3', 'ARForms')), 
        addslashes(__('4', 'ARForms')), 
        addslashes(__('5', 'ARForms')), 
        addslashes(__('6', 'ARForms')),
        addslashes(__('7', 'ARForms')), 
        addslashes(__('8', 'ARForms')), 
        addslashes(__('9', 'ARForms')), 
        addslashes(__('10', 'ARForms')), 
        addslashes(__('11', 'ARForms')), 
        addslashes(__('12', 'ARForms')),
        addslashes(__('13', 'ARForms')), 
        addslashes(__('14', 'ARForms')), 
        addslashes(__('15', 'ARForms')), 
        addslashes(__('16', 'ARForms')), 
        addslashes(__('17', 'ARForms')), 
        addslashes(__('18', 'ARForms')),
        addslashes(__('19', 'ARForms')), 
        addslashes(__('20', 'ARForms')), 
        addslashes(__('21', 'ARForms')), 
        addslashes(__('22', 'ARForms')), 
        addslashes(__('23', 'ARForms')), 
        addslashes(__('24', 'ARForms')),
        addslashes(__('25', 'ARForms')), 
        addslashes(__('26', 'ARForms')), 
        addslashes(__('27', 'ARForms')), 
        addslashes(__('28', 'ARForms')), 
        addslashes(__('29', 'ARForms')), 
        addslashes(__('30', 'ARForms')),
        addslashes(__('31', 'ARForms') ),
    ),
    addslashes(__('Week Days', 'ARForms')) => array(
        addslashes(__('Sunday', 'ARForms')),
        addslashes(__('Monday', 'ARForms')),
        addslashes(__('Tuesday', 'ARForms')),
        addslashes(__('Wednesday', 'ARForms')),
        addslashes(__('Thursday', 'ARForms')),
        addslashes(__('Friday', 'ARForms')),
        addslashes(__('Saturday', 'ARForms'))
    ),
    addslashes(__('Months', 'ARForms')) => array(
        addslashes(__('January', 'ARForms')),
        addslashes(__('February', 'ARForms')),
        addslashes(__('March', 'ARForms')),
        addslashes(__('April', 'ARForms')),
        addslashes(__('May', 'ARForms')),
        addslashes(__('June', 'ARForms')),
        addslashes(__('July', 'ARForms')),
        addslashes(__('August', 'ARForms')),
        addslashes(__('September', 'ARForms')),
        addslashes(__('October', 'ARForms')),
        addslashes(__('November', 'ARForms')),
        addslashes(__('December', 'ARForms')),
    ),
    addslashes(__('Years', 'ARForms')) => $year_display,
    addslashes(__('Prefix', 'ARForms')) => array(
    addslashes(__('Mr', 'ARForms')),
    addslashes(__('Mrs', 'ARForms')),
    addslashes(__('Ms', 'ARForms')),
    addslashes(__('Miss', 'ARForms')),
    addslashes(__('Sr', 'ARForms')),
    ),
    addslashes(__('Telephone Country Code', 'ARForms')) => $country_codes
);

array_unshift($preset_options[addslashes(__('Countries', 'ARForms'))],'');

$arf_preset_values = @maybe_unserialize(get_option('arf_preset_values'));

if (!empty($arf_preset_values) && is_array($arf_preset_values)) {
    foreach ($arf_preset_values as $data) {
        $preset_data = array();
        
        foreach ($data['data'] as $sub_data) {
            $preset_data[] = htmlspecialchars($sub_data['label'], ENT_QUOTES, 'UTF-8').'|'.htmlspecialchars($sub_data['value'], ENT_QUOTES, 'UTF-8');
        }
        $preset_options[$data['title']] = $preset_data;
    }
}
$arf_preset_fields = $preset_options;
?>
<div class="arf_field_values_model" id="arf_field_values_model_skeleton">
    <div class="arf_field_values_model_header"><?php echo addslashes(__('Edit Options', 'ARForms')); ?></div>
    <div class="arf_field_values_model_container">
        <div class="arf_field_values_content_row">
            <div class="arf_field_values_content_cell" id="use_image">
                <label class="arf_field_values_content_cell_label"><?php echo __('Use image over options', 'ARForms'); ?>:</label>
                <div class="arf_field_values_content_cell_input">
                    <label class="arf_js_switch_label">
                        <span><?php echo addslashes(__('No', 'ARForms')); ?></span>
                    </label>
                    <div class="arf_js_switch_wrapper arf_no_transition">
                        <input type="checkbox" class="js-switch" name="use_image" data-field-id="{arf_field_id}" value="1" id="arf_field_use_image" />
                        <span class="arf_js_switch"></span>
                    </div>
                    <label class="arf_js_switch_label">
                        <span><?php echo addslashes(__('Yes', 'ARForms')); ?></span>
                    </label>
                    <span class="arfhelptip" data-title="<?php echo addslashes(__('Use image over {arf_field_type} label', 'ARForms')); ?>"><svg width="18px" height="18px"><?php echo ARF_TOOLTIP_ICON; ?></svg></span>
                </div>
            </div>
            <div class="arf_field_values_content_cell" id="separate_value">
                <label class="arf_field_values_content_cell_label"><?php echo addslashes(__('Use separate value', 'ARForms')); ?></label>
                <div class="arf_field_values_content_cell_input">
                    <label class="arf_js_switch_label">
                        <span><?php echo addslashes(__('No', 'ARForms')); ?></span>
                    </label>
                    <div class="arf_js_switch_wrapper arf_no_transition">
                        <input type="checkbox" class="js-switch arf_hide_opacity " name="separate_value" data-field-id="{arf_field_id}" id="arf_field_separate_value" value="1" />
                        <span class="arf_js_switch"></span>
                    </div>
                    <label class="arf_js_switch_label">
                        <span><?php echo addslashes(__('Yes', 'ARForms')); ?></span>
                    </label>
                    <?php $title = addslashes(__('Add a separate value to use for calculations, email routing, saving to database and many other uses. The option values are saved while option labels are shown in the form', 'ARForms')); ?>
                    <span class="arfhelptip" data-title="<?php echo $title; ?>"><svg width="18px" height="18px"><?php echo ARF_TOOLTIP_ICON; ?></svg></span>
                </div>
            </div>
            <div class="arf_field_values_content_cell arf_full_width_cell" id="options">
                <div class="arf_field_values_content_cell_input">
                    <div class="arf_field_value_grid_wrapper">
                        <div class="arf_field_value_grid_container">
                            <div class="arf_field_value_grid_header">
                                <div class="arf_field_value_grid_header_cell_input">
                                    <div class='arf_field_radio_reset_wrapper' data-content="<?php echo __('Reset','ARForms'); ?>">
                                        <i class="arfa arfa-redo"></i>
                                    </div>
                                </div>
                                <div class="arf_field_value_grid_header_cell_label"><?php echo __('Option label', 'ARForms'); ?></div>
                                <div class="arf_field_value_grid_header_cell_value"><?php echo addslashes(__('Saved Value', 'ARForms')); ?></div>
                                <div class="arf_field_value_grid_header_cell_action"></div>
                            </div>
                            <div class="arf_field_value_grid_data_wrapper" id="arf_field_value_grid_data_wrapper_{arf_field_id}">
                            </div>
                            <input type="hidden" name="arf_radio_image_name" id="arf_radio_image_name" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="arf_field_values_content_cell arf_full_width_cell" id="use_preset_fields">
                <label class="arf_field_values_content_cell_label"></label>
                <div class="arf_field_values_content_cell_input">
                    <button type="button" onClick="arfshowbulkfieldoptions1('{arf_field_id}')" class="arf_preset_field_button" data-field-id="{arf_field_id}"><?php echo addslashes(__('Preset Field Choices', 'ARForms')); ?></button>
                    <div class="arf_preset_field_dropdown_wrapper" id="arfshowfieldbulkoptions-{arf_field_id}">
                        <input type="hidden" class="frm-bulk-select-class" id="frm_bulk_options-select-{arf_field_id}" value="" onClick="arfstorebulkoptionvalue('{arf_field_id}', this.value);" />
                        <dl class="arf_selectbox" data-name="frm_bulk_options-select-{arf_field_id}" data-id="frm_bulk_options-select-{arf_field_id}">
                            <dt>
                            <span><?php echo addslashes(__('Select', 'ARForms')); ?></span>
                            <input type="text" style="display:none;" class="arf_autocomplete" value="" />
                            <i class="arfa arfa-caret-down arfa-lg"></i>
                            </dt>
                            <dd>
                                <ul style="display:none;" data-id="frm_bulk_options-select-{arf_field_id}">
                                    <li class="arf_selectbox_option" data-value="" data-label="<?php echo addslashes(__('Select', 'ARForms')); ?>"><?php echo addslashes(__('Select', 'ARForms')); ?></li>
                                    <?php
                                    foreach ($arf_preset_fields as $preset_label => $preset_values) {
                                        $final_preset_values = $preset_values;
                                        if (array_keys($preset_values) !== range(0, count($preset_values) - 1)) {
                                            $final_preset_values = array();
                                            foreach ($preset_values as $new_preset_key => $new_preset_data) {
                                                $new_preset_key_data = $new_preset_key;
                                                if ($new_preset_key_data == '') {
                                                    $new_preset_key_data = $new_preset_data;
                                                }
                                                $final_preset_values[] = htmlspecialchars($new_preset_key_data, ENT_QUOTES, 'UTF-8') . '|' . htmlspecialchars($new_preset_data, ENT_QUOTES, 'UTF-8');
                                            }
                                        }
                                        ?>
                                        <li class="arf_selectbox_option" data-value='<?php echo json_encode(array_values($final_preset_values)); ?>' data-label="<?php echo htmlspecialchars($preset_label, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($preset_label, ENT_QUOTES, 'UTF-8'); ?></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </dd>
                        </dl>
                        <button type="button" class="arf_preset_apply_button" data-field-type="{arf_field_type}" data-field-id="{arf_field_id}" ><?php echo addslashes(__('Apply', 'ARForms')); ?></button>
                        <button type="button" class="arf_preset_cancel_button arf_field_cancel_button" data-field-id="{arf_field_id}"><?php echo addslashes(__('Cancel', 'ARForms')); ?></button>
                        <span class="arf_preset_apply_field_loader" id="arf_preset_apply_field_loader_{arf_field_id}"><?php echo addslashes(__('Saving', 'ARForms')) . '...'; ?></span>
                    </div>

                </div>
            </div>
            <div class="arf_field_values_content_cell arf_full_width_cell" id="add_preset_fields">
                <label class="arf_field_values_content_cell_label" style="display:none;"></label>
                <div class="arf_field_values_content_cell_input">
                    <button type="button" onClick="arf_preset_field_show('{arf_field_id}')" class="arf_preset_field_button" data-field-id="{arf_field_id}"><?php echo addslashes(__('Add New Preset Choices', 'ARForms')); ?></button>
                    <div class='arf_new_preset_field_content_wrapper arf_preset_field_content_wrapper_{arf_field_id}'>
                        <span class="arf_new_preset_field_data_uploader">
                            <input type="file" id="arf_preset_data_{arf_field_id}" class="arf_preset_data" name="arf_preset_data" data-val="{arf_field_id}" />
                            <span class="arf_field_option_input_note_text"><?php echo addslashes(__('Upload only CSV file.', 'ARForms')).'<br/>'.addslashes(__('Please upload tab separated CSV file.','ARForms')); ?></span>
                        </span>
                        <span class="arf_custom_checkbox_wrapper">
                            <input type="checkbox" class="arf_custom_checkbox arf_enable_new_preset_field_save" value="1" name="arf_preset_future_use" id="arf_preset_future_use_{arf_field_id}" data-field-id="{arf_field_id}" />
                            <svg width="18px" height="18px">
                            <path id='arfcheckbox_unchecked' d='M15.205,16.852H3.774c-1.262,0-2.285-1.023-2.285-2.286V3.136  c0-1.263,1.023-2.286,2.285-2.286h11.431c1.263,0,2.286,1.023,2.286,2.286v11.43C17.491,15.829,16.467,16.852,15.205,16.852z M15.49,2.851h-12v12h12V2.851z' />
                            <path id='arfcheckbox_checked' d='M15.205,16.852H3.774c-1.262,0-2.285-1.023-2.285-2.286V3.136  c0-1.263,1.023-2.286,2.285-2.286h11.431c1.263,0,2.286,1.023,2.286,2.286v11.43C17.491,15.829,16.467,16.852,15.205,16.852z   M15.49,2.851h-12v12h12V2.851z M5.93,6.997l2.557,2.558l4.843-4.843l1.617,1.616l-4.844,4.843l0.007,0.007l-1.616,1.616  l-0.007-0.007l-0.006,0.007l-1.617-1.616l0.007-0.007L4.314,8.614L5.93,6.997z' />
                            </svg>
                            <label for="arf_preset_future_use_{arf_field_id}"><?php echo addslashes(__('Save for future use', 'ARForms')); ?></label>
                        </span>
                        <input type="text" class="arf_preset_field_title inplace_field" name="arf_preset_title" placeholder="<?php echo addslashes(__('Preset Title', 'ARForms')); ?>" id="arf_preset_field_title_{arf_field_id}" />
                        <button type="button" class="arf_new_preset_apply_button" data-field-type="{arf_field_type}" data-field-id="{arf_field_id}" ><?php echo addslashes(__('Apply', 'ARForms')); ?></button>
                        <button type="button" class="arf_new_preset_cancel_button arf_field_cancel_button" data-field-id="{arf_field_id}"><?php echo addslashes(__('Cancel', 'ARForms')); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="arf_field_values_model_footer">
        <button type="button" class="arf_field_values_close_button"><?php echo addslashes(__('Cancel', 'ARForms')); ?></button>
        <button type="button" class="arf_field_values_submit_button" data-field_id=""><?php echo __('OK', 'ARForms'); ?></button>
    </div>
</div>