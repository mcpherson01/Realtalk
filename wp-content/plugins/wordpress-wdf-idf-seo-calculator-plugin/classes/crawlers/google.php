<?php

/**
 * google crawler
 */
class wtb_idf_calculator_google_crawler
{
    /**
     * @var string
     */
	var $keyword;
	
    /**
     * @var string
     */
    private $googleDomain;
    
	/**
	 * @var wtb_idf_calculator_tables
	 */
	private $repository;
	
    /**
     * constructor
     * @param wtb_idf_calculator_tables $repository
     */
	function __construct($repository)
	{
		$this->repository = $repository;

        $settings = wtb_idf_calculator_settings::getSettings();
		$this->googleDomain = !empty($settings['google_domain']) ? $settings['google_domain'] : '.com';
	}
	
    /**
     * craw google
     * @return array
     */
	function craw()
	{
		return $this->_getTop10();
	}
	
    /**
     * get link to google search page
     * @return simple_html_dom|false
     */
    private function getGoogleDocument()
    {
	    // 30.09.2013 - http:// => https:// - should help for servers with safe+mod on
        $url = 'https://www.google'.$this->googleDomain.'/search?q=' . urlencode($this->keyword);
        
        // craw site
		$user_agent = 'Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
		
		$options = array(
			CURLOPT_CUSTOMREQUEST  => "GET",       //set request type post or get
			CURLOPT_POST           => false,       //set to GET
			CURLOPT_USERAGENT      => $user_agent, //set user agent
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 5,      // timeout on connect
			CURLOPT_TIMEOUT        => 5,      // timeout on response
			CURLOPT_MAXREDIRS      => 1,      // stop after 10 redirects
		);
		
		$ch = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		if ($err != 0 or $header['http_code'] != 200 ) {
			die('Error on Google request ('.$url.'): ' . $header['http_code'] . ' [err: '.$err.']');
		}
        
        if (empty($content)) {
			die('Empty Google response');
        }

        $dom = new simple_html_dom(null);
        $dom->load($content);
        
        if (!$dom) {
			die('Error on Google response ('.$url.'): len=' . strlen($content));
        }

	    return $dom;
    }
    
    /**
     * parse google results
     */
	private function _getTop10FromGoogle()
	{
		$top10 = array();
		
		$html = $this->getGoogleDocument();
		if ($html) {
            
			foreach ($html->find('#rso .srg > .g a') as $item) {
				if (strpos($item->href, 'http://') === 0) {
                    $url = $item->href;
                    
                    // facebook hack
                    $url = $this->_facebookNoScript($url);

                    $top10[] = $url;
                } else {
                    $query = parse_url('http://google' . $this->googleDomain . $item->href, PHP_URL_QUERY);
                    $parsedQuery = array();
                    parse_str($query, $parsedQuery);
                    if (!empty($parsedQuery['q'])) {
                        if (parse_url($parsedQuery['q'], PHP_URL_HOST)) {

                            // facebook hack
                            $parsedQuery['q'] = $this->_facebookNoScript($parsedQuery['q']);

                            $top10[] = $parsedQuery['q'];
                        }
                    }
                }
			}
		} else {
            die('No google response');
        }

		$this->saveTop10($top10);
	}
    
    /**
     * save google results to DB
     * @param array $top10
     */
    private function saveTop10($top10 = array())
    {
		foreach ($top10 as $value) {
			$this->repository->top10->save($this->keyword, $value, $this->googleDomain);
		}
    }
	
    /**
     * hack for facebook. add url parameter, to facebook think, that we dont have js
     * @param string $url
     * @return string
     */
	private function _facebookNoScript($url)
	{
		$urlArr = parse_url($url);
		if (!empty($urlArr['host']) and $urlArr['host'] == 'www.facebook.com') {
			if (empty($urlArr['query'])) {
				$urlArr['query'] = '';
			}
			$urlArr['query'] = '_fb_noscript=1&' . $urlArr['query'];
			$tmp = http_build_url('', $urlArr);
			if (!empty($tmp)) {
				$url = $tmp;
			}
		}
		
		return $url;
	}
	
    /**
     * check or we need update info of google
     * @return bool
     */
	private function _isUpdateFromGoogleNeeded()
	{
		return $this->repository->top10->isUpdateNeeded($this->keyword, $this->googleDomain);
	}
	
    /**
     * get top 10 of google
     * @return array
     */
	private function _getTop10()
	{
		if ($this->_isUpdateFromGoogleNeeded()) {
			$this->_getTop10FromGoogle();
		}
		
		return $this->repository->top10->get($this->keyword, $this->googleDomain);
	}
}