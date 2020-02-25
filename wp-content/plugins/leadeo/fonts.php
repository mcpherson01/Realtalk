<?php

/**
 * @property leadeo_main $main_object
 */
class leadeo_fonts {
	public $assoc, $main_object;
	public $selected_type, $selected_font, $selected_variant, $selected_subset, $selected_size, $selected_color, $selected_bold, $selected_italic, $selected_underline, $selected_size_unit;
	public $available_variants, $available_subsets;

	function __construct(&$main_object) {
		$this->main_object=$main_object;
		$this->assoc=array();

		$this->reset();

		if ($this->main_object->mode=='backend') {
			$this->main_object->add_ajax_hook('leadeo_get_font_listboxes', array(&$this, 'ajax_get_font_listboxes'));
		}
	}

	function reset() {
		$this->selected_type='google';
		$this->selected_font='default';
		$this->selected_variant='regular';
		$this->selected_subset='latin';
		$this->selected_size='default';
		$this->selected_color='default';
		$this->selected_bold=0;
		$this->selected_italic=0;
		$this->selected_underline=0;
		$this->selected_size_unit='px';

		$this->available_variants=array('regular'=>'regular');
		$this->available_subsets=array('latin'=>'latin');
	}

	function set_selection($arr, $reset=TRUE) {
		if ($reset) $this->reset();
		
		if (isset($arr['type'])) $this->selected_type=$arr['type'];
		if (isset($arr['font'])) $this->selected_font=$arr['font'];
		if (isset($arr['variant'])) $this->selected_variant=$arr['variant'];
		if (isset($arr['subset'])) $this->selected_subset=$arr['subset'];
		if (isset($arr['size'])) $this->selected_size=$arr['size'];
		if (isset($arr['color'])) $this->selected_color=$arr['color'];
		if (isset($arr['bold'])) $this->selected_bold=$arr['bold'];
		if (isset($arr['italic'])) $this->selected_italic=$arr['italic'];
		if (isset($arr['underline'])) $this->selected_underline=$arr['underline'];
		if (isset($arr['size_unit'])) $this->selected_size_unit=$arr['size_unit'];
		
		if (isset($arr['font']) && $this->main_object->mode=='backend') {
			if ($this->selected_type=='google') {
				if ($this->selected_font!='default') {
					$font=$this->selected_font;
					$this->available_variants=$this->assoc[$font]['variants'];
					$this->available_subsets=$this->assoc[$font]['subsets'];
				} else {
					$this->available_variants=array('regular'=>'regular', 'italic' => 'italic', '600' => '600', '600italic' => '600italic', );
					$this->available_subsets=array('latin'=>'latin');
				}
			} else {
				$this->available_variants=array('regular'=>'regular');
				$this->available_subsets=array('latin'=>'latin');
			}
		}
	}

	function ajax_get_font_listboxes() {
		//$this->main_object->ajax_call=1;
		// $with_font_list=0;
		// if (isset($_POST['with_font_list'])) $with_font_list=intval($_POST['with_font_list']);
		$this->init_google_fonts();

		$arr=array();
		if (isset($_POST['type'])) $arr['type']=$_POST['type'];
		if (isset($_POST['font'])) $arr['font']=$_POST['font'];
		if (isset($_POST['variant'])) $arr['variant']=$_POST['variant'];
		if (isset($_POST['subset'])) $arr['subset']=$_POST['subset'];

		$this->set_selection($arr);

		if ($this->selected_type=='google') {
			//if (isset($_POST['with_font_list']) && $_POST['with_font_list']) $rarr['font_list']=$this->generate_font_listbox('font_name', $this->selected_font);
			$rarr['variant_list']=$this->generate_listbox('font_variant', $this->available_variants, $this->selected_variant);
			$rarr['variant']=$this->main_object->upper_first_letter($this->selected_variant);
			$rarr['subset_list']=$this->generate_listbox('font_subset', $this->available_subsets, $this->selected_subset);
			$rarr['subset']=$this->main_object->upper_first_letter($this->selected_subset);
			$this->main_object->ajax_return(1, $rarr);
		}
	}

	function get_font_listboxes($with_font_list=true) {
		if ($this->selected_type=='google') {
			if ($with_font_list) $rarr['font_list']=$this->generate_font_listbox('font_name', $this->selected_font);
			$rarr['variant_list']=$this->generate_listbox('font_variant', $this->available_variants, $this->selected_variant);
			$rarr['subset_list']=$this->generate_listbox('font_subset', $this->available_subsets, $this->selected_subset);
			return $rarr;
		}
	}

	function generate_font_listbox ($name, $value) {
		$buffer='<select id="'.$name.'" name="'.$name.'">';
		if ($value=='default') $selected='selected="selected" ';
		else $selected='';
		$buffer.='<option '.$selected.'value="default">Default</option>';
		foreach ($this->assoc as $var => $val) {
			if ($var==$value) $selected='selected="selected" ';
			else $selected='';
			$buffer.='<option '.$selected.'value="'.$var.'">'.$var.'</option>';
		}
		$buffer.='</select>';
		return $buffer;
	}

	function generate_listbox ($name, &$arr, $value) {
		$buffer='<select id="'.$name.'" name="'.$name.'">';
		foreach ($arr as $var => $val) {
			if ($val==$value) $selected='selected="selected" ';
			else $selected='';
			$val2=strtoupper(substr($val,0,1)).substr($val,1);
			$buffer.='<option '.$selected.'value="'.$val.'">'.$val2.'</option>';
		}
		$buffer.='</select>';
		return $buffer;
	}
	
	function get_all_css() {
		$arr=array();
		$subset_arr=array();
		if ($this->selected_font!='Default' && $this->selected_font!='default' && $this->selected_font!='') {
			$variant='400';
			$name=$this->selected_font;
			if ($this->selected_variant!='regular') $variant=$this->selected_variant;
			$subset_arr[$this->selected_subset]=$this->selected_subset;
			$arr[$name][$variant]=1;
		}
		//print_r($arr);
		$count_subset_arr=count($subset_arr);
		$subset='';
		foreach ($subset_arr as $var => $val) {
			if ($val=='latin' && $count_subset_arr==1) continue;
			if ($subset!='') $subset.=',';
			$subset.=$val;
		}
		if ($subset!='') $subset='&amp;subset='.$subset;

		if (count($arr)) {
			$fonts='';
			foreach ($arr as $font=>$sub_arr) {
				if ($fonts!='') $fonts.='|';
				$fonts.=str_replace(' ', '+', $font);
				$variants='';
				$sub_arr_count=count($sub_arr);
				foreach ($sub_arr as $var => $temp) {
					if ($var=='400' && $sub_arr_count==1) continue;
					if ($variants!='') $variants.=',';
					$variants.=$var;
				}
				if ($variants!='') $fonts.=':'.$variants;
			}
			if ($fonts!='' && $subset!='') $fonts.=$subset;
			if ($fonts!='') return "<link rel='stylesheet' id='leadeo-fonts-css'  href='http://fonts.googleapis.com/css?family=".$fonts."' type='text/css' media='all' />";
		}
		return '';
	}

	function generate_css($with_color=true) {
		$buf='';
		if ($this->selected_font!='Default' && $this->selected_font!='default' && $this->selected_font!='') {
			$buf.="font-family: '".$this->selected_font."' !important;";
		}
		if ($this->selected_size!='Default' && $this->selected_size!='default' && $this->selected_size!='') {
			$buf.="font-size: ".$this->selected_size."px !important;";
		}
		if ($this->selected_variant!='Regular' && $this->selected_variant!='regular' && $this->selected_variant!='') {
			if (strpos($this->selected_variant, 'italic')!==false) $buf.="font-style: italic !important;";
			$temp=str_replace('italic', '', $this->selected_variant);
			$temp=intval($temp);
			if ($temp>1) $buf.="font-weight: ".$temp." !important;";
		}
		if ($with_color) $buf.="color: ".$this->selected_color." !important;";
		return $buf;
	}

	function init_google_fonts() {
		if (count($this->assoc)>0) return TRUE;

		$google_fonts_ok=0;

		/*
		$fonts=$this->wrapper->get_option('all_around_google_fonts');
		if ($fonts!=FALSE) {
			if (strlen($fonts)>1000) {
				$google_fonts_num = json_decode($fonts, true);
				if (isset($google_fonts_num['items'])) $google_fonts_ok=1;
			}
		}
		*/

		if ($google_fonts_ok==0) {
			$fonts=@file_get_contents($this->main_object->path.'/fonts/fonts.txt');
			if ($fonts!=FALSE) {
				if (strlen($fonts)>1000) {
					$google_fonts_num = json_decode($fonts, true);
					if (isset($google_fonts_num['items'])) $google_fonts_ok=1;
				}
			}
		}

		if ($google_fonts_ok==0) return FALSE;

		$this->assoc = array();
		if (isset($google_fonts_num['items']) && is_array($google_fonts_num['items'])) {
			foreach($google_fonts_num['items'] as $font) {
				$this->assoc[$font['family']]=$font;
			}
			return TRUE;
		} else return FALSE;
	}
}
?>