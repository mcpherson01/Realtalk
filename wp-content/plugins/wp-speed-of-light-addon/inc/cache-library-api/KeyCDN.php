<?php

/**
 * Library for the KeyCDN API -- author  Sven Baumgartner -- version 0.3
 */
class KeyCDN
{
    /**
     * Init api key
     *
     * @var string
     */
    private $apiKey;

    /**
     * Init end point
     *
     * @var string
     */
    private $endpoint;

    /**
     * KeyCDN contructor
     *
     * @param string      $apiKey   Api key
     * @param string|null $endpoint End point
     */
    public function __construct($apiKey, $endpoint = null)
    {
        if ($endpoint === null) {
            $endpoint = 'https://api.keycdn.com';
        }

        $this->setApiKey($apiKey);
        $this->setEndpoint($endpoint);
    }

    /**
     * Get api key
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Set api key
     *
     * @param string $apiKey Api key
     *
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = (string) $apiKey;

        return $this;
    }

    /**
     * Get end point
     *
     * @return string
     */
    public function getEndpoint()
    {
        return $this->endpoint;
    }

    /**
     * Set end point
     *
     * @param string $endpoint End point
     *
     * @return $this
     */
    public function setEndpoint($endpoint)
    {
        $this->endpoint = (string) $endpoint;

        return $this;
    }

    /**
     * Execute get
     *
     * @param string $selectedCall Selected call
     * @param array  $params       Parameter
     *
     * @return string
     * @throws Exception Check exception
     */
    public function get($selectedCall, array $params = array())
    {
        return $this->execute($selectedCall, 'GET', $params);
    }

    /**
     * Excecute post
     *
     * @param string $selectedCall Selected call
     * @param array  $params       Parameter
     *
     * @return string
     * @throws Exception Check exception
     */
    public function post($selectedCall, array $params = array())
    {
        return $this->execute($selectedCall, 'POST', $params);
    }

    /**
     * Execute put cache
     *
     * @param string $selectedCall Selected call
     * @param array  $params       Parameter
     *
     * @return string
     * @throws Exception Check exception
     */
    public function put($selectedCall, array $params = array())
    {
        return $this->execute($selectedCall, 'PUT', $params);
    }

    /**
     * Delete CDN cache
     *
     * @param string $selectedCall Selected call
     * @param array  $params       Parameter
     *
     * @return string
     * @throws Exception Check exception
     */
    public function delete($selectedCall, array $params = array())
    {
        return $this->execute($selectedCall, 'DELETE', $params);
    }

    /**
     * Purge key CDN cache
     *
     * @param string $selectedCall Selected call
     * @param string $methodType   Type of method
     * @param array  $params       Parameter
     *
     * @return string
     * @throws Exception Check exception
     */
    private function execute($selectedCall, $methodType, array $params)
    {
        $endpoint = rtrim($this->endpoint, '/') . '/' . ltrim($selectedCall, '/');

        // start with curl and prepare accordingly
        $ch = curl_init();

        // create basic auth information
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ':');

        // return transfer as string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // set curl timeout
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        // retrieve headers
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, 1);

        //Fix SSL VERIFYPEER modifiled by joomunited
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // set request type
        if (!in_array($methodType, array('POST', 'GET'))) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $methodType);
        }

        $queryStr = http_build_query($params);
        // send query-str within url or in post-fields
        if (in_array($methodType, array('POST', 'PUT', 'DELETE'))) {
            $reqUri = $endpoint;
            curl_setopt($ch, CURLOPT_POSTFIELDS, $queryStr);
        } else {
            $reqUri = $endpoint . '?' . $queryStr;
        }

        // url
        curl_setopt($ch, CURLOPT_URL, $reqUri);

        // make the request
        $result    = curl_exec($ch);
        $headers   = curl_getinfo($ch);
        $curlError = curl_error($ch);

        curl_close($ch);

        // get json_output out of result (remove headers)
        $jsonOutput = substr($result, $headers['header_size']);

        // error catching
        if (!empty($curlError) || empty($jsonOutput)) {
            throw new Exception('KeyCDN-Error: '.$curlError.', Output: '.$jsonOutput);
        }

        return $jsonOutput;
    }
}
