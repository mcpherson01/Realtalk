<?php

class wtb_idf_calculator_draw_graph
{
    /**
     * @var wtb_idf_calculator_tables
     */
    private $repository;
    
    /**
     * @var string
     */
    private $keyword;
    
    /**
     * @var string
     */
    private $content;
    
    /**
     * @var int
     */
    private $total;

    /**
     * constructor
     * @param wtb_idf_calculator_tables $repository
     */
    function __construct($repository) 
    {
        $this->repository = $repository;
    }
    
    /**
     * load data from POST request
     */
    private function loadDataFromRequest()
    {
        $this->keyword = wtb_idf_calculator_helper::strtolower($_POST['keyword']);
        $this->content = wtb_idf_calculator_helper::strtolower(do_shortcode($_POST['content']));
        $this->total = wtb_idf_calculator_helper::strtolower(do_shortcode($_POST['total']));
    }
    
    /**
     * return response of this API request
     * @return stdClass
     */
    function response()
    {
        $this->loadDataFromRequest();
        
        // get from google top 10 pages
        $google = new wtb_idf_calculator_google_crawler($this->repository);
		$google->keyword = $this->keyword;
		$top10 = $google->craw();
        
        // craw top 10
        $normalCrawler = new wtb_idf_calculator_normal_crawler($this->repository);
        $normalCrawler->craw($top10);
        
        // get top keywords
        $topKeywords = $this->repository->keywords->getTopKeywords($top10, $this->total);
		
        // get keywords for websites
        $this->attachKeywords($top10, $topKeywords);
        
        $content = $this->content;
        $totalWordsCount = wtb_idf_calculator_helper::getWordCount($content);
        $contentArray = wtb_idf_calculator_helper::getWordsArray($content);
        $contentArray = wtb_idf_calculator_helper::groupWords($contentArray);
        
        foreach ($topKeywords as $value) {
            $ourKeywordsCount = 0;
            if (isset($contentArray[$value->keyword])) {
                $ourKeywordsCount = $contentArray[$value->keyword];
            }

            $value->idf_with_us = wtb_idf_calculator_helper::getIDF(
            	count($top10)+1,
	            $value->onSites + ($ourKeywordsCount > 0 ? 1 : 0)
            );

            if (log($totalWordsCount , 2) != 0) {
                $value->wdf_with_us = log(1+$ourKeywordsCount, 2)/log($totalWordsCount , 2);
            } else {
                $value->wdf_with_us = 0;
            }
        }
        
        $responce = new stdClass;
        
        
        uasort($topKeywords, array($this, 'sortByAverageIdfWdf'));
        $responce->chart1 = $this->getInfoForChart1($top10, $topKeywords);
        
        uasort($topKeywords, array($this, 'sortByMaxIdfWdf'));
        $responce->chart2 = $this->getInforForChart2($top10, $topKeywords);
        
		return $responce;
    }
    
    /**
     * function to sort keywords by average of IDF*WDF 
     * @param stdClass $a
     * @param stdClass $b
     * @return int
     */
    function sortByAverageIdfWdf($a, $b) 
    {
        if ($a->wdf*$a->idf == $b->wdf*$b->idf) {
            return 0;
        }
        return ($a->wdf*$a->idf < $b->wdf * $b->idf) ? 1 : -1;
    }
    
    /**
     * function to sort keywords by maximum of IDF*WDF
     * @param stdClass $a
     * @param stdClass $b
     * @return int
     */
    function sortByMaxIdfWdf($a, $b) 
    {
        if ($a->max_wdf*$a->idf == $b->max_wdf*$b->idf) {
            return 0;
        }
        return ($a->max_wdf*$a->idf < $b->max_wdf * $b->idf) ? 1 : -1;
    }
    
    /**
     * function to sort keywords by keyword alphabetically
     * @param stdClass $a
     * @param stdClass $b
     * @return int
     */
    function sortByKeyword($a, $b) 
    {
        if ($a->keyword == $b->keyword) {
            return 0;
        }
        return ($a->keyword > $b->keyword) ? 1 : -1;
    }
    
    /**
     * update top10 and keywords array by info of eatch other
     * @param array $top10
     * @param array $keywords
     */
    function attachKeywords($top10, $keywords)
    {
        $keywordsArray = array();
        $keywordsOnSites = array();
        foreach ($keywords as $keyword) {
            $keywordsArray[$keyword->keyword] = new stdClass();
            $keywordsArray[$keyword->keyword]->wdf = 0;
            $keywordsArray[$keyword->keyword]->times = 0;
            $keywordsArray[$keyword->keyword]->keyword = $keyword->keyword;
            $keywordsOnSites[$keyword->keyword] = 0;
        }
        
        // attach keywords to sites
        foreach ($top10 as $topId => $value) {
            $top10[$topId]->keywords = $keywordsArray;
            
            $siteWdfs = $this->repository->keywords->getWdfByWebsite($value->id, array_keys($keywordsArray));
            foreach ($siteWdfs as $key) {
                $keywordsOnSites[$key->keyword]++;
                $top10[$topId]->keywords[$key->keyword] = clone $top10[$topId]->keywords[$key->keyword];
                $top10[$topId]->keywords[$key->keyword]->wdf = $key->wdf;
                $top10[$topId]->keywords[$key->keyword]->times = $key->times;
            }
        }
        
        // attach sites to keywords
        foreach ($keywords as $keyword) {
            $keyword->onSites = $keywordsOnSites[$keyword->keyword];
            $totalDocs = count($top10);
            $docsWithKeyword = $keywordsOnSites[$keyword->keyword];
            
            /**
             * bof test with full db
             */
            $totalDocs = $this->repository->websites->totalDocs();
            $docsWithKeyword = $this->repository->keywords->countDocs($keyword->keyword);
            /** 
             * eof test with full db
             */

            $keyword->idf = wtb_idf_calculator_helper::getIDF($totalDocs, $docsWithKeyword);
        }
    }
    
    /**
     * get info for chart one
     * @param array $top10
     * @param array $keywords
     * @return stdClass
     */
    function getInfoForChart1($top10, $keywords)
    {
        $chart1 = new stdClass();
        $chart1->legend = array(
            __('Average', 'wtb_idf_calculator'),
            __('Max', 'wtb_idf_calculator'),
            __('Our text', 'wtb_idf_calculator')
        );
        $chart1->data = array(
            array_merge(
                array(__('Keyword', 'wtb_idf_calculator')),
                $chart1->legend
            )
        );
        
        foreach ($keywords as $k => $line) {
            $temp = array();
            $temp[] = $line->keyword;
            $temp[] = (float)number_format($line->idf * $line->wdf, 4);
            $temp[] = (float)number_format($line->idf * $line->max_wdf, 4);
            $temp[] = (float)number_format($line->wdf_with_us * $line->idf_with_us, 4);
            $chart1->data[] = $temp;
        }
        
        return $chart1;
    }
    
    /**
     * get info for chart two
     * @param array $top10
     * @param array $keywords
     * @return stdClass
     */
    function getInforForChart2($top10, $keywords)
    {
        $chart2 = new stdClass();
        $chart2->legend = array();
        $chart2->data = array();
        
        foreach ($top10 as $page) {
            $chart2->legend[] = trim(str_replace('http://', '', $page->url), '/');
        }
        
        $tempData = array();
        foreach ($keywords as $line) {
            $temp = array();
            $temp[] = $line->keyword;
            
            foreach ($top10 as $page) {
                $temp[] = (float)number_format($line->idf * $page->keywords[$line->keyword]->wdf, 4);
            }
            $temp[] = (float)number_format($line->wdf_with_us * $line->idf_with_us, 4);
            
            $tempData[] = $temp;
        } 
        
        $chart2->legend[] = __('Our text', 'wtb_idf_calculator');
        
        $chart2->data[] = array_merge(array(__('Keyword', 'wtb_idf_calculator')), $chart2->legend);
        foreach ($tempData as $i) {
            $chart2->data[] = $i;
        }
        
        return $chart2;
    }
    
    /**
     * return of keywords pbject array only array of keywords as string
     * @param array $topKeywords
     * @return array
     */
    function getKeywords($topKeywords)
    {
        $return = array();
        
        foreach ($topKeywords as $value) {
            $return[] = $value->keyword;
        }
        
        return $return;
    }
}