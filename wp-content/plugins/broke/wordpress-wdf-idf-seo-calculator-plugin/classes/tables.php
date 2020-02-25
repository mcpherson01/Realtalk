<?php

class wtb_idf_calculator_tables
{
    /**
     *
     * @var wtb_idf_calculator_table_top10
     */
    var $top10;
    
    /**
     *
     * @var wtb_idf_calculator_table_keywords
     */
    var $keywords;
    
    /**
     *
     * @var wtb_idf_calculator_table_stopwords
     */
    var $stopwords;
    
    /**
     *
     * @var wtb_idf_calculator_table_websites
     */
    var $websites;
    
    /**
     * constructor
     */
    function __construct() 
    {
        $this->top10 = new wtb_idf_calculator_table_top10($this);
        $this->keywords = new wtb_idf_calculator_table_keywords($this);
        $this->stopwords = new wtb_idf_calculator_table_stopwords($this);
        $this->websites = new wtb_idf_calculator_table_websites($this);
    }
    
}
