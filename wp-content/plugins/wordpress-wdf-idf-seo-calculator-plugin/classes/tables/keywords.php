<?php

class wtb_idf_calculator_table_keywords extends wtb_idf_calculator_table {
    
    /**
     * get name of table
     * @var string
     */
    protected $table_name = "wtb_site_keywords";
    
    /**
     * create table into DB
     * @return bol
     */
    public function create()
	{
		$table_name = $this->getTableName();

		return $this->createTable("CREATE TABLE `" . $table_name . "` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
                `url_id` INT(11) NOT NULL,
				`keyword` VARCHAR(255) NOT NULL,
				`times` INT NOT NULL,
				`updated` DATETIME NOT NULL,
				`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			)
			COLLATE='utf8_general_ci'
			ENGINE=InnoDB");
	}
 
    /**
     * creates new record in DB
     * @global wpdb $wpdb
     * @param string $keyword
     * @param int $website_id
     * @param int $times
     * @return int|bool
     */
    public function saveKeyword($keyword, $website_id, $times)
	{
		global $wpdb;
		
		return $wpdb->insert( $this->getTableName(), array(
			'updated' => current_time('mysql'), 
			'keyword' => $keyword,
			'times' => $times,
			'url_id' => $website_id ) );
	}
    
    /**
     * get keywords from DB and calculate wdf
     * @global wpdb $wpdb
     * @param string $url
     * @param int $totalWords
     * @param array $keywords
     * @return array
     */
    public function getKeywordsWithWdf($url, $totalWords = 1, $keywords = array())
    {
        global $wpdb;

        // we hope, that join is not to lazy
        return $wpdb->get_results("
				SELECT k.keyword, k.times, log2(1+k.times)/log2(".$totalWords.") AS wdf
				FROM `".$this->getTableName()."` AS k
				WHERE k.url = '" . $url ."'
                    AND k.keyword in ('".  implode("', '", $keywords)."')
				ORDER BY times desc");
    }
    
    /**
     * bulk save keywords in database
     * @global wpdb $wpdb
     * @param array $manyKeywords
     */
    public function saveKeywords(array $manyKeywords)
	{
		global $wpdb;
		
        $values = array();
        $place_holders = array();

        $query = "INSERT INTO `".$this->getTableName()."` (updated, keyword, url_id, times) VALUES ";
    
        foreach($manyKeywords as $value) {
            array_push($values, current_time('mysql'));
            array_push($values, $value[0], $value[1], $value[2]);
            $place_holders[] = "(%s, %s, %s, %d)";
        }

        $query .= implode(', ', $place_holders);
        $wpdb->query( $wpdb->prepare($query, $values));
	}
    
    /**
     * get top keywords from websites by average WDF
     * @global wpdb $wpdb
     * @param array $top10
     * @param int $limit
     * @return array
     */
    public function getTopKeywords($top10, $limit = 30)
    {
        global $wpdb;

        $websiteIds = array();
        foreach ($top10 as $value) {
            $websiteIds[] = $value->id;
        }

        $table_name = $this->getTableName();
        $parent_table_name = $this->parent->websites->getTableName();
        $parent_stopwords_table_name = $this->parent->stopwords->getTableName();
        
        // we hope, that join is not to lazy
        $query = $wpdb->prepare( "
			SELECT 
	            k.keyword, 
	            sum(log2(1+k.times)/log2(w.word_count))/%d AS wdf,
	            max(log2(1+k.times)/log2(w.word_count)) AS max_wdf
			FROM $table_name AS k
	        INNER JOIN $parent_table_name AS w
	            ON w.id = k.url_id 
	        LEFT JOIN $parent_stopwords_table_name AS s 
	            ON s.keyword = k.keyword
			WHERE s.id is null AND k.url_id in (%d)
	        GROUP BY k.keyword
			ORDER BY wdf DESC
			LIMIT %d",
	        count($websiteIds),
	        implode(',', $websiteIds),
	        $limit
        );

        return $wpdb->get_results( $query );
    }
    
    /**
     * checks or update from website is needed
     * normaly update website 1 time in 48 hours
     * @global wpdb $wpdb
     * @param int $websiteId
     * @return bool
     */
    public function isUpdateNeeded($websiteId)
	{
		global $wpdb;
		
		$max = $wpdb->get_var( "
				SELECT MAX(updated) 
				FROM ".$this->getTableName()." 
				WHERE url_id = '".$websiteId."'
					" );
		
		return (strtotime($max)+3600*48 < time());
	}
    
    /**
     * get wdf of website keywords
     * @global wpdb $wpdb
     * @param int $websiteId
     * @param array $keywords
     * @return array
     */
    public function getWdfByWebsite($websiteId, $keywords)
    {
        global $wpdb;

        foreach ($keywords as $key => $value) {
            $keywords[$key] = esc_sql($value);
        }

        $table_name = $this->getTableName();
        $parent_table_name = $this->parent->websites->getTableName();
        
        $query = $wpdb->prepare("
		SELECT 
            k.keyword, 
            k.times,
            log2(1+k.times)/log2(w.word_count) AS wdf
		FROM $table_name AS k
        INNER JOIN $parent_table_name AS w
            ON w.id = k.url_id 
		WHERE k.url_id = %d and BINARY k.keyword in ('".implode("','", $keywords)."')
		", $websiteId);

        return $wpdb->get_results( $query );
    }
    
    public function countDocs($keyword)
    {
        global $wpdb;

        $keyword = esc_sql($keyword);
        $table_name = $this->getTableName();
        
        $query = $wpdb->prepare( "
			SELECT 
	            count(id)
			FROM $table_name AS k
			WHERE BINARY k.keyword ='%s'
		", $keyword);
        
        $result = $wpdb->get_var( $query );
        
        if (!$result) {
            return 1;
        }
        
        return $result;
    }
}