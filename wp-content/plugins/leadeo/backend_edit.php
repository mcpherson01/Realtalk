<script type="text/javascript" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"
		xmlns="http://www.w3.org/1999/html">
	var leadeo_checkbox_changed;
	jQuery(document).ready(function($){
		var o={};
		/*o.ajax_url="http://wp.com/wp-admin/admin-ajax.php";
		  o.ajax_action="leadeo_admin_action";
		  o.ajax_timeout=120000;
		  o.preview_url="http://wp.com/wp-content/plugins/sogrid/includes/views/admin/pages/preview.php?id={id}&my_preview_sogrid=1";
		*/
		o.msgs={};
		o.msgs.preview_save="";
		o.msgs.field_is_required="Field {1} is required !";
		o.msgs.hex_value="HEX Value";

		wpMySoGridAdmin_ins=new wpMySoGridAdmin(o);
	});
</script>
<style>.leadeo_saved {display: none;}</style>

<div class="wrap imapper-admin-wrapper">

	<div class="form_result"></div>
	<form name="leadeo_form"  method="post" id="leadeo_form"><!-- items in this form should be saved -->
		<input type="hidden" name="leadeo_id" id="leadeo_id" value="<?php echo $this->model->get('id'); ?>" />
		<div id="poststuf">

			<div id="post-body" class="metabox-holder columns-1" style="padding:0;">
				<div id="post-body-content">

					<div id="titlediv" style="margin-right:300px">
						<div id="titlewrap" class="postbox">
							<h2 class="imapper-backend-header">1. Name your Leadeo</h2>
							<label class="hide-if-field-empty" style="visibility:hidden" for="title" id="title_label">Type your Leadeo name Here</label>
							<input type="text" class="leadeo_title_field big_input_field check-hidden-label" data-my-required="true" data-my-hidden-label="#title_label" name="title" size="30" tabindex="1" value="<?php echo $this->model->get('name'); ?>" id="title" autocomplete="off" />
						</div>
					</div>

					<div id="videodiv" style="margin-right:300px">
						<div id="videowrap" class="postbox">
							<h2 class="imapper-backend-header">2. Add URL for your video (YouTube, Vimeo)</h2>
							<label class="hide-if-field-empty" style="visibility:hidden" for="video_url" id="video_url_label">Example: https://www.youtube.com/watch?v=n9oQEa-d5rU</label>
							<input type="text" class="big_input_field check-hidden-label" data-my-required="true" data-my-hidden-label="#video_url_label" name="video_url" size="100" tabindex="2" value="<?php echo $this->model->get('video_url'); ?>" id="video_url" autocomplete="off" />
						</div>
					</div>

					<div class="my_save_preview_options">
						<div class="postbox">
							<h2 class='imapper-backend-header' style="cursor:auto"><span>Publish Leadeo</span><span class="leadeo_saved">Saved</span></h2>
							<div class="inside">
								<div style="padding-top:30px">
									<div id="save-progress" class="waiting ajax-saved" style="background-image: url(http://wp.com/wp-admin/images/wpspin_light.gif)" ></div>
									<input name="preview_leadeo" id="preview_leadeo" value="Preview" class="add-new-h2" style="padding:3px 25px" type="submit" />
									<input name="save_leadeo" id="save_leadeo" value="Save Leadeo" class="alignright add-new-h2" style="padding:3px 15px" type="submit" />
									<img id="save-loader" src="<?php echo $this->url; ?>images/ajax-loader.gif" class="alignright" />
									<br class="clear" />
								</div>
							</div>
						</div>
						<?php if (defined('LEADEO_LITE') && LEADEO_LITE==1) {
							echo '<a href="http://codecanyon.net/item/leadeo-wordpress-plugin-for-video-marketing/13478892?utm_source=LeadeoLite2ProUpgrade&utm_medium=wporg&utm_campaign=leadeo"><img src="'.$this->url.'images/banner.png" style="border: 0;"></a>';
						}?>
					</div>

					<div class="clear"></div>
					<div class="my_general_social_options postbox" style="margin-right:300px">
						<h2 class="imapper-backend-header">3. Choose the style of form</h2>
						<div class="inside">
							<div class="imapper-admin-select-wrapper" style="float:left;margin-right:4px;width:350px;">
								<span class="imapper-admin-select-span" data-my-name="form_style" id="form_style_span">
									<?php
									$form_styles=array();
									$form_styles[1]='Default';
									$form_styles[2]='Highway';
									$value=$this->model->get('form_style');
									$output=$form_styles[intval($value)];
									$output.='</span>
								<select name="form_style" id="form_style" class="leadeo_form_style">';
									$list='';
									foreach($form_styles as $id2=>$val) $list.='<option value="'.$id2.'" id="form_style_value_'.$id2.'">'.$val.'</option>';
									if ($value) $list=str_replace('value="'.$value.'"', 'selected="selected" value="'.$value.'"', $list);
									$output.=$list;
									$output.='
								</select>';
									echo $output;
								?>
							</div>
							<div class="clear"></div>
						</div>
					</div>
					<div class="my_general_social_options postbox" style="margin-right:300px">
						<h2 class="imapper-backend-header">3. Global options</h2>
						<div class="inside">
							<div style="width: 245px; display: inline-block; float: left;">
								<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 10px;">Auto width</span>
								<span class="imapper-checkbox-on imapper-checkbox-span<?php if (!$this->model->get('auto_width')) echo ' inactive'; ?>">On</span>
								<span class="imapper-checkbox-off imapper-checkbox-span<?php if ($this->model->get('auto_width')) echo ' inactive'; ?>">Off</span>
								<input id="auto_width" type="checkbox" value="1" name="auto_width" style="display: none;"<?php if ($this->model->get('auto_width')) echo ' checked="checked"'; ?>>
							</div>
							<div style="width: 240px; display: inline-block; float: left; display: none;" id="leadeo_width_div">
								<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 10px;">Width</span>
								<input type="text" name="width" id="leadeo_width" style="width: 100px;" value="<?php echo $this->model->get('width'); ?>" />
							</div>
							<div style="width: 245px; display: inline-block; float: left;">
								<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 10px;">Auto height</span>
								<span class="imapper-checkbox-on imapper-checkbox-span<?php if (!$this->model->get('auto_height')) echo ' inactive'; ?>">On</span>
								<span class="imapper-checkbox-off imapper-checkbox-span<?php if ($this->model->get('auto_height')) echo ' inactive'; ?>">Off</span>
								<input id="auto_height" type="checkbox" value="1" name="auto_height" style="display: none;"<?php if ($this->model->get('auto_height')) echo ' checked="checked"'; ?>>
							</div>
							<div style="width: 225px; display: inline-block; float: left; display: none;" id="leadeo_height_div">
								<span class="imapper_subtitle" style="display: block; margin-bottom: 10px; margin-top: 10px;">Height</span>
								<input type="text" name="height" id="leadeo_height" style="width: 100px;" value="<?php echo $this->model->get('height'); ?>" />
							</div>

							<div class="clear"></div><br />
							<span class="imapper_subtitle">Choose Main Font</span>
							<div class="imapper-admin-select-wrapper" style="float:left; margin-right: 20px; width: 310px;">
								<span class="imapper-admin-select-span" data-my-name="font_name"><?php if ($this->model->get('font_name')=='default') echo 'Default'; else echo $this->model->get('font_name'); ?></span>
								<?php echo $this->fonts_fields['font_list']; ?>
							</div>
							<div class="imapper-admin-select-wrapper" style="float:left;margin-right:20px;width:150px;">
								<span class="imapper-admin-select-span" data-my-name="font_size"><?php if ($this->model->get('font_size')=='default') echo 'Default'; else echo $this->model->get('font_size').'px'; ?></span>
								<select name="font_size" id="font_size">
									<?php
									$list=<<<eod
									<option value="default">Default</option>
									<option value="6">6px</option>
									<option value="8">8px</option>
									<option value="10">10px</option>
									<option value="12">12px</option>
									<option value="14">14px</option>
									<option value="16">16px</option>
									<option value="18">18px</option>
									<option value="20">20px</option>
									<option value="22">22px</option>
									<option value="24">24px</option>
									<option value="26">26px</option>
									<option value="28">28px</option>
									<option value="30">30px</option>
									<option value="32">32px</option>
									<option value="34">34px</option>
									<option value="36">36px</option>
									<option value="38">38px</option>
									<option value="40">40px</option>
									<option value="42">42px</option>
									<option value="44">44px</option>
									<option value="46">46px</option>
									<option value="48">48px</option>
									<option value="50">50px</option>
eod;
									$value=$this->model->get('font_size');
									if ($value) $list=str_replace('value="'.$value.'"', 'selected="selected" value="'.$value.'"', $list);
									echo $list;
									?>
								</select>
							</div>
							<div class="imapper-admin-select-wrapper" style="float:left;margin-right:20px;width:150px;">
								<span class="imapper-admin-select-span" data-my-name="font_variant" id="font_variant_span"><?php echo $this->upper_first_letter($this->model->get('font_variant')); ?></span>
								<?php echo $this->fonts_fields['variant_list']; ?>
							</div>
							<div class="imapper-admin-select-wrapper" style="float:left;margin-right:20px;width:150px;">
								<span class="imapper-admin-select-span" data-my-name="font_subset" id="font_subset_span"><?php echo $this->upper_first_letter($this->model->get('font_subset')); ?></span>
								<?php echo $this->fonts_fields['subset_list']; ?>
							</div>
							<div class="clear"></div>
						</div>
					</div><!-- imapper general options  -->

					<div class="clear"></div>

					<div id="leadeo_forms_container" style="margin-right: 300px;">
					<?php
						for ($i=0; $i <= $this->model->last_base_id; $i++) {
							if (!isset($this->model->data['base_'.$i.'_form_type'])) continue;
							$type=$this->model->get('form_type', $i);
							echo $this->backend_view->generate_form($i, $type);
						}
					?>
					</div>


				</div>
			</div>
			<div class="clear"></div>
		</div>
	</form>
	<div class="leadeo_buttons_wrap">

		<div class="leadeo_add_btn" id="leadeo_add_contact_form">
			Add contact form
		</div>

		<div class="leadeo_add_btn" id="leadeo_add_opt_form">
			Add Opt-in form
		</div>

		<div class="leadeo_add_btn<?php if (defined('LEADEO_LITE') && LEADEO_LITE==1) echo ' leadeo_add_btn_pro'; ?>" id="leadeo_add_open_link_form">
			Add Open-Link form
		</div>

		<div class="leadeo_add_btn<?php if (defined('LEADEO_LITE') && LEADEO_LITE==1) echo ' leadeo_add_btn_pro'; ?>" id="leadeo_add_share_a_quote_form">
			Add Share-a-Quote form
		</div>

		<div class="leadeo_add_btn<?php if (defined('LEADEO_LITE') && LEADEO_LITE==1) echo ' leadeo_add_btn_pro'; ?>" id="leadeo_add_share_to_watch_form">
			Add Share-to-watch form
		</div>

		<div class="leadeo_add_btn<?php if (defined('LEADEO_LITE') && LEADEO_LITE==1) echo ' leadeo_add_btn_pro'; ?>" id="leadeo_add_thank_you_for_watching_form">
			Add Thank-you form
		</div>
	</div>

	<div id="br0v_openModal" class="br0v_modalDialog">
		<div>
			<div class="br0v_modal_close">X</div>
			<h2>Preview</h2>
			<div class="br0v_modal_content"></div>
		</div>
	</div>

</div>


<div class="clear"></div>