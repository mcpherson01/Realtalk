<?php
if (!defined('ABSPATH')) {
    exit;
}


/**
 * Class WpsolAddonDisableEmojis
 */
class WpsolAddonDisableGravatar
{
    /**
     * WpsolAddonDisableGravatar constructor.
     */
    public function __construct()
    {
        $advanced_option = get_option('wpsol_advanced_settings');
        if (isset($advanced_option['disable_gravatar']) && $advanced_option['disable_gravatar']) {
            add_filter('get_avatar', array($this, 'getAvatarFilter'), 10, 5);
        }
    }

    /**
     * Filter avatar
     *
     * @param string $avatar      Avatar image
     * @param string $id_or_email Id of email of user
     * @param string $size        Sire of image
     * @param string $default     Default value
     * @param string $alt         Alt of image
     *
     * @return string
     */
    public function getAvatarFilter($avatar, $id_or_email = '', $size = '', $default = '', $alt = '')
    {
        if (self::checkHasGravatar($id_or_email)) {
            $email = $this->getEmail($id_or_email);
            if (!empty($email)) {
                $hashname = md5(strtolower(trim($email)));
                $imgAvatar = content_url() .'/uploads/wpsol-avatar/'. $hashname . '.jpg';
                if ($this->checkGravatarOnLocal($hashname)) {
                    $avatar = '<img src="'.$imgAvatar.'"';
                    $avatar .= 'alt="'.$alt.'" class="avatar avatar-'.$size;
                    $avatar .= ' wpsol-avatar wpsol-avatar-'.$size.' photo avatar-default" />';
                } else {
                    $this->pullGravatar($email, $size);
                }
            }
        }
        return $avatar;
    }

    /**
     * Pull gravatar to local
     *
     * @param string $email Email of user
     * @param string $size  Size of picture
     *
     * @return boolean
     */
    public function pullGravatar($email, $size = '')
    {
        if (is_ssl()) {
            $ssl = 'https://';
        } else {
            $ssl = 'http://';
        }
        $gravatar_url = $ssl.'www.gravatar.com/avatar/';

        // Get gravatar from url
        $hashtag = md5(strtolower(trim($email)));
        $img_url = $gravatar_url . $hashtag . '&s=' . $size;
        // Save avatar
        $this->saveImage($img_url, $hashtag);
        return true;
    }

    /**
     * Get gravatar to locally
     *
     * @param string $url         Url of image
     * @param string $fileReceive File receive
     *
     * @return void
     */
    public function saveImage($url, $fileReceive)
    {
        $fileReceive = WPSOL_UPLOAD_AVATAR . '/' . $fileReceive . '.jpg';

        if (!file_exists($fileReceive)) {
            $args = array(
                'timeout'     => 10,
                'httpversion' => '1.1',

            );
            $request = wp_remote_get($url, $args);
            if (is_wp_error($request)) {
                // phpcs:ignore WordPress.PHP.DevelopmentFunctions -- Error remote get
                error_log($request->get_error_message());
                file_put_contents($fileReceive, file_get_contents($url));
            }
            $response = wp_remote_retrieve_body($request);
            file_put_contents($fileReceive, $response);
        }
    }

    /**
     * Check avatar exist
     *
     * @param string $hashname Hashname check avatar exist
     *
     * @return boolean
     */
    public function checkGravatarOnLocal($hashname)
    {
        if (!file_exists(WPSOL_UPLOAD_AVATAR . '/' . $hashname . '.jpg')) {
            // No file, sorry
            return false;
        }
        // File exists!
        return true;
    }
    /**
     * Check if user use gravatar
     *
     * @param integer $id_or_email Id or email of user
     *
     * @return boolean
     */
    public function checkHasGravatar($id_or_email)
    {
        $email = $this->getEmail($id_or_email);

        if (empty($email)) {
            return false;
        } else {
            // Get hashname by email
            $hash = md5(strtolower(trim($email)));
            // Check gravatar exist
            $gravatar = 'http://www.gravatar.com/avatar/'.$hash.'?d=404';

            // Get cache
            $data = wp_cache_get($hash);
            // Using cache
            if (!$data) {
                $response = wp_remote_head($gravatar);
                $data = is_wp_error($response) ? 'NOT200' : $response['response']['code'];
                // Set cache
                $group = '';
                $expire = 60*5;
                wp_cache_set($hash, $data, $group, $expire);
            }

            // Return check avatar
            if ($data === 200) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Get email
     *
     * @param string $id_or_email Id or email of user
     *
     * @return string
     */
    public function getEmail($id_or_email = '')
    {
        $email = '';

        if (is_object($id_or_email)) {
            // Found user by object
            if (!empty($id_or_email->comment_author_email)) {
                $email = $id_or_email->comment_author_email;
            }
        } else {
            // Found user by ID or email
            if (is_numeric($id_or_email)) {
                $user = get_user_by('id', $id_or_email);
                $email = !empty($user) ? $user->user_email : '';
            } else {
                if (!empty($id_or_email) && $id_or_email !== 'unknown@gravatar.com') {
                    $email = $id_or_email;
                }
            }
        }

        return $email;
    }
}
