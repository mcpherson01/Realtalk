<?php

/**
 * abstract class for other classes to communicate DB
 * Please do not laugh! :)
 */
class wtb_idf_calculator_table {

    /**
     * @var string
     */
    protected $table_name;
    
    /**
     * @var wtb_idf_calculator_tables
     */
    protected $parent;
    
    /**
     * constructor
     * @param wtb_idf_calculator_tables $parent
     */
    function __construct(wtb_idf_calculator_tables $parent) 
    {
        $this->parent = $parent;
    }
    
    /**
     * get name of table
     * @global wpdb $wpdb
     * @return string
     */
    protected function getTableName()
	{
		global $wpdb;
		
		return $wpdb->prefix . $this->table_name;
	}
    
    /**
     * create table to database
     * @param string $sql
     */
    protected function createTable($sql)
	{
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}
    
    /**
     * delete item by id
     * @param int $id
     */
    public function deleteById($id)
    {
        $this->delete(array('id' => $id));
    }
    
    /**
     * delete items by where condition
     * @global wpdb $wpdb
     * @param array $where
     * @return bool
     */
    public function delete($where)
    {
        global $wpdb;
		return $wpdb->delete($this->getTableName(), $where);
    }
}