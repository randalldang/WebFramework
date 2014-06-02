<?php

include '../include.php';

class OrderLocationAction extends BaseAction {

    private $order_locationService;
    
    function __construct() {
        parent::__construct();
        $this->order_locationService = new OrderLocationService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->order_locationService->getOrderLocationById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->order_locationService->
                getOrderLocations($this->getPagerOrder()));
        }
    }

    public function doPost(){
    }
}

run_admin('OrderLocationAction');
?>
