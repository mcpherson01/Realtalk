<?php

class leadeo_model {
	/**
	 * @var leadeo_main $main
	 */
	public $main, $last_save_mode, $last_base_id, $base_count, $data, $base_sorted;
	private $default;

	function __construct(&$main, $for) {
		$this->main=$main;
		$this->reset($for);
	}

	function reset($for) {
		$this->last_base_id=-1;
		$this->base_count=0;
		$this->base_sorted=array();
		$this->default=array(
			'id' => 0,
			'name' => '',
			'video_url' => 'https://www.youtube.com/watch?v=GMPCJeir9KU',
			'youtube_id' => '',
			'vimeo_id' => '',
			'auto_width' => 1,
			'width' => '800px',
			'auto_height' => 1,
			'height' => '700px',
			'is_youtube' => 0,
			'is_vimeo' => 0,
			'form_style' => 1,
			'font_name' => 'default',
			'font_size' => 'default',
			'font_variant' => 'regular',
			'font_subset' => 'latin',
			'_form_type' => 1,
			'_time' => '0:03',
			'_time_in_seconds' => 3,
			'_form_name' => 0,
			'_form_email' => 0,
			'_form_website' => 0,
			'_form_subject' => 0,
			'_form_message' => 0,
			'_recipients_email' => '',
			'_title_background_color' => '#E43834',
			'_form_background_color' => '#000000',
			'_font_color' => '#ffffff',
			'_font_button_color' => '#000000',
			'_button_color' => '#FCD734',
			'_border_color' => '#FFFFFF',
			'_input_font_color' => '#606060',
			'_input_background_color' => '#FFFFFF',
			'_overlay_color' => '#E43834',
			'_overlay_transparency' => 60,
			'_form_title' => 'Contact us',
			'_form_subtitle' => 'Tell us your opinion',
			'_form_link' => '#',
			'_form_text' => 'Some text goes here',
			'_button_text' => 'Click here',
			'_animation' => 'fadein_right',
			'_mailchimp_api' => '',
			'_allow_skip' => 0,
			'_seconds_to_stay_visible' => 10,
			'_auto_width' => 1,
			'_width' => '400px',
			'_auto_height' => 1,
			'_height' => '400px',
		);
		if ($for=='new') {
			$this->default['video_url'] = '';
			$this->default['_time'] = '';
			$this->default['_form_name'] = 1;
			$this->default['_form_email'] = 1;
			$this->default['_form_website'] = 1;
			$this->default['_form_subject'] = 1;
			$this->default['_form_message'] = 1;
		}
		if ($for=='edit' || $for=='load' || $for=='view') {
			$this->default['auto_width'] = 0;
			$this->default['auto_height'] = 0;
			$this->default['_auto_width'] = 0;
			$this->default['_auto_height'] = 0;
		}
		if (defined('LEADEO_LITE') && LEADEO_LITE==1) $this->default['_form_type'] = 2;
		$this->data=$this->default;
	}

	function get($var, $id=-1) {
		$search_var=$var;
		if ($id>-1) $search_var='base_'.$id.'_'.$var;
		if (isset($this->data[$search_var])) return $this->return_correct_type($this->data[$search_var]);
		if ($id>-1) $search_var='_'.$var;
		if (isset($this->default[$search_var])) return $this->return_correct_type($this->default[$search_var]);
		return null;
	}

	function return_correct_type($value) {
		if (is_integer($value)) return intval($value);
		if (is_float($value)) return floatval($value);
		return $value;
	}

	function get_all_data() {
		$arr=array();
		foreach ($this->data as $key=>$val) {
			$arr[$key]=$this->get($key);
		}
		return $arr;
	}

	function save($id, $arr, $temp=false) {
		$this->last_save_mode='';
		$data['name']='';
		if (isset($arr['title'])) {$data['name']=$arr['title']; unset($arr['title']);}
		$data['settings']=serialize($arr);

		$table=$this->main->get_plugin_table_name();
		if ($temp) {$table.='_temp'; $id=1;}

		if ($id<1) {
			$r=$this->main->db_insert_row($table, $data, array('%s', '%s'));
			if (!$r) return false;
			$this->last_save_mode='insert';
			return $this->main->db_get_insert_id();
		} else {
			$this->last_save_mode='update';
			$this->main->db_update($table, $data, array('id'=>$id), array('%s', '%s'), array('%d'));
			return $id;
		}
	}


	/**
	 * Save submited data from frontend forms
	 * @param $id
	 * @param $data
	 * @return array
	 */
	function submit($id, $data) {
		$table=$this->main->get_plugin_table_name().'_data';
		$arr=array();
		foreach($data as $var=>$val) {
			$var=stripslashes($var);
			$var=strip_tags($var);
			$val=stripslashes($val);
			$val=strip_tags($val);
			$arr[$var]=$val;
		}
		$insert=array(
			'leadeo_id' => $id,
			'data' => serialize($arr),
			'time' => time()
		);
		$this->main->db_insert_row($table, $insert, array('%s', '%s', '%s'));
		return $arr;
	}

	function delete($id) {
		$table=$this->main->get_plugin_table_name();
		return $this->main->db_query('DELETE FROM '.$table.' WHERE id='.$id);
	}

	function delete_submitted_data($id) {
		$table=$this->main->get_plugin_table_name().'_data';
		return $this->main->db_query('DELETE FROM '.$table.' WHERE id='.$id);
	}

	function duplicate($id) {
		$table=$this->main->get_plugin_table_name();
		return $this->main->db_query('INSERT INTO '.$table.' (name, settings) SELECT name, settings FROM '.$table.' WHERE id='.$id);
	}

	function list_items() {
		$table=$this->main->get_plugin_table_name();
		return $this->main->db_get_results('SELECT id, name, settings FROM '.$table." ORDER BY id ASC");
	}

	function list_submitted_data($id) {
		$table=$this->main->get_plugin_table_name().'_data';
		return $this->main->db_get_results('SELECT id, data, time FROM '.$table.' WHERE leadeo_id='.$id." ORDER BY id ASC");
	}

	function load($id, $temp=false) {
		$base_init=array();
		$table = $this->main->get_plugin_table_name();
		if ($temp) {$table.='_temp'; $id=1;}
		$row = $this->main->db_get_row('SELECT id, name, settings FROM ' . $table . ' WHERE id=' . $id);
		if (!$row) return false;
		if ($row['settings']!='') {
			$arr = unserialize($row['settings']);
			foreach ($arr as $var => $val) {
				if (substr($var,0,5)=='base_') {
					$temp=substr($var,5);
					$pos=strpos($temp, '_');
					$temp=substr($temp, 0, $pos);
					$base=intval($temp);
					if (!isset($base_init[$base])) {
						foreach ($this->default as $var2=>$val2) {
							if (substr($var2,0,1)=='_') {
								$this->data['base_'.$base.$var2] = $val2;
							}
						}
						$base_init[$base]=1;
						if ($this->last_base_id<=$base) $this->last_base_id=$base;
						$this->base_count++;
					}
				}
				$this->data[$var] = $val;
			}
		}
		$this->data['name'] = $row['name'];
		$this->data['id'] = $row['id'];
		$this->post_load();
		return true;
	}
	
	function get_css_unit($value) {
		$value=strtolower($value);
		$arr=array(
			'em',
			'ex',
			'%',
			'px',
			'cm',
			'mm',
			'in',
			'pt',
			'pc',
			'ch',
			'rem',
			'vh',
			'vw',
			'vmin',
			'vmax'
		);
		foreach ($arr as $unit) if (strpos($value, $unit)!==false) return $unit;
		return '';
	}

	function get_numerical_part_of_css_dimension ($value) {
		$unit=$this->get_css_unit($value);
		if ($unit!='') $value=str_replace($unit, '', $value);
		return intval($value);
	}
	
	function make_valid_css_dimension($value) {
		$unit=$this->get_css_unit($value);
		if ($unit!='') $value=str_replace($unit, '', $value);
		$dimension=intval($value);
		if ($unit=='') $unit='px';
		return $dimension.$unit;
	}

	/**
	 * processing loaded data
	 */
	function post_load() {
		if (strpos($this->data['video_url'], 'youtube')!==false || strpos($this->data['video_url'], 'youtu.be')!==false) {
			if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->data['video_url'], $match)) {
				$this->data['youtube_id'] = $match[1];
				$this->data['is_youtube'] = 1;
			}
		}
		if (strpos($this->data['video_url'], 'vimeo')!==false) {
			if (preg_match('/https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)/', $this->data['video_url'], $match)) {
				$this->data['vimeo_id'] = $match[3];
				$this->data['is_vimeo'] = 1;
			}
		}

		$int=$this->data['height'];
		$this->data['height_int']=$this->get_numerical_part_of_css_dimension($int);
		$this->data['height_unit']=$this->get_css_unit($int);

		$int=$this->data['width'];
		$this->data['width_int']=$this->get_numerical_part_of_css_dimension($int);
		$this->data['width_unit']=$this->get_css_unit($int);

		//if (strpos($this->data['height'], '%')===false && strpos($this->data['height'], 'px')===false) $this->data['height']=$this->data['height'].'px';
		//if (strpos($this->data['width'], '%')===false && strpos($this->data['width'], 'px')===false) $this->data['width']=$this->data['width'].'px';
		$this->data['width']=$this->make_valid_css_dimension($this->data['width']);
		$this->data['height']=$this->make_valid_css_dimension($this->data['height']);

		for ($i=0; $i<=$this->last_base_id; $i++) {
			if (!isset($this->data['base_'.$i.'_form_type'])) continue;
			$this->data['base_'.$i.'_form_type']=intval($this->data['base_'.$i.'_form_type']);
			$type=$this->data['base_'.$i.'_form_type'];

			if (strpos($this->data['base_'.$i.'_time'], ':') !== false) {
				$time = explode(':', $this->data['base_'.$i.'_time']);
				$min = intval($time[0]);
				$sec = intval($time[1]);
				$this->data['base_'.$i.'_time_in_seconds'] = ($min * 60) + $sec;
			} else {
				$this->data['base_'.$i.'_time_in_seconds'] = intval($this->data['base_'.$i.'_time']);
			}

			if (isset($this->data['base_'.$i.'_width'])) {
				$int=$this->data['base_'.$i.'_width'];
				$this->data['base_'.$i.'_width']=$this->make_valid_css_dimension($int);
				$int=$this->data['base_'.$i.'_width'];
				$this->data['base_'.$i.'_width_int']=$this->get_numerical_part_of_css_dimension($int);
				$this->data['base_'.$i.'_width_unit']=$this->get_css_unit($int);
			}
			if (isset($this->data['base_'.$i.'_height'])) {
				$int=$this->data['base_'.$i.'_height'];
				$this->data['base_'.$i.'_height']=$this->make_valid_css_dimension($int);
				$int=$this->data['base_'.$i.'_height'];
				$this->data['base_'.$i.'_height_int']=$this->get_numerical_part_of_css_dimension($int);
				$this->data['base_'.$i.'_height_unit']=$this->get_css_unit($int);
				if ($type>2) {
					$dimension = $this->data['base_' . $i . '_height'];
					$int = $this->get_numerical_part_of_css_dimension($dimension);
					$unit = $this->get_css_unit($dimension);

					if ($type==3 || $type==4) $this->data['base_' . $i . '_min_height'] = $int - 10;
					if ($type==5 || $type==6) $this->data['base_' . $i . '_min_height'] = $int - 120;
					$this->data['base_' . $i . '_min_height'] .= $unit;
				}
			}

			$this->data['base_'.$i.'_overlay_opacity'] = round(intval($this->data['base_'.$i.'_overlay_transparency']) / 100, 2);
		}

		$this->sort_forms();

	}

	function sort_forms() {
		$this->base_sorted=array();
		for ($i=0; $i<=$this->last_base_id; $i++) {
			if (!isset($this->data['base_' . $i . '_form_type'])) continue;
			$time=$this->data['base_'.$i.'_time_in_seconds'];
			if (intval($this->data['base_' . $i . '_form_type'])==6) $time=99999999;
			$this->base_sorted[]=array('id'=>$i, 'time'=>$time);
		}
		$this->main->sort_by_sub_value($this->base_sorted, 'time');
	}
}