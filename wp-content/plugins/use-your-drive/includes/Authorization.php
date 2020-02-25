<?php

namespace TheLion\UseyourDrive;

class Authorization {

    /**
     * Contains the location to the token file
     * @var string 
     */
    private $_token_name;

    /**
     * Contains the file handle for the token file
     * @var type 
     */
    private $_token_file_handle = null;

    /**
     * The account id linked to this authorization
     * @var  string
     */
    private $_account_id;

    /**
     * Is the current authorization still valid or can it no longer be used
     * @var boolean
     */
    private $_is_valid = true;

    public function __construct(\TheLion\UseyourDrive\Account $_account) {
        $this->_account_id = $_account->get_id();
        $this->_token_name = Helpers::filter_filename($_account->get_email() . '_' . $_account->get_id(), false) . '.access_token';
    }

    public function set_token_name($token_name) {
        return $this->_token_name = $token_name;
    }

    public function get_token_location() {
        return USEYOURDRIVE_CACHEDIR . '/' . $this->_token_name;
    }

    public function get_access_token() {
        $this->get_lock();
        clearstatcache();
        rewind($this->get_token_file_handle());

        $filesize = filesize($this->get_token_location());
        if ($filesize > 0) {
            $token = fread($this->get_token_file_handle(), filesize($this->get_token_location()));
        } else {
            $token = '';
        }

        $this->unlock_token_file();
        if (empty($token)) {
            return null;
        }

        return $token;
    }

    public function set_access_token($_access_token) {

        /* Remove Lost Authorisation message */
        if (($timestamp = wp_next_scheduled('useyourdrive_lost_authorisation_notification', array('account_id' => $this->_account_id))) !== false) {
            wp_unschedule_event($timestamp, 'useyourdrive_lost_authorisation_notification', array('account_id' => $this->_account_id));
        }

        ftruncate($this->get_token_file_handle(), 0);
        rewind($this->get_token_file_handle());

        return fwrite($this->get_token_file_handle(), $_access_token);
    }

    public function is_valid() {
        return $this->_is_valid;
    }

    public function set_is_valid($valid = true) {
        $this->_is_valid = $valid;
    }

    public function has_access_token() {

        if ($this->is_valid() === false) {
            return false;
        }

        $access_token = $this->get_access_token();
        return (!empty($access_token));
    }

    public function get_lock($type = LOCK_SH) {

        if (!flock($this->get_token_file_handle(), $type)) {
            /*
             * If the file cannot be unlocked and the last time
             * it was modified was 1 minute, assume that 
             * the previous process died and unlock the file manually
             */
            $requires_unlock = ((filemtime($this->get_token_location()) + 60) < (time()));

            /* Temporarily workaround when flock is disabled. Can cause problems when plugin is used in multiple processes */
            if (false !== strpos(ini_get("disable_functions"), "flock")) {
                $requires_unlock = false;
            }

            if ($requires_unlock) {
                $this->unlock_token_file();
            }

            /* Try to lock the file again */
            flock($this->get_token_file_handle(), $type);
        }

        return $this->get_token_file_handle();
    }

    public function unlock_token_file() {
        $handle = $this->get_token_file_handle();
        if (!empty($handle)) {
            flock($this->get_token_file_handle(), LOCK_UN);
            fclose($this->get_token_file_handle());
            $this->set_token_file_handle(null);
        }

        clearstatcache();
        return true;
    }

    public function set_token_file_handle($handle) {
        return $this->_token_file_handle = $handle;
    }

    public function get_token_file_handle() {

        if (empty($this->_token_file_handle)) {

            /* Check Cache Folder */
            if (!file_exists($this->get_token_location())) {
                file_put_contents($this->get_token_location(), '');
            }


            /* Check if token file is writeable */
            if (!is_writable($this->get_token_location())) {
                @chmod($this->get_token_location(), 0755);

                if (!is_writable($this->get_token_location())) {
                    error_log('[Use-your-Drive message]: ' . sprintf('Token file (%s) is not writable', $this->get_token_location()));
                    die(sprintf('Cache file (%s) is not writable', $this->get_token_location()));
                }
            }

            $this->_token_file_handle = fopen($this->get_token_location(), 'c+');
            if (!is_resource($this->_token_file_handle)) {
                error_log('[Use-your-Drive message]: ' . sprintf('Token file (%s) is not writable', $this->get_token_location()));
                die(sprintf('Cache file (%s) is not writable', $this->get_token_location()));
            }
        }

        return $this->_token_file_handle;
    }

    public function set_account_id($account_id) {
        $this->_account_id = $account_id;
    }

    public function get_account_id() {
        return $this->_account_id;
    }

    public function remove_token() {
        @unlink($this->get_token_location());
    }

}
