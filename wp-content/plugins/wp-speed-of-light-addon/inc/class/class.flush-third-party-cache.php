<?php
if (!defined('ABSPATH')) {
    exit;
}


/**
 * Class WpsolAddonFlushThirdPartyCache
 */
class WpsolAddonFlushThirdPartyCache
{
    /**
     * Init third party params
     *
     * @var array
     */
    private $third_party = array();
    /**
     * Init error message params
     *
     * @var array
     */
    private $error_message = array();

    /**
     * WpsolAddonFlushThirdPartyCache constructor.
     */
    public function __construct()
    {
        $configuration = get_option('wpsol_cdn_integration');
        if (!empty($configuration['third_parts'])) {
            $this->third_party = $configuration['third_parts'];
        }
    }

    /**
     * Execute purge third party
     *
     * @return array|boolean
     */
    public function runPurgeThirdparty()
    {
        if (empty($this->third_party)) {
            return false;
        }
        foreach ($this->third_party as $third_party) {
            $third = str_replace('-cache', '', $third_party);
            // Call function bellow class to purge cache
            $this->error_message[] = call_user_func(array($this, 'purge' . $third . 'cache'));
        }

        return $this->error_message;
    }

    /**
     * Key CDN cache
     *
     * @return boolean|string
     */
    public function purgekeycdncache()
    {
        // Get authorization
        $params = get_option('wpsol_addon_author_key_cdn');

        if (empty($params) || empty($params['authorization']) || empty($params['zone'])) {
            return 'Empty field !';
        }
        // Get api
        require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/cache-library-api/KeyCDN.php');
        $keyCDN = new KeyCDN($params['authorization']);

        // Get zone ids
        $zone_ids = explode(',', trim($params['zone']));

        $error_flush = '';

        foreach ($zone_ids as $zone_id) {
            //Using API keycdn to purge zone id
            //https://www.keycdn.com/api
            $execute = $keyCDN->get('zones/purge/' . $zone_id . '.json');
            $execute = json_decode($execute);

            if (is_null($execute) || $execute->status !== 'success') {
                $error_flush = 'KeyCDN Cache: ' . $execute->description;
                continue;
            }
        }

        if (empty($error_flush)) {
            return true;
        }

        return $error_flush;
    }

    /**
     * Key CDN cache
     *
     * @return boolean|string
     */
    public function purgemaxcdncache()
    {
        // Get authorization
        $params = get_option('wpsol_addon_author_max_cdn');

        if (empty($params) || empty($params['consumer-key']) ||
            empty($params['consumer-secret']) || empty($params['alias']) || empty($params['zone'])) {
            return 'Empty field !';
        }

        // Get api
        require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/cache-library-api/NetDNA.php');
        $maxCDN = new NetDNA(trim($params['alias']), trim($params['consumer-key']), trim($params['consumer-secret']));

        $zones = explode(',', $params['zone']);
        $error_flush = '';
        foreach ($zones as $zone) {
            // Using API to delete site cache by site id
            //https://api.stackpath.com/
            $api_call = json_decode($maxCDN->delete('/sites/' . $zone . '/cache'));

            if ($api_call->code !== 200 || isset($api_call->error)) {
                // Display error messages
                $error_flush = 'MaxCDN Cache: ' . $api_call->error->message;
                continue;
            }
        }
        if (!empty($error_flush)) {
            return $error_flush;
        }

        return true;
    }

    /**
     * Varnish cache flush service
     *
     * @return boolean|string
     */
    public function purgevarnishcache()
    {

        $parseUrl = parse_url(home_url() . '/?wpsol');
        $pregex = '';

        // Default method is URLPURGE to purge only one object, this method is specific to configuration
        $purge_method = 'URLPURGE';

        // Use PURGE method when purging all site
        if (isset($parseUrl['query']) && ($parseUrl['query'] === 'wpsol')) {
            // The regex is not needed as configuration purge all the cache of the domain when a PURGE is done
            $pregex = '.*';
            $purge_method = 'PURGE';
        }

        // Determine the path
        $path = '';
        if (isset($parseUrl['path'])) {
            $path = $parseUrl['path'];
        }

        // Determine the schema
        $schema = 'http://';
        if (isset($parseUrl['scheme'])) {
            $schema = $parseUrl['scheme'] . '://';
        }

        // Determine the host
        $host = $parseUrl['host'];

        $config = get_option('wpsol_addon_varnish_ip');
        $varnish_host = isset($config['ip']) ? $config['ip'] : '127.0.0.1';

        $purgeme = $varnish_host . $path . $pregex;

        if (!empty($parseUrl['query']) && $parseUrl['query'] !== 'wpsol') {
            $purgeme .= '?' . $parseUrl['query'];
        }

        $request_args = array('method' => $purge_method,
            'headers' => array('Host' => $host,
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) 
            Chrome/58.0.3029.110 Safari/537.36'),
            'sslverify' => false);
        $response = wp_remote_request($schema . $purgeme, $request_args);

        if (is_wp_error($response) || $response['response']['code'] !== '200') {
            if ($schema === 'https://') {
                $schema = 'http://';
            } else {
                $schema = 'https://';
            }
            $response = wp_remote_request($schema . $purgeme, $request_args);

            $error_flush = 'Varnish Cache: Failed to connect to server ip!';

            if (isset($response->errors) && isset($response->errors['http_request_failed'])) {
                $error_flush = 'Varnish Cache: ' . $response->errors['http_request_failed'][0];
            }
            return $error_flush;
        }

        return true;
    }

    /**
     * Key Cloudflare cache
     *
     * @return boolean|string
     */
    public function purgecloudflarecache()
    {
        // Get authorization
        $params = get_option('wpsol_addon_author_cloudflare');

        if (empty($params) || empty($params['username']) || empty($params['key']) || empty($params['domain'])) {
            return 'Empty field !';
        }

        // Get api
        require_once(WPSOL_ADDON_PLUGIN_DIR . 'inc/cache-library-api/CloudFlare.php');
        $cloudFlare = new CloudFlare(trim($params['username']), trim($params['key']));

        // Get zone ids
        $domains = explode(',', trim($params['domain']));

        $error_flush = '';

        foreach ($domains as $domain) {
            //Use API to purge domain cache
            $execute = json_decode($cloudFlare->purge($domain));
            if (is_null($execute) || $execute->result === 'error') {
                // Return error message
                $error_flush = 'CloudFlare Cache: ' . $execute->msg;
                continue;
            }
        }

        if (!empty($error_flush)) {
            return $error_flush;
        }
        return true;
    }
    /**
     * Key SiteGround cache
     *
     * @return boolean|string
     */
    public function purgesitegroundcache()
    {

        $purgeRequest = parse_url(home_url(), PHP_URL_PATH) . '/(.*)';
        $sgcache_ip = '/etc/sgcache_ip';
        $hostname = $_SERVER['SERVER_ADDR'];
        $purge_method = 'PURGE';

        // Check if caching server is varnish
        if (file_exists($sgcache_ip)) {
            $hostname = trim(file_get_contents($sgcache_ip, true));
            if (!$hostname) {
                $error = 'SiteGround Cache: Connection to cache server failed!';
                return $error;
            }
            $purge_method = 'BAN';
        }
        $cacheServerSocket = fsockopen($hostname, 80, $errno, $errstr, 2);
        if (!$cacheServerSocket) {
            $error = 'SiteGround Cache: Connection to cache server failed!';
            return $error;
        }

        $request = $purge_method.' '.$purgeRequest.' HTTP/1.0\r\nHost: '.$_SERVER['SERVER_NAME'].'\r\nConnection: Close\r\n\r\n';

        if (preg_match('/^www\./', $_SERVER['SERVER_NAME'])) {
            $domain_no_www = preg_replace('/^www\./', '', $_SERVER['SERVER_NAME']);
            $request2 = 'BAN '.$purgeRequest.' HTTP/1.0\r\nHost: '.$domain_no_www.'\r\nConnection: Close\r\n\r\n';
        } else {
            $request2 = 'BAN '.$purgeRequest.' HTTP/1.0\r\nHost: www.'.$_SERVER['SERVER_NAME'].'\r\nConnection: Close\r\n\r\n';
        }

        fwrite($cacheServerSocket, $request);
        $response = fgets($cacheServerSocket);
        fclose($cacheServerSocket);

        $cacheServerSocket = fsockopen($hostname, 80, $errno, $errstr, 2);
        fwrite($cacheServerSocket, $request2);
        fclose($cacheServerSocket);

        if (!preg_match('/200/', $response)) {
            $error = 'SiteGround Cache: Purge was not successful!';
            return $error;
        }

        return true;
    }
}
