<?php

function pcit_default_tab() {

global $uid, $wid, $textarea;

$i = 'individual_ids';
$c = 'code_integration';

	if ((isset($_GET['tab'])) && ($_GET['tab'] != $i) && ($_GET['tab'] != $c)) {
		if (($uid != false) && ($wid != false)) {
			return $i;
		} elseif (($textarea) != false) {
			return $c;
		} elseif ((!$uid) && (!$wid) && (!$textarea)) {
			return $i;
		}
	} else {
		return ((isset($_GET['tab']))) ? $_GET['tab'] : 'individual_ids';
	}
}

function pcit_logo() {
	$logo = "<img class='center-block' style='padding-top:5px; padding-bottom:20px' src='".plugins_url( 'images/logo.png', __FILE__ ). "'/>";
	return $logo;
}

function pcit_code_disabled() { 
	if (get_option('popcash_net_disabled') == true) { ?>

<ul>
  <li class="list-group-item list-group-item-danger">PopCash.Net Popunder code is currently disabled for your website. Click <a href="admin.php?page=popcash-net&tab=<?php echo htmlentities((isset($_GET['tab']) ? $_GET['tab'] : 'individual_ids')) ?>&d_status=switch">here</a> to enable it!
  </li>
</ul>

<?php }

} 

function pcit_switch_enabled() {

	$setting = "popcash_net_disabled";
	$a = "admin.php?page=popcash-net&tab=";
  $i = 'individual_ids';
  $c = 'code_integration';

	if (isset($_GET['tab']) && ($_GET['tab'] != $i) && ($_GET['tab'] != $c)) {
		$a .= $_GET['tab'];
	} else {
		$a .= 'individual_ids';
	}
	
	if (isset($_GET['d_status'])){
		if ($_GET['d_status'] == 'switch') {
			if (get_option('popcash_net_disabled') == false) {
				update_option('popcash_net_disabled', true);
				$message = "Popunder code successfully disabled!";
			} else {
				update_option('popcash_net_disabled', false);
				$message = "Popunder code successfully enabled!";
			}
			wp_redirect($a);
			exit;
		}
	}
}

function pcit_add_individual_ids() {
	global $uid, $wid;
?>
<!-- Start PopCash.Net Popunder Script -->
<script type="text/javascript">
var uid = '<?php echo $uid ?>';
var wid = '<?php echo $wid ?>';
</script>
<script type="text/javascript" src="//cdn.popcash.net/pop.js"></script>
<!-- End PopCash.Net Popunder Script -->
<?php
}

function pcit_add_textarea() {
	global $textarea;
	echo "<!-- Start PopCash.Net Popunder Script -->\n$textarea\n<!-- End PopCash.Net Popunder Script -->\n\n";
}

function pcit_uid_validation($uid){
	$setting = 'popcash_net_uid';
	if (preg_match("/^[0-9]+$/", $uid)) {
		return $uid;
	} else {
		$message = 'User ID isn\'t properly formatted';
		add_settings_error($setting, 'uid-error', $message, 'error');
		return false;
	}
}

function pcit_wid_validation($wid){
	$setting = 'popcash_net_wid';
	if (preg_match("/^[0-9]+$/", $wid)) {
		return $wid;
	} else {
		$message = 'Website ID isn\'t properly formatted';
		add_settings_error($setting, 'wid-error', $message, 'error');
		return false;
	}
}

function pcit_popcash_net_publisher_code() {
include 'template.php';
}