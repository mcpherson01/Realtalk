<?php

class wtb_idf_calculator_helper
{
	/**
	 * return word cound in html
	 * @param string $html
	 * @return int
	 */
	static function getWordCount($html)
	{
		$html = str_replace('><', '> <', $html);
		$html = html_entity_decode(strip_tags($html));
		$html = str_replace(array('.', ',', '-', '?', '!'), ' ', $html);
		$html = preg_replace("/\s+/", " ", $html);
		
		$wordsArray = explode(' ', $html);
		$wordsArray = array_filter($wordsArray);
		$total = count($wordsArray);
		
		// $total = str_word_count($html);
		
		return $total;
	}

    /**
     * count how many times repeats word in text
     * @param string $content
     * @param string $word
     * @return int
     */
    static function getWordCountByWord($content, $word)
    {
        $ourKeywordsCount = 0;
		str_replace($word, '', $content, $ourKeywordsCount);
        return $ourKeywordsCount;
    }
    
    /**
     * number format
     * @param float $number
     * @return string
     */
	static function formatNumber($number)
	{
		return number_format( (float)$number, 2, __('.', 'wtb_idf_calculator'), '');
	}
	
    /**
     * convert string to lowercase
     * @param string $string
     * @return string
     */
	static function strtolower($string)
	{
		if (extension_loaded('mbstring')) {
			return mb_strtolower($string, 'UTF-8');
		}
		
		return strtolower($string);
	}
    
    /**
     * calculates IDF
     * @param int $totalDoc
     * @param int $docWithKeyword
     * @return float
     */
    static function getIDF ($totalDoc, $docWithKeyword)
    {
        if ($docWithKeyword > 0) {
            return log10(1 + ($totalDoc / $docWithKeyword));
        } else {
            return log10(1);
        }
    }
    
    /**
     * return average of array values
     * @param array $array
     * @return float
     */
    static function getAverage($array)
    {
        if (count($array) > 0) {
            return array_sum($array) / count($array);
        }
        
        return 0;
    }
    
    /**
     * explode string to array
     * @param string $html
     * @return array
     */
    static function getWordsArray($html)
    {
        $text = preg_replace('<!--(?!<!)[^\[>].*?-->', ' ', $html);
        $text = html_entity_decode($text);
        $text = wtb_idf_calculator_helper::strtolower($text);
        $text = str_replace(array( /* html */'&#38;', '&amp;'), '&', $text);
        
        $text = str_replace(array( /* html */
            '&#183;', '&#064;', '&quot;', '&#8230;',
            '&nbsp;' , '&#160;', '&#32;', '&#33;', '&#34;',
            '&#35;', '&#36;', '&#37;', '&#64;',
            '&#39;', '&#40;', '&#48;', '&#150;',
            '&#49;', '&lt;', '&gt;', '&#8212;',
            '&#50;','&#51;','&#52;','&#53;',
            '&#54;','&#55;', '&#160;', '&#126;',
            '&#161;', '&#162;', '&#163;', '&#164;', '&#165;', '&#166;', 
            '&#167;', '&#168;', '&#169;', '&#170;', '&#171;',
            '&#172;', '&#173;', '&#174;', '&#175;', '&nbsp;', '&iexcl;', '&cent;', 
            '&pound;', '&curren;', '&yen;', '&brvbar;', '&rarr;',
            '&#8230;', '&hellip;', '&bull;', 
            '&sect;', '&uml;', '&copy;', '&ordf;', '&shy;',
            '&laquo;', '&not;', '&shy;', '&reg;', '&macr',
            '&#56;','&#57;','&#58;','&#59;','&#60;','&#61;',
            '&#62;','&#63;', '&#41;', '&#42;', '&#43;', '&rsaquo;',
            '&#44;', '&#45;', '&#46;', '&#47;', '&raquo;', '&laquo;'
            ), ' ', $text);
        $text = str_replace(array(
            '...', '..', '. ', ',', '-', '?', '!', ':', '(', ')', '"', '[', ']', '>', '<', '/', '\'\'', '#', '©',
            '—', '′', '″', '˚', ';', '“', '„', '–', '”', '*', '|', '@', '}', '{', '=', '%', '`'
            ), ' ', html_entity_decode($text));
        $text = trim(preg_replace("/\s+/", " ", $text));
        
        $textArray = explode(" ", $text);

        foreach ($textArray as $key => $value) {
            
            $valueInHtml = htmlentities($value);
            
            $valueInHtml = str_replace(array(
                '&nbsp;', '&middot;', '&bull;', '&dagger;', '&reg;',
                '&Prime;', '&lt;', '&rdquo;', '&raquo;', '&quot;',
                '&prime;', '&ndash;', '&mdash;',
                '&ldquo;', '&gt;', '&copy;', '&bdquo;'
            ), ' ', $valueInHtml);
            
            $valueInHtml = trim($valueInHtml);
            
            if (strlen($valueInHtml) == 0) {
                unset($textArray[$key]);
                continue;
            }
            
            $textArray[$key] = html_entity_decode($valueInHtml);
        }

        return $textArray;
    }
    
    /**
     * group array of strings by the same string and get count of every string
     * @param array $array
     * @return array
     */
    static function groupWords($array)
    {
        $g = array();

        foreach ($array as $value) {
            if (!isset($g[$value])) {
                $g[$value] = 0;
            }

            $g[$value]++;
        }
        
        return $g;
    }
    
}

/* http://plugins.svn.wordpress.org/wp-minify/trunk/http_build_url.php */
if (!function_exists('http_build_url')) {
	define('HTTP_URL_REPLACE', 1);          // Replace every part of the first URL when there's one of the second URL
	define('HTTP_URL_JOIN_PATH', 2);        // Join relative paths
	define('HTTP_URL_JOIN_QUERY', 4);       // Join query strings
	define('HTTP_URL_STRIP_USER', 8);       // Strip any user authentication information
	define('HTTP_URL_STRIP_PASS', 16);      // Strip any password authentication information
	define('HTTP_URL_STRIP_AUTH', 32);      // Strip any authentication information
	define('HTTP_URL_STRIP_PORT', 64);      // Strip explicit port numbers
	define('HTTP_URL_STRIP_PATH', 128);     // Strip complete path
	define('HTTP_URL_STRIP_QUERY', 256);    // Strip query string
	define('HTTP_URL_STRIP_FRAGMENT', 512); // Strip any fragments (#identifier)
	define('HTTP_URL_STRIP_ALL', 1024);     // Strip anything but scheme and host
    
    // Build an URL
    // The parts of the second URL will be merged into the first according to the flags argument. 
    // 
    // @param  mixed      (Part(s) of) an URL in form of a string or associative array like parse_url() returns
    // @param  mixed      Same as the first argument
    // @param  int        A bitmask of binary or'ed HTTP_URL constants (Optional)HTTP_URL_REPLACE is the default
    // @param  array      If set, it will be filled with the parts of the composed url like parse_url() would return 
    function http_build_url($url, $parts=array(), $flags=HTTP_URL_REPLACE, &$new_url=false)
    {
      $keys = array('user','pass','port','path','query','fragment');
      
      // HTTP_URL_STRIP_ALL becomes all the HTTP_URL_STRIP_Xs
      if ($flags & HTTP_URL_STRIP_ALL)
      {
        $flags |= HTTP_URL_STRIP_USER;
        $flags |= HTTP_URL_STRIP_PASS;
        $flags |= HTTP_URL_STRIP_PORT;
        $flags |= HTTP_URL_STRIP_PATH;
        $flags |= HTTP_URL_STRIP_QUERY;
        $flags |= HTTP_URL_STRIP_FRAGMENT;
      }
      // HTTP_URL_STRIP_AUTH becomes HTTP_URL_STRIP_USER and HTTP_URL_STRIP_PASS
      else if ($flags & HTTP_URL_STRIP_AUTH)
      {
        $flags |= HTTP_URL_STRIP_USER;
        $flags |= HTTP_URL_STRIP_PASS;
      }
      
      // Parse the original URL
      $parse_url = parse_url($url);
      
      // Scheme and Host are always replaced
      if (isset($parts['scheme']))
        $parse_url['scheme'] = $parts['scheme'];
      if (isset($parts['host']))
        $parse_url['host'] = $parts['host'];
      
      // (If applicable) Replace the original URL with it's new parts
      if ($flags & HTTP_URL_REPLACE)
      {
        foreach ($keys as $key)
        {
          if (isset($parts[$key]))
            $parse_url[$key] = $parts[$key];
        }
      }
      else
      {
        // Join the original URL path with the new path
        if (isset($parts['path']) && ($flags & HTTP_URL_JOIN_PATH))
        {
          if (isset($parse_url['path']))
            $parse_url['path'] = rtrim(str_replace(basename($parse_url['path']), '', $parse_url['path']), '/') . '/' . ltrim($parts['path'], '/');
          else
            $parse_url['path'] = $parts['path'];
        }
        
        // Join the original query string with the new query string
        if (isset($parts['query']) && ($flags & HTTP_URL_JOIN_QUERY))
        {
          if (isset($parse_url['query']))
            $parse_url['query'] .= '&' . $parts['query'];
          else
            $parse_url['query'] = $parts['query'];
        }
      }
        
      // Strips all the applicable sections of the URL
      // Note: Scheme and Host are never stripped
      foreach ($keys as $key)
      {
        if ($flags & (int)constant('HTTP_URL_STRIP_' . strtoupper($key)))
          unset($parse_url[$key]);
      }
      
      
      $new_url = $parse_url;
      
      return 
         ((isset($parse_url['scheme'])) ? $parse_url['scheme'] . '://' : '')
        .((isset($parse_url['user'])) ? $parse_url['user'] . ((isset($parse_url['pass'])) ? ':' . $parse_url['pass'] : '') .'@' : '')
        .((isset($parse_url['host'])) ? $parse_url['host'] : '')
        .((isset($parse_url['port'])) ? ':' . $parse_url['port'] : '')
        .((isset($parse_url['path'])) ? $parse_url['path'] : '')
        .((isset($parse_url['query'])) ? '?' . $parse_url['query'] : '')
        .((isset($parse_url['fragment'])) ? '#' . $parse_url['fragment'] : '')
      ;
	}
    
}