<?php


class arrecordmeta {

    function __construct() {

        add_filter('arfaddentrymeta', array(&$this, 'before_create'));
        add_action('arfaftercreateentry', array(&$this, 'create'), 10);
        add_action('arfafterupdateentry', array(&$this, 'create'));

    } 
function before_create($values){


        global $arffield;


        $field = $arffield->getOne($values['field_id']);


        if(!$field)


            return $values;


        return $values;


    }
    function create($entry){


        global $db_record, $arffield, $arfrecordmeta, $wpdb, $arfloading, $arfdetachedmedia, $armainhelper,$MdlDb;


        if (!isset($_FILES) || !is_numeric($entry)) return;


        $entry = $db_record->getOne($entry);  


        $fields = $arffield->getAll("fi.form_id='". (int)$entry->form_id ."' and (fi.type='file')");


        foreach ($fields as $field){


            $field->field_options = maybe_unserialize($field->field_options);
			
							 	
            if (isset($_FILES['file' . $field->id]) and ! empty($_FILES['file' . $field->id]['name'][0]) and (int) $_FILES['file' . $field->id]['size'][0] > 0) {


                if(!$arfloading)


                    $arfloading = true;


                $media_id = $armainhelper->upload_file('file'.$field->id,(int)$entry->form_id);

				

                if (!empty($media_id)) {

                    $new_media_ids = explode('|', $media_id);

                    $arfrecordmeta->delete_entry_meta($entry->id, $field->id);




                    $arfrecordmeta->update_entry_meta($entry->id, $field->id, $field->field_key, $media_id);



                    if (isset($_POST['item_meta'][$field->id]) && $_POST['item_meta'][$field->id] != $new_media_ids[0]){
                        $arfdetachedmedia[] = $_POST['item_meta'][$field->id];
                        $_POST['item_meta'][$field->id] = $media_id;
                    }



                }else{


                    foreach ($media_id->errors as $error)


                        echo $error[0];


                }


            }

        }


    }
	
	function wpversioninfo()
	{
		return get_bloginfo('version');
	}
	
	function getlanguage()
	{
		return get_bloginfo('language');
	}
    
  function add_entry_meta($entry_id, $field_id, $meta_key='', $entry_value){

	
    global $wpdb, $MdlDb, $fid, $check_itemid, $form_responder_fname, $form_responder_lname, $form_responderemail, $email, $fname, $lname;

	$new_values = array();


    $new_values['entry_value'] = trim($entry_value);


    $new_values['entry_id'] = $entry_id;


    $new_values['field_id'] = $field_id;


    $new_values['created_date'] = current_time('mysql', 1);


    $new_values = apply_filters('arfaddentrymeta', $new_values);


    


    $wpdb->insert( $MdlDb->entry_metas, $new_values );

		
	if($check_itemid==""){
	$result = $wpdb->get_results( $wpdb->prepare("SELECT * FROM ".$MdlDb->forms." WHERE id=%d", $fid) );
	
			if(!empty($result)) {
	
	$result = $result[0];


		$autoresponder_fname = $result->autoresponder_fname;
		
		
		$autoresponder_lname = $result->autoresponder_lname;


		$autoresponder_email = $result->autoresponder_email;


		


            if ($autoresponder_fname == $field_id) {


                $form_responder_fname = $result->autoresponder_fname;


			$fname = trim($entry_value);


		}
		
		
            if ($autoresponder_lname == $field_id) {




			$form_responder_lname = $result->autoresponder_lname;


			$lname = trim($entry_value);


		}


            if ($autoresponder_email == $field_id) {

                $form_responderemail = $result->autoresponder_email;

				$email = trim($entry_value);
            }

            $check_condition_on_subscription = true;

            $form_options = maybe_unserialize($result->options);
		}
	}
  }
  function update_entry_meta($entry_id, $field_id, $meta_key='', $entry_value,$date_format = ''){

    global $arfrecordmeta, $wpdb,$MdlDb; 

	$new_entry_value_data = '';
    
    if (!empty($entry_value) or $entry_value == '0'){

	    $fielddata	= $wpdb->get_row( $wpdb->prepare("SELECT type, options, field_options,form_id FROM ".$MdlDb->fields." WHERE id='%d'", $field_id) );
        
        $arfrecordmeta->add_entry_meta($entry_id, $field_id, $meta_key, $entry_value);

		if($fielddata && ( $fielddata->type == 'select' || $fielddata->type == 'checkbox' || $fielddata->type == 'radio' || $fielddata->type == 'arf_autocomplete' ) ){

      $options_arr = json_decode($fielddata->options,true);
      if( json_last_error() != JSON_ERROR_NONE ){
        $options_arr	= maybe_unserialize( $fielddata->options );	
      }

      $field_options = json_decode($fielddata->field_options,true);
      if( json_last_error() != JSON_ERROR_NONE){
        $field_options	= maybe_unserialize( $fielddata->field_options );
      }
      
			if( isset($field_options['separate_value']) and $field_options['separate_value'] == 1 )
			{
				$new_entry_value	= array();
				
				$entry_value	= maybe_unserialize( $entry_value );
				if( $fielddata->type == 'checkbox' ){
					if( is_array($entry_value) )
					{   
                        foreach($entry_value as $k => $field_value){
                                $new_entry_value[] = $this->find_value_in_options_with_separate_value($field_value, $options_arr,$k);
                        }
					} else {  	
                        $new_entry_value[] = $this->find_value_in_options_with_separate_value($entry_value, $options_arr, '');
					}	
				} else {
					$new_entry_value = $this->find_value_in_options($entry_value, $options_arr);
				}
				
				$new_entry_value	= maybe_serialize( $new_entry_value );
				
				$arfrecordmeta->add_entry_meta($entry_id, "-".$field_id, $meta_key, $new_entry_value);						
			}
			
		}
					
	}

  }
  
  function find_value_in_options_with_separate_value($value, $options,$key='')
  {
  	if(isset($options) && is_array($options) && $options != "" )
	{      
		foreach( $options as $k => $fieldoption )
		{
			if(isset($fieldoption) && is_array($fieldoption) && array_key_exists('value',$fieldoption))
			{       
                                if(trim($fieldoption['value']) === trim($value))
				{       
                                        return $options[$k];
                                        break;
				}	
			}
		}	
	}
	
	return array('value' => $value, 'label' => $value );			
  }
  
  
  
  function find_value_in_options($value, $options)
  {
  	if(isset($options) && is_array($options) && $options != "" )
	{      
		foreach( $options as $k => $fieldoption )
		{
			if(isset($fieldoption) && is_array($fieldoption) && array_key_exists('value',$fieldoption))
			{
				if( $fieldoption['value'] == $value )
				{
					return $fieldoption;
					break; 
				}	
			}
		}	
	}
	
	return array('value' => $value, 'label' => $value );			
  }
  
  function update_entry_metas($entry_id, $values,$date_format = ''){


    global $arffield;


    $this->delete_entry_metas($entry_id, " AND field_id != '0'");


    foreach($values as $field_id => $entry_value){

		if(is_array($values[$field_id]) and count($values[$field_id]) === 1)
                {$values[$field_id] = reset($values[$field_id]); }
					
        if(is_array($values[$field_id]))


        {$values[$field_id] = (empty($values[$field_id])) ? false : maybe_serialize($values[$field_id]);}


        $this->update_entry_meta($entry_id, $field_id, '', $values[$field_id],$date_format);


    }


  }
  
  function delete_entry_meta($entry_id, $field_id){


    global $wpdb, $MdlDb;


    $entry_id = (int)$entry_id;


    $field_id = (int)$field_id;


    return $wpdb->query( $wpdb->prepare("DELETE FROM $MdlDb->entry_metas WHERE field_id=%s AND entry_id=%s", $field_id, $entry_id) );


  }
  function delete_entry_metas($entry_id, $where=''){


    global $wpdb, $MdlDb;


    $entry_id = (int)$entry_id;


    $where = $wpdb->prepare("entry_id=%s", $entry_id). $where;


    return $wpdb->query("DELETE FROM $MdlDb->entry_metas WHERE $where");


  }
  function get_entry_meta_by_field($entry_id, $field_id, $return_var=true, $is_for_mail = false){


      global $wpdb, $MdlDb;

      $entry_id = (int)$entry_id;


      $field_id = (int)$field_id;
	  
	 $fields = $wpdb->get_results( $wpdb->prepare( "SELECT type, options, field_options FROM ".$MdlDb->fields." WHERE id = %d",$field_id ) );
	 
	 
	 

      if (is_numeric($field_id))


          $query = $wpdb->prepare("SELECT entry_value FROM $MdlDb->entry_metas WHERE field_id=%s and entry_id=%s", $field_id, $entry_id);


      else


          $query = $wpdb->prepare("SELECT entry_value FROM $MdlDb->entry_metas it LEFT OUTER JOIN $MdlDb->fields fi ON it.field_id=fi.id WHERE fi.field_key=%s and entry_id=%s", $field_id, $entry_id);


          


      if($return_var){


          $result = maybe_unserialize($wpdb->get_var("{$query} LIMIT 1"));


          $result = stripslashes_deep($result);


      }else{


          $result = $wpdb->get_col($query, 0);


      }
	  
	  if( $is_for_mail == true ){
		
		if( $fields[0]->type == 'checkbox' or $fields[0]->type == 'radio' or $fields[0]->type == 'select' ){
	  	
			$field_options = maybe_unserialize( $fields[0]->field_options );
			
			if( isset($field_options['separate_value']) && $field_options['separate_value'] == 1 ){
				
				global $wpdb,$MdlDb;
				$field_opts	= $wpdb->get_row( $wpdb->prepare("SELECT entry_value FROM ".$MdlDb->entry_metas." WHERE field_id='%d' AND entry_id='%d'", "-".$field_id, $entry_id) );
				
				if( $field_opts )
				{
					$field_opts	= maybe_unserialize($field_opts->entry_value);
					
					if( $fields[0]->type == 'checkbox' )
					{
						if( $field_opts && count($field_opts) > 0 )
						{
							$temp_value = "";
							foreach($field_opts as $new_field_opt)
							{
								$temp_value	.= $new_field_opt['label']." (".$new_field_opt['value']."), ";
							}
							$temp_value	= @trim($temp_value);
							$result		= rtrim($temp_value, ",");	
						}					
					} else {
                            if ($fields[0]->type == 'select' && $field_options['separate_value'] == 1) {
                                $label_field_id = ( $field_id * 100 );
                                $get_field_label = $wpdb->get_row($wpdb->prepare("SELECT entry_value FROM " .$MdlDb->entry_metas.' WHERE field_id = "-%d" and entry_id="%d"',$label_field_id,$entry_id));
                                $field_label = $get_field_label->entry_value;
                                if ($field_label != '') {
                                    $result = stripslashes($get_field_label->entry_value) . " (" . stripslashes($field_opts['value']) . ")";
                                } else {
                                    $result = $field_opts['label'] . " (" . $field_opts['value'] . ")";
                                }
                            } else {
                                $result = $field_opts['label'] . " (" . $field_opts['value'] . ")";
                            }
                        }
                    }
			} else {
				
				if($return_var){
	
				  $result = maybe_unserialize($wpdb->get_var("{$query} LIMIT 1"));
				  
				  $result = stripslashes_deep($result);
		
				}else{
			
				  $result = $wpdb->get_col($query, 0);
	
				}
				
			}
			
			
		  }
	  }
	 
	  
	  

      return $result;


  }
  
  function getAll($where = '', $order_by = '', $limit = '', $stripslashes = false){


    global $wpdb, $MdlDb, $arffield, $armainhelper;


    $query = "SELECT it.*, fi.type as field_type, fi.field_key as field_key, 


              fi.required as required, fi.form_id as field_form_id, fi.name as field_name, fi.options as fi_options 


              FROM $MdlDb->entry_metas it LEFT OUTER JOIN $MdlDb->fields fi ON it.field_id=fi.id" . 


              $armainhelper->prepend_and_or_where(' WHERE ', $where) . $order_by . $limit;





    if ($limit == ' LIMIT 1')


        $results = $wpdb->get_row($query);


    else    


        $results = $wpdb->get_results($query);


    


    if($results and $stripslashes){


        foreach($results as $k => $result){


            $results[$k]->entry_value = maybe_unserialize($result->entry_value);


            unset($k);


            unset($result);


        }


    }


    


    return $results;     


  }
  function getEntryIds($where = '', $order_by = '', $limit = '', $unique=true){


    global $wpdb, $MdlDb, $armainhelper;


    $query = "SELECT ";


    $query .= ($unique) ? "DISTINCT(it.entry_id)" : "it.entry_id";


    $query .= " FROM $MdlDb->entry_metas it LEFT OUTER JOIN $MdlDb->fields fi ON it.field_id=fi.id". $armainhelper->prepend_and_or_where(' WHERE ', $where) . $order_by . $limit;


    if ($limit == ' LIMIT 1')


        $results = $wpdb->get_var($query);


    else    


        $results = $wpdb->get_col($query);


    


    return $results;     


  }
  
  function &get_max($field){


        global $wpdb, $MdlDb;


        


        if(!is_object($field)){


            global $arffield;


            $field = $arffield->getOne($field);


        }


        


        if(!$field)


            return;


            


        $query = $wpdb->prepare("SELECT entry_value +0 as odr FROM $MdlDb->entry_metas WHERE field_id=%d ORDER BY odr DESC LIMIT 1", $field->id);


        $max = $wpdb->get_var($query);

        return $max;


    }
}