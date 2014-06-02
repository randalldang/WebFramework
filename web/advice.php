<?php

include '../include.php';

class AdviceAction extends BaseAction {
    
    private $adviceService;
    
    function __construct() {
        parent::__construct();
        $this->adviceService = new AdviceService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->adviceService->getAdviceById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->adviceService->
                getAdvices($this->getPagerOrder()));
        }
    }

    public function doPost(){
    }
}

run_admin('AdviceAction');
?>
