<?php
/**
 * NetDNA REST Client Library -- @author    Karlo Espiritu -- @version   1.0 2012-09-21 -- @copyright 2012
 */
class NetDNA
{
    /**
     * Init alias
     *
     * @var string
     */
    public $alias;
    /**
     * Init key
     *
     * @var string
     */
    public $key;
    /**
     * Init secret
     *
     * @var string
     */
    public $secret;
    /**
     * Init api url
     *
     * @var string
     */
    public $netdnarws_url = 'https://api.stackpath.com/v1';
    /**
     * Init consumer
     *
     * @var string
     */
    private $consumer;

    /**
     * NetDNA constructor.
     *
     * @param string $alias   Set alias variable
     * @param string $key     Set key variable
     * @param string $secret  Set secret variable
     * @param null   $options Option of CDN
     */
    public function __construct($alias, $key, $secret, $options = null)
    {
        $this->alias  = $alias;
        $this->key    = $key;
        $this->secret = $secret;
        if (!class_exists('OAuthConsumer')) {
            require_once __DIR__ . '/NetDNA/OAuth/OAuthConsumer.php';
        }
        $this->consumer = new \NetDNA\OAuth\OAuthConsumer($key, $secret, null);
    }

    /**
     * Execute purge NetDNA cache
     *
     * @param string $selected_call Selected call CDN
     * @param string $method_type   Type of medthod
     * @param string $params        Parameter
     *
     * @return string
     * @throws \NetDNA\RWSException Check exception
     */
    private function execute($selected_call, $method_type, $params)
    {
        // the endpoint for your request
        $endpoint = $this->netdnarws_url.'/'.$this->alias.$selected_call;
        
        //parse endpoint before creating OAuth request
        $parsed = parse_url($endpoint);
        if (array_key_exists('parsed', $parsed)) {
            parse_str($parsed['query'], $params);
        }

        //generate a request from your consumer
        if (!class_exists('OAuthRequest')) {
            require_once __DIR__ . '/NetDNA/OAuth/OAuthRequest.php';
            require_once __DIR__ . '/NetDNA/OAuth/OAuthUtil.php';
        }
        $req_req = \NetDNA\OAuth\OAuthRequest::from_consumer_and_token($this->consumer, null, $method_type, $endpoint, $params);

        //sign your OAuth request using hmac_sha1
        if (!class_exists('OAuthSignatureMethod_HMAC_SHA1')) {
            require_once __DIR__ . '/NetDNA/OAuth/OAuthSignatureMethod_HMAC_SHA1.php';
        }
        $sig_method = new \NetDNA\OAuth\OAuthSignatureMethod_HMAC_SHA1();
        $req_req->sign_request($sig_method, $this->consumer, null);

        // create curl resource
        $ch = curl_init();
        
        // set url
        curl_setopt($ch, CURLOPT_URL, $req_req);
        
        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        // set curl timeout
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        // set curl custom request type if not standard
        if ($method_type !== 'GET' && $method_type !== 'POST') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method_type);
        }


        if ($method_type === 'POST' || $method_type === 'PUT' || $method_type === 'DELETE') {
            $query_str = \NetDNA\OAuth\OAuthUtil::build_http_query($params);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:', 'Content-Length: ' . strlen($query_str)));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query_str);
        }

        // retrieve headers
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        
        //set user agent
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP NetDNA API Client');

        // make call
        $result = curl_exec($ch);
        $headers = curl_getinfo($ch);
        $curl_error = curl_error($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        // $json_output contains the output string
        $json_output = substr($result, $headers['header_size']);

        // catch errors
        if (!empty($curl_error) || empty($json_output)) {
            throw new \NetDNA\RWSException('CURL ERROR: '.$curl_error.', Output: '.$json_output, $headers['http_code'], null, $headers);
        }

        return $json_output;
    }

    /**
     * Execute get
     *
     * @param string $selected_call Selected call CDN
     * @param array  $params        Parameters
     *
     * @return string
     * @throws \NetDNA\RWSException Check exception
     */
    public function get($selected_call, $params = array())
    {
         
        return $this->execute($selected_call, 'GET', $params);
    }

    /**
     * Execute post
     *
     * @param string $selected_call Selected call CDN
     * @param array  $params        Parameters
     *
     * @return string
     * @throws \NetDNA\RWSException Check exception
     */
    public function post($selected_call, $params = array())
    {
        return $this->execute($selected_call, 'POST', $params);
    }

    /**
     * Execute put
     *
     * @param string $selected_call Selected call CDN
     * @param array  $params        Parameters
     *
     * @return string
     * @throws \NetDNA\RWSException Check exception
     */
    public function put($selected_call, $params = array())
    {
        return $this->execute($selected_call, 'PUT', $params);
    }

    /**
     * Execute delete
     *
     * @param string $selected_call Selected call CDN
     * @param array  $params        Parameters
     *
     * @return string
     * @throws \NetDNA\RWSException Check exception
     */
    public function delete($selected_call, $params = array())
    {
        return $this->execute($selected_call, 'DELETE', $params);
    }
}
