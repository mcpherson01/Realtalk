<?php

/**
 * @property leadeo_main $main
 * @property leadeo_model $model
 */
class leadeo_backend_view
{
	public $main, $model;

	function __construct(&$main, &$model)
	{
		$this->main = $main;
		$this->model = $model;
	}
	
	function generate_form_color_picker ($id, $field, $label) {
		$prefix='';
		if ($id>-1) $prefix='leadeo_base_' . $id . '_';
		return '			<div class="leadeo_div_color_col" id="'.$prefix.'div_'.$field.'" style="margin-bottom: 20px">
								<span class="imapper_subtitle leadeo_color_'.$field.'_label">'.$label.'</span>
								<input id="'.$prefix.''.$field.'" name="'.$prefix.''.$field.'" class="color-picker-iris"  value="' . $this->model->get($field, $id) . '" type="hidden" style="background: ' . $this->model->get($field, $id) . ';">
								<div class="my_color_picker">
									<div class="my_color_picker_color"></div>
									<div class="my_color_picker_title" id="'.$prefix.'iris_'.$field.'" data-my-name="'.$prefix.''.$field.'">
										<span class="my_select_picker">Select Color</span>
										<span class="my_close_picker" style="display:none">Close</span>
									</div>
								</div>
								<div data-my-name="'.$prefix.''.$field.'" class="color-picker-iris-holder" style="margin-left: -125px;"></div>
							</div>';
	}

	/**
	 * @param $id
	 */
	function generate_form ($id, $type) {
		$title='';
		if ($type==1) $title='Contact form';
		if ($type==2) $title='Opt-in form';
		if ($type==3) $title='Open-link form';
		if ($type==4) $title='Share a quote form';
		if ($type==5) $title='Share to watch form';
		if ($type==6) $title='Thank you for watching form';

		$skip='<div style="display: inline-block; float: left; width: 30%; max-width: 200px;">
								<span class="imapper_subtitle">Allow skip</span>
								<span class="imapper-checkbox-on imapper-checkbox-span';
		if (!$this->model->get('allow_skip', $id)) $skip .= ' inactive';
		$skip .= '">On</span>
								<span class="imapper-checkbox-off imapper-checkbox-span';
		if ($this->model->get('allow_skip', $id)) $skip .= ' inactive';
		$skip .= '">Off</span>
								<input id="leadeo_base_' . $id . '_allow_skip" type="checkbox" value="1" name="leadeo_base_' . $id . '_allow_skip" style="display: none;"';
		if ($this->model->get('allow_skip', $id)) $skip.= ' checked="checked"';
		$skip .= '></div>';


		$output='<div id="leadeo_base_'.$id.'_label" style="overflow-x: hidden; width: 100%;"><div style="background-color: #ddd; padding: 5px; box-sizing: border-box; float: left; height: 30px; width: 240px; border-left: #aaa 3px solid; border-right: #aaa 3px solid; border-top: #aaa 3px solid; border-top-left-radius: 5px; border-top-right-radius: 5px;"><span style="font-size: 14px; font-weight: bolder;">'.$title.'</span>&nbsp;&nbsp;&nbsp;<span style="font-size: 10px; top: -5px; position: relative; cursor:pointer; float: right;" class="leadeo_remove_form">x</span></div>
			<div style="overflow-x: hidden; box-sizing: border-box; height: 30px; border-bottom: #aaa 3px solid;"></div>
			</div>';
		$output.='<div style="clear: left; background-color: #ddd; box-sizing: border-box; width: 100%; padding: 5px; margin-bottom: 20px; border-left: #aaa 3px solid; border-right: #aaa 3px solid; border-bottom: #aaa 3px solid;" class="leadeo_base" id="leadeo_base_'.$id.'" data-base="'.$id.'">';
		$output.='<input type="hidden" name="leadeo_base_'.$id.'_form_type" id="leadeo_base_'.$id.'_form_type" value="'.$type.'" />';
		if ($type!=6) {
			$output .= '<div id="leadeo_base_' . $id . '_timediv">
						<div id="leadeo_base_' . $id . '_timewrap" class="postbox">
							<h2 class="imapper-backend-header">Type in the time when you want Leadeo form to appear (minute:second)</h2>
							<label class="hide-if-field-empty" style="visibility:hidden" for="leadeo_base_' . $id . '_time" id="leadeo_base_' . $id . '_time_label">1:36</label>
							<input type="text" class="big_input_field check-hidden-label" data-my-required="true" data-my-hidden-label="#leadeo_base_' . $id . '_time_label" name="leadeo_base_' . $id . '_time" size="30" tabindex="3" value="' . $this->model->get('time', $id) . '" id="leadeo_base_' . $id . '_time" autocomplete="off" />
						</div>
					</div>';
		}
		$output.='<div class="my_general_social_options postbox">
						<h2 class="imapper-backend-header">Customize your form</h2>
						<div class="inside">';
		if ($type==1) {
		$output .= '<div id="leadeo_base_'.$id.'_contact_form_type">
								<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 10px;">Select fields that you want in your form</span>
								<div style="width: 143px; display: inline-block; float: left;"><label for="leadeo_base_'.$id.'_form_name"><input type="checkbox" name="leadeo_base_'.$id.'_form_name" id="leadeo_base_'.$id.'_form_name" '; if ($this->model->get('form_name', $id)) $output .= 'checked="checked"'; $output .= ' value="1"> <span class="imapper_subtitle2">Name</span></label></div>
								<div style="width: 143px; display: inline-block; float: left;"><label for="leadeo_base_'.$id.'_form_email"><input type="checkbox" name="leadeo_base_'.$id.'_form_email" id="leadeo_base_'.$id.'_form_email" '; if ($this->model->get('form_email', $id)) $output .= 'checked="checked"'; $output .= ' value="1"> <span class="imapper_subtitle2">E-mail</span></label></div>
								<div style="width: 143px; display: inline-block; float: left;"><label for="leadeo_base_'.$id.'_form_website"><input type="checkbox" name="leadeo_base_'.$id.'_form_website" id="leadeo_base_'.$id.'_form_website" '; if ($this->model->get('form_website', $id)) $output .= 'checked="checked"'; $output .= ' value="1"> <span class="imapper_subtitle2">Website</span></label></div>
								<div style="width: 143px; display: inline-block; float: left;"><label for="leadeo_base_'.$id.'_form_subject"><input type="checkbox" name="leadeo_base_'.$id.'_form_subject" id="leadeo_base_'.$id.'_form_subject" '; if ($this->model->get('form_subject', $id)) $output .= 'checked="checked"'; $output .= ' value="1"> <span class="imapper_subtitle2">Subject</span></label></div>
								<div style="width: 143px; display: inline-block; float: left;"><label for="leadeo_base_'.$id.'_form_message"><input type="checkbox" name="leadeo_base_'.$id.'_form_message" id="leadeo_base_'.$id.'_form_message" '; if ($this->model->get('form_message', $id)) $output .= 'checked="checked"'; $output .= ' value="1"> <span class="imapper_subtitle2">Message</span></label></div>
								<div class="clear"></div>

								<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 30px;">Insert Recipients E-mail (optional)</span>
								<input type="text" name="leadeo_base_'.$id.'_recipients_email" id="leadeo_base_'.$id.'_recipients_email" class="leadeo_edit_field" value="'.$this->model->get('recipients_email', $id).'" />
								<div class="clear"></div>
								<br />
							</div>';
		}
		if ($type==2) {
		$output .= '<div id="leadeo_base_'.$id.'_opt_in_mailchimp_type" class="leadeo_edit_field">
								<div style="display: inline-block; float: left; width: 80%;">
									<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 10px;">MailChimp API (optional)</span>
									<input type="text" name="leadeo_base_'.$id.'_mailchimp_api" id="leadeo_base_'.$id.'_mailchimp_api" class="mailchimp_api" value="'.$this->model->get('mailchimp_api', $id).'" />
								</div>
								<div style="display: inline-block; float: left; width: 20%; width: calc(20% - 10px);">
									<input name="leadeo_base_'.$id.'_mailchimp_api_button" id="leadeo_base_'.$id.'_mailchimp_api_button" value="Get lists" class="add-new-h2 mailchimp_api_button" type="submit" />
								</div>
								<div style="clear: both; display: block;" id="leadeo_base_'.$id.'_mailchimp_lists"></div>
								<div class="clear"></div>
								<br />
							</div>';
		}
		if ($type==1 || $type==2) {
			$output .= '<div class="clear" style="margin-top: 0px;"></div><br />
					<div class="clear" style="margin-top: 20px;"></div>';
			$output.=$this->generate_form_color_picker ($id, 'title_background_color', 'Title Background color');
			$output.=$this->generate_form_color_picker ($id, 'form_background_color', 'Form Background color');
			$output.=$this->generate_form_color_picker ($id, 'font_color', 'Font color');
			$output.=$this->generate_form_color_picker ($id, 'font_button_color', 'Button text color');
			$output.=$this->generate_form_color_picker ($id, 'button_color', 'Button color');
			$output.=$this->generate_form_color_picker ($id, 'border_color', 'Button border color');
			$output.='<div class="clear leadeo_separate_input_colors"></div>';
			$output.=$this->generate_form_color_picker ($id, 'input_font_color', 'Input field font color');
			$output.=$this->generate_form_color_picker ($id, 'input_background_color', 'Input field background');
		}
		if ($type==3 || $type==4 || $type==5 || $type==6) {
			$output .= '<div id="leadeo_base_'.$id.'_open_link_form_type">';
			if ($type==3) {
				$output .= '<span class="imapper_subtitle" style="display: block;">Insert link</span>
							<input type="text" name="leadeo_base_'.$id.'_form_link" id="leadeo_base_'.$id.'_form_link" class="leadeo_edit_field" value="'.$this->model->get('form_link', $id).'" />
							<div class="clear"></div>
							<div style="display: inline-block; float: left; width: 100%; margin-top: 20px;">';
			} else $output .= '<div style="display: inline-block; float: left; width: 100%;">';
			$output .= '		<span class="imapper_subtitle">Text on form</span>
								<textarea name="leadeo_base_' . $id . '_form_text" style="height: 50px;" class="leadeo_edit_field">' . $this->model->get('form_text', $id) . '</textarea>
							</div><div class="clear"></div>';
			if ($type==3) {
				$output .= '<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 23px;">Button text</span>
							<input type="text" name="leadeo_base_'.$id.'_button_text" id="leadeo_base_'.$id.'_button_text" class="leadeo_edit_field" value="'.$this->model->get('button_text', $id).'" />
							<div class="clear"></div>';
			}
			if ($type==3 || $type==4) {
				$output .= '<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 23px;">Number of seconds to stay visible</span>
							<input type="text" name="leadeo_base_'.$id.'_seconds_to_stay_visible" id="leadeo_base_'.$id.'_seconds_to_stay_visible" class="leadeo_edit_field" value="'.$this->model->get('seconds_to_stay_visible', $id).'" />
							<div class="clear"></div>';
			}
			$output .= '<div class="clear" style="margin-top: 20px;"></div>';
			$output.=$this->generate_form_color_picker ($id, 'form_background_color', 'Form Background color');
			$output.=$this->generate_form_color_picker ($id, 'font_color', 'Font color');
			$label='Button color';
			if ($type>3) $label='Share button color';
			$output.=$this->generate_form_color_picker ($id, 'button_color', $label);
			$label='Button text color';
			if ($type>3) $label='Share button text color';
			$output.=$this->generate_form_color_picker ($id, 'font_button_color', $label);
			$output.=$skip;
			$output.='</div><div class="clear"></div><br />';
		}
		$output .= '<div class="clear"></div>';
		if ($type==1 || $type==2) {
			$output .= $this->generate_form_color_picker($id, 'overlay_color', 'Choose Overlay Color');
			$output .= '		<div style="display: inline-block; float: left;" class="leadeo_overlay_field">
								<span class="imapper_subtitle">Choose Overlay Transparency</span>
								<input id="leadeo_base_' . $id . '_overlay_transparency" name="leadeo_base_' . $id . '_overlay_transparency" value="' . $this->model->get('overlay_transparency', $id) . '" size="3" type="text" style="width: 40px;">
								<div class="imapper-admin-slider" id="leadeo_base_' . $id . '_slider_overlay_transparency"></div>
							</div>';
			$output.=$skip;
		}

		if ($type==1 || $type==2) {
			$output .= '<div class="clear"></div><br />

							<div style="width: 450px; display: inline-block; float: left;">
								<span class="imapper_subtitle">Title</span>
								<textarea name="leadeo_base_' . $id . '_form_title" style="width: 380px; height: 150px;">' . $this->model->get('form_title', $id) . '</textarea>
							</div>
							<div style="width: 450px; display: inline-block; float: left;">
								<span class="imapper_subtitle">Subtitle</span>
								<textarea name="leadeo_base_' . $id . '_form_subtitle" style="width: 380px; height: 150px;">' . $this->model->get('form_subtitle', $id) . '</textarea>
							</div>';
		}

		$output .= '<div class="clear"></div><br />';

		$output .= '		<div style="width: 245px; display: inline-block; float: left;">
								<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 10px;">Auto width</span>
								<span class="imapper-checkbox-on imapper-checkbox-span';
		if (!$this->model->get('auto_width', $id)) $output.=' inactive';
		$output.='">On</span>
								<span class="imapper-checkbox-off imapper-checkbox-span';
		if ($this->model->get('auto_width', $id)) $output.=' inactive';
		$output.='">Off</span>
								<input id="leadeo_base_' . $id . '_auto_width" type="checkbox" value="1" name="leadeo_base_' . $id . '_auto_width" style="display: none;"';
		if ($this->model->get('auto_width', $id)) $output.= ' checked="checked"';
		$output.='>
							</div>
							<div style="width: 240px; display: inline-block; float: left; display: none;" id="leadeo_base_' . $id . '_width_div">
								<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 10px;">Width</span>
								<input type="text" name="leadeo_base_' . $id . '_width" id="leadeo_base_' . $id . '_width" style="width: 100px;" value="'.$this->model->get('width', $id).'" />
							</div>';

		$output .= '		<div style="width: 245px; display: inline-block; float: left;">
								<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 10px;">Auto height</span>
								<span class="imapper-checkbox-on imapper-checkbox-span';
		if (!$this->model->get('auto_height', $id)) $output.=' inactive';
		$output.='">On</span>
								<span class="imapper-checkbox-off imapper-checkbox-span';
		if ($this->model->get('auto_height', $id)) $output.=' inactive';
		$output.='">Off</span>
								<input id="leadeo_base_' . $id . '_auto_height" type="checkbox" value="1" name="leadeo_base_' . $id . '_auto_height" style="display: none;"';
		if ($this->model->get('auto_height', $id)) $output.= ' checked="checked"';
		$output.='>
							</div>
							<div style="width: 240px; display: inline-block; float: left; display: none;" id="leadeo_base_' . $id . '_height_div">
								<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 10px;">Height</span>
								<input type="text" name="leadeo_base_' . $id . '_height" id="leadeo_base_' . $id . '_height" style="width: 100px;" value="'.$this->model->get('height', $id).'" />
							</div>';

		$output.='
							<div class="clear"></div>
						</div>
					</div><!-- imapper general options  -->

					<div class="clear"></div>

					<div class="my_general_social_options postbox">
						<h2 class="imapper-backend-header">Choose the intro animation for your form</h2>
						<div class="inside">
							<div class="imapper-admin-select-wrapper" style="float:left;margin-right:4px;width:250px;">
								<span class="imapper-admin-select-span" data-my-name="leadeo_base_'.$id.'_animation">';
if ($this->model->get('animation', $id)=='fadein_bottom') $output .= 'FadeIn from bottom';
if ($this->model->get('animation', $id)=='fadein_top') $output .= 'FadeIn from top';
if ($this->model->get('animation', $id)=='fadein_left') $output .= 'FadeIn from left';
if ($this->model->get('animation', $id)=='fadein_right') $output .= 'FadeIn from right';
$output .= '</span>
								<select name="leadeo_base_'.$id.'_animation" id="leadeo_base_'.$id.'_animation">';
$list=<<<eod
									<option value="fadein_bottom">FadeIn from bottom</option>
									<option value="fadein_top">FadeIn from top</option>
									<option value="fadein_left">FadeIn from left</option>
									<option value="fadein_right">FadeIn from right</option>
eod;
$value=$this->model->get('animation', $id);
if ($value) $list=str_replace('value="'.$value.'"', 'selected="selected" value="'.$value.'"', $list);
$output .= $list;
$output .= '								</select>
							</div>
							<div class="clear"></div>
						</div>
					</div>
				</div>';
		return $output;
	}
}