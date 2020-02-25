<?php

/**
 * normal crawler
 */
class wtb_idf_calculator_normal_crawler
{
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
	}
	
    /**
     * craw concret website
     * @param stdClass $site
     * @return void
     */
	private function _update($site)
	{
        $this->repository->keywords->delete(array('url_id' => $site->id));
		
		$url = $site->url;
		
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

		if ($err != 0 or $header['http_code'] != 200) {
			// todo remove from db
			return;
		}

		$content = str_replace('><', '> <', $content);
		$html = str_get_html($content);
		if ($html) {
            ini_set('xdebug.max_nesting_level', 555); // max nesting level more
			foreach ($html->find('body') as $body) {
				/* @var $body simple_html_dom_node */
                
				$this->saveKeywordsFromHtml($site, $body->text());
			}
		}
	}
	
    /**
     * save words of website
     * @param stdClass $site
     * @param string $html
     */
    function saveKeywordsFromHtml($site, $html)
    {
        $text = wtb_idf_calculator_helper::getWordsArray($html);
        
        // save total words count
        $this->repository->websites->saveTopWords($site->id, count($text));

        $textArray = array_filter($text, array($this, 'skipStopwords'));
        
        // save words and their count
        $g = wtb_idf_calculator_helper::groupWords($textArray);

        $bulkInsert = array();
        foreach ($g as $key => $times) {
            $bulkInsert[] = array($key, $site->id, $times);
            if (count($bulkInsert) > 60) {
                $this->repository->keywords->saveKeywords($bulkInsert);
                $bulkInsert = array();
            }
        }
        
        if (count($bulkInsert)) {
            $this->repository->keywords->saveKeywords($bulkInsert);
        }
        
    }
    
    /**
     * check or item is stopword
     * @param string $keyword
     * @return boolean
     */
	function skipStopwords($keyword)
	{
		$keyword = trim($keyword);
		
		if (empty($keyword)) {
			return false;
		}
		
		// if number
		if ((string)(int)$keyword == $keyword) {
			return false;
		}
		
		// if to short
		if (strlen($keyword) < 2) {
			return false;
		}
        
		if (in_array(htmlentities($keyword), array('&middot;'))) {
			return false;
		}

        return true; // hack to save words to db if they are stopwords
		return !in_array($keyword, $this->getStopWords());
	}
	
    /**
     * get stopwords. To have less DB queries, save to object.
     * @return array
     */
    private function getStopWords()
    {
        if (empty($this->stopKeywords )) {
            $this->stopKeywords = $this->repository->stopwords->getAll();
        }
        
        return $this->stopKeywords ;
    }
    
    /**
     * craw given web sites
     * @return array
     */
	function craw($top10)
	{
		foreach ($top10 as $value) {
			if ($this->_isKeywordsUpdateNeeded($value->id)) {
				$this->_update($value);
				
				$value->totalWords = $this->repository->websites->getTotalWordsByUrl($value->url);
			}
		}
	}
    
    /**
     * check or we need update keyword of the website
     * @param int $websiteId
     * @return bool
     */
	private function _isKeywordsUpdateNeeded($websiteId)
	{
		return $this->repository->keywords->isUpdateNeeded($websiteId);
	}
}