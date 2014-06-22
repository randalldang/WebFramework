<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call-SqlEvent!');
}

class SqlEvent extends Event {
    public function __construct() {
        parent::__construct();
        $this->properties['sql_type'] = ''; 
        $this->properties['sql'] = '';
    }
    
    /**
     * 格式化该Event。
     *
     * @return String，格式化好的SQL语句，用于log和分析
     */
    public function toString() {
    	return $this->sql_type . ':' . $this->sql;
    }
}
?>