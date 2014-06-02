<?php

include '../include.php';

class CustomerShareAction extends BaseAction {

    private $customer_shareService;
    
    function __construct() {
        parent::__construct();
        $this->customer_shareService = new CustomerShareService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->customer_shareService->getCustomerShareById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->customer_shareService->
                getCustomerShares($this->getPagerOrder()));
        }
    }

    public function doPost(){
    }
}

run_admin('CustomerShareAction');
?>
