<?php if (!defined('ABSPATH')) die('-1');

vc_add_shortcode_param( 'simple_radio', 'xyz_function' );
function xyz_function($param, $value){
if(!empty($value)){
    $hval = $value;
}
else{
    $hval = '';
}
$ret = '<input type="hidden" value="'.$hval.'" id="xyz'.$param['param_name'].'" name="'.$param['param_name'].'" class="wpb_vc_param_value wpb-input">';
foreach($param['value'] as $key => $p){
    if($value==$p){
        $checked = ' checked="checked"';
    }
    else{
        $checked = '';
    }
    $ret.='<div><input type="radio" name="xyz'.$param['param_name'].'" id="'.$param['param_name'].$p.'" value="'.$p.'" class="xyz-vc-radio'.$param['param_name'].'" style="width:auto; margin-right:5px;"'.$checked.'> <label for="'.$param['param_name'].$p.'">'.$key.'</label></div>';
}
$ret.='<script>
jQuery(".xyz-vc-radio'.$param['param_name'].'").change(function(){
    var s = jQuery(this).val();
    jQuery("#xyz'.$param['param_name'].'").val(s);
});
</script>';
return $ret;
}

