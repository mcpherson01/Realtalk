<?php

require_once dirname(__FILE__) . '/jsonRPCClient.php';
global $MdlDb ;

$res = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->autoresponder." WHERE responder_id=%d",4));
$res = $res[0];

$data = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $MdlDb->ar." WHERE frm_id = %d", $fid), 'ARRAY_A');

$arr_getresponse = unserialize($data[0]['getresponse']);

	$responder_api_key = @$arr_getresponse['type_val'];
	
	//$campaignName = $res->responder_list_id;
        
        $campaignName = @$arr_getresponse['type_val'];

$subscriberName = $fname . " " . $lname;

$subscriberEmail = $email;

$api_key = $res->responder_api_key; //Place API key here
$api_url = 'http://api2.getresponse.com';

# initialize JSON-RPC client
$client = new jsonRPCClient($api_url);

$add_to_contact_array = array();

if ($campaignName != '') {

    $result2 = $client->get_campaigns(
            $api_key, array(
        'name' => array('EQUALS' => $campaignName)
            )
    );

    $res = array_keys($result2);
    $CAMPAIGN_IDs = array_pop($res);



    try {
        $response = $client->get_messages(
                $api_key, array(
            'campaigns' => array($CAMPAIGN_IDs)
                )
        );
        $day_of_cycle = '';

        if (!empty($response)) {
            foreach ($response as $res) {

                if ($res['campaign'] == $CAMPAIGN_IDs and $res['based_on'] == 'time') {
                    $day_of_cycle = $res['day_of_cycle'];
                }
            }
        }
        if ($day_of_cycle >= 0) {
            $add_to_contact_array = array(
                'campaign' => $CAMPAIGN_IDs,
                'name' => $subscriberName,
                'email' => $subscriberEmail,
                'cycle_day' => $day_of_cycle,
            );
        } else {
            $add_to_contact_array = array(
                'campaign' => $CAMPAIGN_IDs,
                'name' => $subscriberName,
                'email' => $subscriberEmail,
            );
        }
    } catch (Exception $e) {
        //echo $e->getMessage();
        //exit;
        $add_to_contact_array = array(
            'campaign' => $CAMPAIGN_IDs,
            'name' => $subscriberName,
            'email' => $subscriberEmail,
        );
    }



    //exit;
    // Add contact to selected campaign id
    try {
        $result_contact = $client->add_contact(
                $api_key, $add_to_contact_array
        );
        //echo "<pre>";print_r($result_contact);
        //echo "<p style='color: blue; font-size:24px;'> Contact Added </p>";
        //exit;
    } catch (Exception $e) {

        //echo $e->getMessage();
        //exit;
    }
}
?>