<?php

include '../include.php';

class OrderEstimationAction extends BaseAction {

    private $order_estimationService;
    
    function __construct() {
        parent::__construct();
        $this->order_estimationService = new OrderEstimationService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->order_estimationService->getOrderEstimationById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->order_estimationService->
                getOrderEstimations($this->getPagerOrder()));
        }
    }

    public function doPost(){
    }
}

run_admin('OrderEstimationAction');
?>
