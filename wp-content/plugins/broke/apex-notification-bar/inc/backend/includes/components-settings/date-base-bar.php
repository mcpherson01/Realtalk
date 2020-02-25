<?php defined('ABSPATH') or die("No script kiddies please!"); ?>
<div class="edn-field">
    <div class="edn-col-one-fourth">
        <div class="edn-field-wrapper edn-form-field">
            <label><?php _e('Select Starting date', APEXNB_TD) ?></label>
            <div class="edn-field">
                <i class="fa fa-calendar edn-datepicker_start" aria-hidden="true" id="start"></i>
                <input type="text" name="edn_date[start_date]" id="edn-st-date" class="edn-datepicker edn-datepicker_start" value="<?php if(isset($_GET['action'])){echo esc_attr($edn_bar_date['start_date']);}?>" />
            </div>
        </div>
    </div>
    <div class="edn-col-one-fourth">
        <div class="edn-field-wrapper edn-form-field">
            <label><?php _e('Select Ending date', APEXNB_TD) ?></label>
            <div class="edn-field">
                <i class="fa fa-calendar edn-datepicker_end" aria-hidden="true" id="end"></i>
                <input type="text" name="edn_date[end_date]" id="edn-end-date" class="edn-datepicker edn-datepicker_end"  value="<?php if(isset($_GET['action'])){echo esc_attr($edn_bar_date['end_date']);}?>" />
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="apexnb-notifybar">
      <p class="edn-note"><?php _e('Note : If date is not specified, the notification bar will always be displayed.',APEXNB_TD);?></p>
    </div>
</div>