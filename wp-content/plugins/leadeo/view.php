<?php

/**
 * @property leadeo_main $main
 * @property leadeo_model $model
 */
class leadeo_view {
	public $main, $model, $pre_script;

	function __construct(&$main, &$model) {
		$this->main = $main;
		$this->model = $model;
		$this->pre_script=0;
	}

	/*
	 function header_function($arr) {}

	function replace_once_from_left_to_right_including_borders($text, $left, $right, $replace_with) {
		$pos1=strpos($text, $left);
		if ($pos1===false) return $text;
		$pos2=strpos($text, $right, $pos1+strlen($left));
		if ($pos2===false) return $text;
		return substr($text, 0, $pos1).$replace_with.substr($text, $pos2+strlen($right));
	}
	function replace_last_from_left_to_right_including_borders($text, $left, $right, $replace_with) {
		$pos1=strrpos($text, $left);
		if ($pos1===false) return $text;
		$pos2=strpos($text, $right, $pos1+strlen($left));
		if ($pos2===false) return $text;
		return substr($text, 0, $pos1).$replace_with.substr($text, $pos2+strlen($right));
	}
	*/
	function replace_last($text, $find, $replace_with) {
		$pos1=strrpos($text, $find);
		if ($pos1===false) return $text;
		return substr_replace($text, $replace_with, $pos1, strlen($find));
	}

	function strip_once_from_left_to_right_including_borders($text, $left, $right) {
		$pos1=strpos($text, $left);
		if ($pos1===false) return $text;
		$pos2=strpos($text, $right, $pos1+strlen($left));
		if ($pos2===false) return $text;
		return substr($text, 0, $pos1).substr($text, $pos2+strlen($right));
	}

	function strip_and_get_once_from_left_to_right_including_borders(&$text, $left, $right, &$stripped) {
		$pos1=strpos($text, $left);
		if ($pos1===false) return $text;
		$pos2=strpos($text, $right, $pos1+strlen($left));
		if ($pos2===false) return $text;
		$stripped=substr($text,$pos1, ($pos2-$pos1)+strlen($right));
		$text=substr($text, 0, $pos1).substr($text, $pos2+strlen($right));
		return $text;
	}

	function strip_from_left_to_right_including_borders($text, $left, $right) {
		while (true) {
			$pos1=strpos($text, $left);
			if ($pos1===false) return $text;
			$pos2=strpos($text, $right, $pos1+strlen($left));
			if ($pos2===false) return $text;
			$text=substr($text, 0, $pos1).substr($text, $pos2+strlen($right));
		}
	}

	function get_html_attribute($html, $var) {
		$pos1=strpos($html, $var);
		if ($pos1===false) return false;
		$pos2=strpos($html, '=', $pos1);
		if ($pos2===false) return false;
		$pos3a=strpos($html, "'", $pos2);
		$pos3b=strpos($html, '"', $pos2);
		if ($pos3a===false && $pos3b===false) return false;
		if ($pos3a===false) $pos3a=1000;
		if ($pos3b===false) $pos3b=1000;
		if ($pos3a<$pos3b) {$c="'"; $pos3=$pos3a;}
		else {$c='"'; $pos3=$pos3b;}
		if ($pos3>999) false;
		$pos4=strpos($html, $c, $pos3+1);
		if ($pos4===false) return false;
		return substr($html, $pos3+1, $pos4-$pos3-1);
	}

	// --------------------------

	function generate_html_from_shortcode($id) {
		//echo "load ".$id;
		$this->model->load($id);
		$auto_width=intval($this->model->get('auto_width'));
		$auto_height=intval($this->model->get('auto_height'));
		$width=$this->model->get('width');
		$height=$this->model->get('height');

		$style='';
		$calculate_height=0;
		if ($auto_width) $style.='width: 100%; ';
		else {
			$style.='width: '.$width.'; ';
			$calculate_height=1;
		}
		$ratio=1.641;
		if (isset($this->model->data['is_vimeo']) && $this->model->data['is_vimeo']==1) $ratio=1.779;
		if ($calculate_height && $auto_height) {
			$auto_height=0;
			$height=intval($this->model->data['width_int'])/$ratio;
			$height.=$this->model->data['width_unit'];
		}
		$url=$this->main->get_ajax_url().'?action=get_leadeo_iframe_source&id='.$id;
		$pre_script='';
		$script='';
		if (!$auto_height) $style.='height: '.$height.';';
		else {
			if ($this->pre_script==0) {
				$this->pre_script = 1;
				$js_url = $this->main->url . 'js/docready.js';
				$pre_script = "<script type='text/javascript' src='" . $js_url . "'></script>";
			}
		$script='
<script>
docReady(function() {
	var leadeo_width=document.getElementById("leadeo_iframe_'.$id.'").offsetWidth;
	var leadeo_height=Math.round(leadeo_width/'.$ratio.');
	document.getElementById("leadeo_iframe_'.$id.'").style.height=leadeo_height+"px";
});
</script>';
		}
		return $pre_script.'<iframe id="leadeo_iframe_'.$id.'" class="leadeo_iframe" src="'.$url.'" style="'.$style.'" allowtransparency="true" frameborder="0" scrolling="no" data-resized="0"></iframe>'.$script;
	}

	function get_iframe_source($id, $temp=false) {
		$buf='';
		$this->main->mode='frontend';
		$plugin_url=$this->main->url;
		$this->model->load($id, $temp);
		$this->main->init_fonts();
		$this->main->set_fonts();
		//$buf = 'iframe source '.$id."<br />".$plugin_url;
		$replace_table=$this->model->get_all_data();
		//echo '<pre>'; print_r($replace_table); echo '</pre>'; exit;
		//if (intval($replace_table['base_0_form_type'])==1) $path='contact'.$replace_table['form_style'];
		//else $path='opt'.$replace_table['form_style'];
		$path='default';
		if ($this->model->get('form_style')==2) $path='highway';

		$form_full_file_path = dirname(__FILE__) . '/forms/' . $path . '/index.html';
		$form_full_url_path = $plugin_url . 'forms/' . $path . '/';
		if (file_exists($form_full_file_path)) {
			$buf = file_get_contents($form_full_file_path);
			$buf = $this->forms_preprocess($buf, $form_full_url_path, $plugin_url, $replace_table, $temp);
		}

		return $buf;
	}

	function generate_timeline() {
		/*
		 *  var a=[];
			a[0]={id: 1, time: 7};
		 */
		$output="var timeline = [];\n";
		$i=0;
		if ($this->model->base_count==0) {
			$output.="	var data_time_in_seconds=-1;\n	var data_animation='fadein_right';";
			return $output;
		}
		$add=0;
		$last_end=-1;
		foreach ($this->model->base_sorted as $order => $arr ) {
			$id=$arr['id'];
			$time=intval($arr['time']);
			$animation=$this->model->get('animation', $arr['id']);
			$auto_height=intval($this->model->get('auto_height', $arr['id']));
			$height_int=intval($this->model->get('height_int', $arr['id']));
			$height_unit=$this->model->get('height_unit', $arr['id']);
			$type=intval($this->model->get('form_type', $arr['id']));
			$seconds_to_stay_visible=intval($this->model->get('seconds_to_stay_visible', $arr['id']));

			//$rtime=$time;
			$time+=$add;
			if ($time<=$last_end) {
				$dif=$last_end-$time;
				$add+=$dif+1;
				//echo $i.": rtime = ".$rtime.", time = ".$time.", last_end = ".$last_end.", dif = ".$dif.", add = ".$add."\n";
				$time+=$dif+1;
			}

			if ($type==3 || $type==4) $last_end=$time+$seconds_to_stay_visible;
			$output.="	timeline[".$i."]={id: ".$id.", time: ".$time.", type: ".$type.", animation: '".$animation."', seconds_to_stay_visible: ".$seconds_to_stay_visible.", auto_height: ".$auto_height.", height_int: ".$height_int.", height_unit: '".$height_unit."'};\n";
			$i++;
		}
		$output.="	var data_time_in_seconds=timeline[0].time;\n";
		$output.="	var data_animation=timeline[0].animation;";
		return $output;
	}

	function forms_preprocess($buf, $form_folder_url, $plugin_folder_url, $replace_table, $temp=false) {
		$buf=str_replace('href="./', 'href="'.$form_folder_url, $buf);
		$buf=str_replace('href = "./', 'href = "'.$form_folder_url, $buf);
		$buf=str_replace('src="./', 'src="'.$form_folder_url, $buf);
		$buf=str_replace('src = "./', 'src = "'.$form_folder_url, $buf);

		$buf=str_replace("href='./", "href='".$form_folder_url, $buf);
		$buf=str_replace("href = './", "href = '".$form_folder_url, $buf);
		$buf=str_replace("src='./", "src='".$form_folder_url, $buf);
		$buf=str_replace("src = './", "src = '".$form_folder_url, $buf);

		$replace_with='<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script><link rel="stylesheet" type="text/css" href="'.$plugin_folder_url.'forms/dialogs/style.css" />';
		$replace_with.=$this->main->fonts->get_all_css();
		$buf=str_replace('<!-- header_place -->', $replace_with, $buf);

		$buf=str_replace('[data:ajaxurl]', $this->main->get_ajax_url(), $buf);

		$buf=str_replace('[plugin_folder_url]', $plugin_folder_url, $buf);
		$buf=str_replace('[data:is_preview]', intval($temp), $buf);

		$buf=str_replace('[data:timeline]', $this->generate_timeline(), $buf);

		$form1=file_get_contents(dirname(__FILE__) . '/forms/dialogs/open-link-dialog.html');
		$buf=str_replace('<!-- dialogs -->', "<!-- dialogs -->\n".$form1, $buf);
		$form2=file_get_contents(dirname(__FILE__) . '/forms/dialogs/share-a-quote-dialog.html');
		$buf=str_replace('<!-- dialogs -->', "<!-- dialogs -->\n".$form2, $buf);
		$form3=file_get_contents(dirname(__FILE__) . '/forms/dialogs/share-to-watch-dialog.html');
		$buf=str_replace('<!-- dialogs -->', "<!-- dialogs -->\n".$form3, $buf);
		$form4=file_get_contents(dirname(__FILE__) . '/forms/dialogs/thank-you-for-watching-dialog.html');
		$buf=str_replace('<!-- dialogs -->', "<!-- dialogs -->\n".$form4, $buf);

		$forms=array();
		while (1) {
			if (strpos($buf, '<div id="base_X"')===false) break;
			$form='';
			$this->strip_and_get_once_from_left_to_right_including_borders($buf, '<div id="base_X"', '<!-- /base_X -->', $form);
			if ($form=='') break;
			$type=$this->get_html_attribute($form, 'class');
			$type=substr($type, 5);
			if (strpos($type, ' ')!==false) $type=substr($type, 0, strpos($type, ' '));
			$forms[$type]=$form;
		}

		$replace_font_css=$this->main->fonts->generate_css(false);
		$replace_button_font_css=$this->main->fonts->generate_css(false);

		foreach ($this->model->base_sorted as $order => $arr ) {
			$id = $arr['id'];
			//$time = $arr['time'];
			$type = $this->model->get('form_type', $id);
			$type_name='';
			if ($type==1) $type_name='contact';
			if ($type==2) $type_name='opt';
			if ($type==3) $type_name='open_dialog';
			if ($type==4) $type_name='share_dialog';
			if ($type==5) $type_name='watch_dialog';
			if ($type==6) $type_name='thank_dialog';
			if ($type_name=='') continue;
			$form_buf=$forms[$type_name];
			if ($type == 1) {
				$deleted = 0;
				if ($this->model->get('form_name', $id) == 0) {
					$form_buf = $this->strip_once_from_left_to_right_including_borders($form_buf, '<div id="leadeo_name"', '</div>');
					$deleted++;
				}
				if ($this->model->get('form_email', $id) == 0) {
					$form_buf = $this->strip_once_from_left_to_right_including_borders($form_buf, '<div id="leadeo_email"', '</div>');
					$deleted++;
				}
				if ($this->model->get('form_website', $id) == 0) {
					$form_buf = $this->strip_once_from_left_to_right_including_borders($form_buf, '<div id="leadeo_website"', '</div>');
					$deleted++;
				}
				if ($this->model->get('form_subject', $id) == 0) {
					$form_buf = $this->strip_once_from_left_to_right_including_borders($form_buf, '<div id="leadeo_subject"', '</div>');
					$deleted++;
				}
				if ($this->model->get('form_message', $id) == 0) {
					$form_buf = $this->strip_once_from_left_to_right_including_borders($form_buf, '<span id="leadeo_message"', '</span>');
					$form_buf = $this->strip_once_from_left_to_right_including_borders($form_buf, '<div id="leadeo_message"', '</div>');
				}
				if ($deleted == 1 || $deleted == 3) {
					$form_buf = $this->replace_last($form_buf, 'col-md-6', 'col-md-12');
				}
				if ($this->model->get('auto_width', $id)==0 &&
					(
						($this->model->get('width_unit', $id)=='px' && $this->model->get('width_int', $id)<401) ||
						($this->model->get('width_unit', $id)=='%' && $this->model->get('width_int', $id)<50)
					)
				) {
					$form_buf = str_replace('col-md-6', 'col-md-12', $form_buf);
				}

			}
			if ($this->model->get('allow_skip', $id)==0) $form_buf = $this->strip_from_left_to_right_including_borders($form_buf, '<!-- IF allow_skip -->', '<!-- /IF allow_skip -->');
			if ($this->model->get('auto_width', $id)==1) $form_buf = $this->strip_from_left_to_right_including_borders($form_buf, '<!-- IF fixed_width -->', '<!-- /IF fixed_width -->');
			else $this->strip_from_left_to_right_including_borders($form_buf, '<!-- IF auto_width -->', '<!-- /IF auto_width -->');
			if ($this->model->get('auto_height', $id)==1) $form_buf = $this->strip_from_left_to_right_including_borders($form_buf, '<!-- IF fixed_height -->', '<!-- /IF fixed_height -->');
			else $form_buf = $this->strip_from_left_to_right_including_borders($form_buf, '<!-- IF auto_height -->', '<!-- /IF auto_height -->');
			$form_buf=str_replace('<!-- IF allow_skip -->', '', $form_buf);
			$form_buf=str_replace('<!-- /IF allow_skip -->', '', $form_buf);
			$form_buf=str_replace('<!-- IF fixed_width -->', '', $form_buf);
			$form_buf=str_replace('<!-- /IF fixed_width -->', '', $form_buf);
			$form_buf=str_replace('<!-- IF fixed_height -->', '', $form_buf);
			$form_buf=str_replace('<!-- /IF fixed_height -->', '', $form_buf);
			$form_buf=str_replace('<!-- IF auto_width -->', '', $form_buf);
			$form_buf=str_replace('<!-- /IF auto_width -->', '', $form_buf);
			$form_buf=str_replace('<!-- IF auto_height -->', '', $form_buf);
			$form_buf=str_replace('<!-- /IF auto_height -->', '', $form_buf);

			$form_buf=str_replace('<div id="base_X"', '<div xd="base_x"', $form_buf);
			$form_buf=str_replace('base_X', 'base_'.$order, $form_buf);
			$form_buf=str_replace('data-real-base-number="', 'data-real-base-number="'.$id, $form_buf);
			$form_buf=str_replace('id="', 'id="base_'.$order.'_', $form_buf);
			$form_buf=str_replace('id = "', 'id = "base_'.$order.'_', $form_buf);
			$form_buf=str_replace('<div xd="base_x"', '<div id="base_'.$order.'"', $form_buf);
			if (isset($replace_table['base_'.$id.'_form_link'])) {
				if (substr($replace_table['base_' . $id . '_form_link'], 0, 3) == 'www') $replace_table['base_' . $id . '_form_link'] = 'http://' . $replace_table['base_' . $id . '_form_link'];
				if (substr($replace_table['base_' . $id . '_form_link'], 0, 4) == 'http') $replace_table['base_' . $id . '_form_text'] = '<a href="'.$replace_table['base_' . $id . '_form_link'].'" target="_blank">'.$replace_table['base_' . $id . '_form_text'].'</a>';
			}
			foreach ($replace_table as $key => $val) {
				if (substr($key,0,1)=='_') continue;
				$looking_for='base_'.$id.'_';
				$looking_for_len=strlen($looking_for);
				if (substr($key,0,$looking_for_len)!=$looking_for) continue;
				$key=substr($key, $looking_for_len);
				//echo "order=".$order.", id: ".$id, ", looking_for=".$looking_for.", key=".$key."\n";
				$form_buf=str_replace('[data:'.$key.']', $val, $form_buf);
			}
			$form_buf=str_replace('[data:id]', $replace_table['id'], $form_buf);
			$form_buf=str_replace('[data:font_css]', $replace_font_css, $form_buf);
			$form_buf=str_replace('[data:button_font_css]', $replace_button_font_css, $form_buf);

			$buf=str_replace('<!-- forms -->', "<!-- forms -->\n".$form_buf, $buf);
		}

		if (intval($replace_table['is_youtube'])==1) {
			$buf=$this->strip_from_left_to_right_including_borders($buf, '<!-- IF vimeo -->', '<!-- /IF vimeo -->');
			$buf=str_replace('<!-- IF youtube -->', '', $buf);
			$buf=str_replace('<!-- /IF youtube -->', '', $buf);
		}
		if (intval($replace_table['is_vimeo'])==1) {
			$buf=$this->strip_from_left_to_right_including_borders($buf, '<!-- IF youtube -->', '<!-- /IF youtube -->');
			$buf=str_replace('<!-- IF vimeo -->', '', $buf);
			$buf=str_replace('<!-- /IF vimeo -->', '', $buf);
		}
		if (intval($replace_table['is_youtube'])==0 && intval($replace_table['is_vimeo'])==0) {
			$buf=$this->strip_from_left_to_right_including_borders($buf, '<!-- IF vimeo -->', '<!-- /IF vimeo -->');
			$buf=$this->strip_from_left_to_right_including_borders($buf, '<!-- IF youtube -->', '<!-- /IF youtube -->');
		}
		if (!defined('LEADEO_LITE') || (defined('LEADEO_LITE') && LEADEO_LITE==0)) {
			$buf = $this->strip_from_left_to_right_including_borders($buf, '<!-- IF leadeo_lite -->', '<!-- /IF leadeo_lite -->');
		}
		foreach ($replace_table as $key => $val) {
			if (substr($key,0,5)=='base_' || substr($key,0,1)=='_') continue;
			$buf=str_replace('[data:'.$key.']', $val, $buf);
		}

		return $buf;
	}
}