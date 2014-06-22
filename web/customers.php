<?php

include '../include.php';

class CustomersAction extends BaseAction {

    private $customersService;
    
    function __construct() {
        parent::__construct();
        $this->customersService = new CustomersService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->customersService->getCustomersById($id)->toJson();
        } else {    
            $searchKey = $this->get->searchKey;
            echo $this->toJsonPager($this->customersService->
                getCustomerss($searchKey, $this->getPagerOrder()));
        }
    }

    public function doPost(){
    }
}

run('CustomersAction');
?>
