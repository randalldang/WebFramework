<?php

include '../include.php';

class CancelReasonAction extends BaseAction {

    private $cancel_reasonService;
    
    function __construct() {
        parent::__construct();
        $this->cancel_reasonService = new CancelReasonService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->cancel_reasonService->getCancelReasonById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->cancel_reasonService->
                getCancelReasons($this->getPagerOrder()));
        }
    }

    public function doPost(){
    }
}

run_admin('CancelReasonAction');
?>
