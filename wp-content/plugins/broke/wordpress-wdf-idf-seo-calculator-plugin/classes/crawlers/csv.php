<?php

/**
 * csv crawler
 * read csv wp-content/uploads/wtb_idf_calculator.csv and write to db
 */
class wtb_idf_calculator_csv_crawler
{
    private $scv = 'uploads/wtb_idf_calculator.csv';
    
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
     * craw google
     * @return array
     */
	function craw()
	{
        $pages = array();
        $file = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . $this->scv;
        if (file_exists($file)) {
            if (($handle = fopen($file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if (!empty($data[0])) {
                        $temp = trim($data[0]);
                        if (!empty($temp)) {
                            $pages[] = $temp;
                        }
                    }
                }
                fclose($handle);
            }
        }
        
        $this->repository->websites->saveWebsites($pages);
        
        $result = $this->repository->websites->getByUrls($pages, 3600*36);
        
        if (!empty($result)) {
            return $result;
        }
        
        return array();
	}
}