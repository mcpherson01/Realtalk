<?php
include('Mailchimp.php');


class leadeo_mailchimp {

	public $MailChimp;

	function __construct($apikey) {
		$this -> MailChimp = new Mailchimp($apikey);
	}

	function catched_error($msg) {
		echo "Error: ".$msg."<br />\n";
	}

	function list_lists() {
		$arr=array();
		$result=array('total'=>0);
		try {
			$result = $this -> MailChimp->lists->getList();
		} catch (Exception $e) {$this->catched_error($e->getMessage()); return $arr;}
		//echo '<pre>';print_r($result);echo '</pre>';exit;
		$i=0;
		if ($result['total']>0) {
			foreach ($result['data'] as $temp) {
				$sub_array=array();
				if (isset($temp['stats']) && isset($temp['stats']['grouping_count']) && intval($temp['stats']['grouping_count'])>0) $sub_array=$this->list_groups($temp['id']);
				$arr[$i]=array(
					'id' => $temp['id'],
					'name' => $temp['name'],
					'groups_count' => count($sub_array),
					'groups' => $sub_array
				);
				$i++;
			}
		}
		return $arr;
	}

	function list_groups($list_id) {
		$arr=array();
		$result=array();
		try {
			$result = $this -> MailChimp->lists->interestGroupings($list_id);
		} catch (Exception $e) {$this->catched_error($e->getMessage()); return $arr;}
		//echo '<pre>';print_r($result);echo '</pre>';exit;
		foreach ($result as $i => $group) {
			$subgroups=array();
			foreach ($group['groups'] as $j => $subgroup) {
				$subgroup_temp=array(
					'id' => $subgroup['id'],
					'bit' => $subgroup['bit'],
					'name' => $subgroup['name']
				);
				$subgroups[]=$subgroup_temp;
			}
			$group_arr=array(
				'id' => $group['id'],
				'name' => $group['name'],
				'form_field' => $group['form_field'],	// checkbox, radio, select (radio and select are 'just one choice')
				'options' => $subgroups
			);
			$arr[]=$group_arr;
		}
		return $arr;

	}

	function subscribe($email, $list_id, $merge_vars=false, $FNAME='', $LNAME='') {
		if ($merge_vars===false) $merge_vars=array();
		if ($FNAME!='') $merge_vars['FNAME']=$FNAME;
		if ($LNAME!='') $merge_vars['LNAME']=$LNAME;
		$result=false;
		try {
			$result = $this->MailChimp->lists->subscribe(
				$list_id,
				array('email'=>$email),
				$merge_vars,
				'html',
				false,	// double opt-in
				true,	// update existing
				false,	// replace interests
				true	// send welcome
			);
		} catch (Exception $e) {$this->catched_error($e->getMessage()); return false;}
		//print_r($result); exit;
		if ($result==false) return false;
		if (isset($result['error'])) return false;
		if (isset($result['euid'])) return true;
		return false;
	}
}
?>