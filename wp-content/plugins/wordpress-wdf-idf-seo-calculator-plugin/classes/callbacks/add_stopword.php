<?php

class wtb_idf_calculator_add_stopword
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
     * get responce of this api request
     */
    function response()
    {
        if (!empty($_POST['stopword'])) {
            $this->repository->stopwords->createStopKeyword(array('keyword' => $_POST['stopword'], 'language' => ''));
        }
    }
}