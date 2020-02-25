<?php

if (!class_exists('WP_List_Table')) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/************************** CREATE A PACKAGE CLASS *****************************
 *******************************************************************************
 */
class Stop_Keywords_List_Table extends WP_List_Table {
    
    function __construct()
    {
        global $status, $page;
                
        //Set parent defaults
        parent::__construct( array(
            'singular'  => __('Stopword', 'wtb_idf_calculator'),     //singular name of the listed records
            'plural'    => __('Stopwords', 'wtb_idf_calculator'),    //plural name of the listed records
            'ajax'      => false        //does this table support ajax?
        ) );
        
    }
    
    
    /** ************************************************************************
     * @param array $item A singular item (one full row's worth of data)
     * @param array $column_name The name/slug of the column to be processed
     * @return string Text or HTML to be placed inside the column <td>
     **************************************************************************/
    function column_default($item, $column_name)
    {
        switch($column_name){
            case 'language':
            case 'keyword':
            case 'id':
                return $item->$column_name;
            case 'created':
                return date(__('Y-m-d H:i', 'wtb_idf_calculator'), strtotime($item->$column_name));
            default:
                return print_r($item,true); //Show the whole array for troubleshooting purposes
        }
    }
    
        
    /** 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     */
    function column_keyword($item)
    {
        //Build row actions
        $actions = array(
            'edit'      => sprintf('<a href="?page=%s&action=%s&stopkeyword=%s&orderby=%s&order=%s">Edit</a>',$_REQUEST['page'],'edit',
                    $item->id, 
                    !empty($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'id',
                    !empty($_REQUEST['order']) ? $_REQUEST['order'] : 'asc'
                    ),
            'delete'    => sprintf('<a href="?page=%s&action=%s&stopkeyword=%s&orderby=%s&order=%s">Delete</a>',$_REQUEST['page'],'delete',
                    $item->id,
                    !empty($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'id',
                    !empty($_REQUEST['order']) ? $_REQUEST['order'] : 'asc'
                    ),
        );
        
        //Return the title contents
        return sprintf('%1$s %2$s',
            $item->keyword,
            $this->row_actions($actions)
        );
    }
    
    /** 
     * @see WP_List_Table::::single_row_columns()
     * @param array $item A singular item (one full row's worth of data)
     * @return string Text to be placed inside the column <td> (movie title only)
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="%1$s[]" value="%2$s" />',
            $this->_args['singular'],
            $item->id
        );
    }
    
    
    /**
     * @see WP_List_Table::::single_row_columns()
     * @return array An associative array containing column information: 'slugs'=>'Visible Titles'
     **************************************************************************/
    function get_columns()
    {
        $columns = array(
            'cb'        => '<input type="checkbox" />', //Render a checkbox instead of text
            'keyword'    => __('Stopword', 'wtb_idf_calculator'),
//            'language'     => __('Language', 'wtb_idf_calculator'),
            'created'    => __('Created', 'wtb_idf_calculator'),
            'id'    => __('ID', 'wtb_idf_calculator'),
        );
        return $columns;
    }
    
    function get_sortable_columns() 
    {
		return array(
            'id' => array('id', false),
            'keyword' => array('keyword', false),
//            'language' => array('language', false),
            'created' => array('created', false)
        );
	}
    
    function get_bulk_actions() 
    {
        $actions = array(
            'delete'    => 'Delete'
        );
        return $actions;
    }
    
    function process_bulk_action() 
    {
        if ( 'delete' === $this->current_action() ) {
            $post_ids = array_map( 'absint', (array) $_REQUEST['stopword'] );
            
            $table = new wtb_idf_calculator_tables();
            foreach ($post_ids as $id) {
                $table->stopwords->deleteById($id);
            }
        }
    }
    
    /** ************************************************************************
     * @uses $this->_column_headers
     * @uses $this->items
     * @uses $this->get_columns()
     * @uses $this->get_sortable_columns()
     * @uses $this->get_pagenum()
     * @uses $this->set_pagination_args()
     **************************************************************************/
    function prepare_items()
    {
        $per_page = 40;
        
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columns, $hidden, $sortable);
        
        
        $this->process_bulk_action();
        
        
        $tables = new wtb_idf_calculator_tables;
        
        $current_page = $this->get_pagenum();
        
        $total_items = $tables->stopwords->getTotalCount();
        
        $sort = 
            (!empty($_REQUEST['orderby']) ? $_REQUEST['orderby'] : 'id') . ' ' .
            (!empty($_REQUEST['order']) ? $_REQUEST['order'] : 'asc'); 
        
        $this->items = $tables->stopwords->getListOfStopKeywords($per_page, (($current_page-1)*$per_page), $sort);
        
        
        $this->set_pagination_args( array(
            'total_items' => $total_items,                  //WE have to calculate the total number of items
            'per_page'    => $per_page,                     //WE have to determine how many items to show on a page
            'total_pages' => ceil($total_items/$per_page)   //WE have to calculate the total number of pages
        ) );
    }
    
}