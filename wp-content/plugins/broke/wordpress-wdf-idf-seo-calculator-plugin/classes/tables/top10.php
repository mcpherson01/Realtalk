<?php

class wtb_idf_calculator_table_top10 extends wtb_idf_calculator_table {
    
    /**
     * get name of table
     * @var string
     */
    protected $table_name = "wtb_google_top_10";
    
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
                `google_domain` VARCHAR(10) NOT NULL,
				`updated` DATETIME NOT NULL,
				`created` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
			)
			COLLATE='utf8_general_ci'
			ENGINE=InnoDB;");
	}
 
    /**
     * check or update from google needed.
     * normaly wait 36 hours to craw goolge again
     * @global wpdb $wpdb
     * @param string $keyword
     * @param string $domain
     * @return bool
     */
    public function isUpdateNeeded($keyword, $domain)
    {
        global $wpdb;
		
		$max = $wpdb->get_var( "
			SELECT MAX(updated) 
			FROM ".$this->getTableName()." 
			WHERE keyword = '".$keyword."'
                AND google_domain = '".$domain."'
				" );
		
		return strtotime($max)+3600*36 < time();
    }
    
    /**
     * get id of website by its url
     * @param string $url
     * @return int
     */
    private function getWebsiteId($url)
    {
        $websiteId = $this->parent->websites->getWebsiteIdByUrl($url);
			
		if (is_null($websiteId)) {
			$this->parent->websites->save($url);
            $websiteId = $this->parent->websites->getWebsiteIdByUrl($url);
		}
        
        return $websiteId;
    }
    
    /**
     * save or updates record in DB
     * @global wpdb $wpdb
     * @param string $keyword
     * @param string $url
     * @param string $googleDomain
     * @return boolean
     */
    public function save($keyword, $url, $googleDomain)
	{
		global $wpdb;
		
        $websiteId = $this->getWebsiteId($url);
        if ($websiteId === false) {
            return false;
        }
        
		if ($wpdb->get_var("SELECT id FROM ".$this->getTableName()." WHERE 
            google_domain = '".$googleDomain."' and 
            url_id = '".$websiteId."' and 
            keyword = '" . $keyword . "'")) {
			return $wpdb->update( $this->getTableName(), array( 'updated' => current_time('mysql')),
				"google_domain = '".$googleDomain."' and url_id = '".$websiteId."' and  keyword = '" . $keyword . "'" );
		} else {
			return $wpdb->insert( $this->getTableName(), array( 
				'updated' => current_time('mysql'), 
				'keyword' => $keyword,
                'google_domain' => $googleDomain,
				'url_id' => $websiteId ) );
		}
	}
    
    /**
     * get website from DB by keyword and google domain
     * @global wpdb $wpdb
     * @param string $keyword
     * @param string $googleDomain
     * @return array
     */
    public function get($keyword, $googleDomain)
	{
		global $wpdb;

		$parent_table_name = $this->parent->websites->getTableName();
		$table_name = $this->getTableName();

		$query = $wpdb->prepare( "
			SELECT w.id, w.url, w.word_count AS totalWords
			FROM $parent_table_name as w
            INNER JOIN $table_name as t
				ON w.id = t.url_id AND t.keyword = '%s' AND t.google_domain = '%s'
			GROUP BY w.id
			LIMIT 10", [
				$keyword,
				$googleDomain
			]
		);

		return $wpdb->get_results( $query );
	}
}