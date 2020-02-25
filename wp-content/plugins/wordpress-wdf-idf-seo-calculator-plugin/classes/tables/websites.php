<?php

class wtb_idf_calculator_table_websites extends wtb_idf_calculator_table {
    
    /**
     * get name of table
     * @var string
     */
    protected $table_name = "wtb_websites";
    
    /**
     * create table into DB
     * @return bol
     */
    public function create()
	{
		$table_name = $this->getTableName();

		return $this->createTable("CREATE TABLE `" . $table_name . "` (
				`id` INT(11) NOT NULL AUTO_INCREMENT,
				`url` VARCHAR(255) NOT NULL,
				`word_count` INT NOT NULL,
				`updated` DATETIME NOT NULL,
				`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				UNIQUE KEY `url` (`url`)
			)
			COLLATE='utf8_general_ci'
			ENGINE=InnoDB");
	}
 
    /**
     * get website id by its url
     * @global wpdb $wpdb
     * @param string $url
     * @return int|bool
     */
    public function getWebsiteIdByUrl($url)
    {
        global $wpdb;
        
        return $wpdb->get_var("SELECT id FROM ".$this->getTableName() ." WHERE url = '".$url."'");
    }
 
    /**
     * save website to database
     * @global wpdb $wpdb
     * @param string $url
     * @return bool|int
     */
    public function save($url)
    {
        global $wpdb;
        
        return $wpdb->insert( $this->getTableName(), array( 'url' => $url ) );
    }
    
    /**
     * get total words count. 
     * if 0 - return 1, to avoid division from 0
     * @global wpdb $wpdb
     * @param string $url
     * @return int
     */
    public function getTotalWordsByUrl($url)
    {
        global $wpdb;
        
        $count = $wpdb->get_var("
					SELECT word_count
					FROM `".$this->getTableName()."` 
					WHERE url = '" . $url ."' 
					");

        if (!$count) {
            return 1;
        }
        
        return $count;
    }
    
    /**
     * save count of words in website
     * @global wpdb $wpdb
     * @param int $id
     * @param int $totalWords
     * @return bool
     */
    public function saveTopWords($id, $totalWords)
    {
        global $wpdb;
        
        return $wpdb->update( $this->getTableName(), array( 
                'word_count' => $totalWords,
                'updated' => current_time('mysql') ),
				array("id" => $id ));
    }
    
    /**
     * get total websites
     * @global wpdb $wpdb
     * @return int
     */
    public function totalDocs()
    {
        global $wpdb;
        
        $count = $wpdb->get_var("
					SELECT count(id)
					FROM `".$this->getTableName()."` 
					");

        return $count;
    }
    
     /**
     * get by array of ids
     * @global wpdb $wpdb
     * @param array $ids
     * @param int $olderThan
     * @return stdClass
     */
	public function getByIds($ids, $olderThan = 0)
	{
		global $wpdb;
        
        $sql = "
			SELECT *
			FROM `".$this->getTableName()."` as t 
            WHERE id in (" . implode(',', $ids) . ')';
        
        if ($olderThan > 0) {
            $sql .= " AND updated < '" . date('Y-m-d H:i:s', time()-$olderThan) . "'";
        }
        
		return $wpdb->get_results($sql);
	}
    
     /**
     * get by array of urls
     * @global wpdb $wpdb
     * @param array $urls
     * @param int $olderThan
     * @return stdClass
     */
	public function getByUrls($urls, $olderThan = 0)
	{
		global $wpdb;
        
        $sql = "
			SELECT *
			FROM `".$this->getTableName()."` as t 
            WHERE url in ('" . implode("','", $urls) . "')";
        
        if ($olderThan > 0) {
            $sql .= " AND updated < '" . date('Y-m-d H:i:s', time()-$olderThan) . "'";
        }
        
		return $wpdb->get_results($sql);
	}
    
    /**
     * bulk save websites in database
     * @global wpdb $wpdb
     * @param array $manyWebsites
     */
    public function saveWebsites(array $manyWebsites)
	{
		global $wpdb;
		
        $values = array();
        $place_holders = array();

        $query = "INSERT IGNORE INTO `".$this->getTableName()."` (url) VALUES ";
    
        foreach($manyWebsites as $value) {
            array_push($values, $value);
            $place_holders[] = "(%s)";
        }

        $query .= implode(', ', $place_holders);
        $wpdb->query( $wpdb->prepare($query, $values));
	}
}