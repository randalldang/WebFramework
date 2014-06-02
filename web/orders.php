<?php

include '../include.php';

class OrdersAction extends BaseAction {

    private $ordersService;
    
    function __construct() {
        parent::__construct();
        $this->ordersService = new OrdersService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->ordersService->getOrdersById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->ordersService->
                getOrderss($this->getPagerOrder()));
        }
    }

    public function doPost(){
    }
}

run_admin('OrdersAction');
?>
