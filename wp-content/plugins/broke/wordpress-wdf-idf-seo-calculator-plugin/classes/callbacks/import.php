<?php

class wtb_idf_calculator_import
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
     * return responce of this API request
     * @return stdClass
     */
    function response()
    {
        // save and get pages from csv
        $csv = new wtb_idf_calculator_csv_crawler($this->repository);
		$top10 = $csv->craw();
        
        // craw top 10
        $normalCrawler = new wtb_idf_calculator_normal_crawler($this->repository);
        $normalCrawler->craw($top10);
    }
}