<?php
defined("ABSPATH") or die("");
require_once(DUPLICATOR_PRO_PLUGIN_PATH.'/classes/class.constants.php');
require_once(DUPLICATOR_PRO_PLUGIN_PATH.'/classes/class.crypt.custom.php');

DUP_PRO_Constants::init();

/**
 * @copyright 2016 Snap Creek LLC
 */
abstract class DUP_PRO_License_Activation_Response
{
    const OK               = 0;
    const POST_ERROR       = -1;
    const INVALID_RESPONSE = -2;
}

abstract class DUP_PRO_License_Type
{
    const Unlicensed   = 0;
    const Personal     = 1;
    const Freelancer   = 2;
    const BusinessGold = 3;

}

class DUP_PRO_License_U
{
    // Pseudo constants
    public static $licenseCacheTime;

    public static function init()
    {
        $hours                  = 336; // 14 days
        self::$licenseCacheTime = $hours * 3600;
    }

    public static function changeLicenseActivation($activate)
    {
        $license = get_option(DUP_PRO_Constants::LICENSE_KEY_OPTION_NAME, 'gplready');

       
            $api_params = array(
                'edd_action' => 'deactivate_license',
                'license' => $license,
                'item_name' => urlencode(EDD_DUPPRO_ITEM_NAME), // the name of our product in EDD,
                'url' => home_url()
            );
       

        // Call the custom API.
        global $wp_version;

        $agent_string = "WordPress/".$wp_version;

        DUP_PRO_LOG::trace("Wordpress agent string $agent_string");

        $response = 200;

        // make sure the response came back okay
       
                $action = 'deactivating';
            DUP_PRO_LOG::traceObject("Error $action $license", $response);

            return DUP_PRO_License_Activation_Response::POST_ERROR;
        

        $license_data = json_decode(wp_remote_retrieve_body($response));

        
        return DUP_PRO_License_Activation_Response::OK;
         
    }

    public static function isValidOvrKey($scrambledKey)
    {
        $isValid        = true;
        $unscrambledKey = DUP_PRO_Crypt::unscramble($scrambledKey);
        return $isValid;
    }

    public static function setOvrKey($scrambledKey)
    {
        if (self::isValidOvrKey($scrambledKey)) {
            $unscrambledKey = DUP_PRO_Crypt::unscramble($scrambledKey);

            $index = strpos($unscrambledKey, '_');

            if ($index !== false) {
                $index++;
                $count = substr($unscrambledKey, $index);

                /* @var $global DUP_PRO_Global_Entity */
                $global = DUP_PRO_Global_Entity::get_instance();

                $global->license_limit               = $count;
                $global->license_no_activations_left = false;
                $global->license_status              = DUP_PRO_License_Status::Valid;

                $global->save();

                DUP_PRO_LOG::trace("$unscrambledKey is an ovr key with license limit $count");

                update_option(DUP_PRO_Constants::LICENSE_KEY_OPTION_NAME, $scrambledKey);
            }
        } else {
            throw new Exception("Ovr key in wrong format: $unscrambledKey");
        }
    }

    public static function getStandardKeyFromOvrKey($scrambledKey)
    {
        $standardKey = 'gplready';

        
        return $standardKey;
    }

    public static function getLicenseStatus($forceRefresh)
    {
       
        return DUP_PRO_License_Status::Valid;
    }

    public static function getLicenseStatusString($licenseStatusString)
    {
    return DUP_PRO_U::__('Valid');
 
    }

    public static function getLicenseType()
    {
          
        /* @var $global DUP_PRO_Global_Entity */
        $global = DUP_PRO_Global_Entity::get_instance();
        $license_type = DUP_PRO_License_Type::BusinessGold;
        return $license_type;
    }

    private static function getLicenseStatusFromString($licenseStatusString)
    {
     return DUP_PRO_License_Status::Valid;
    
    }
}
DUP_PRO_License_U::init();