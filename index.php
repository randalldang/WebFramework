<?php

include 'include.php';

define('PRIVILEGE', 1);
class IndexAction extends BaseAction {
		
    function __construct() {
        parent::__construct();
    }

    function doGet() {
        echo file_get_contents("index.html");
    }

    public function doPost(){
            
    }

}

run('IndexAction');
?>
