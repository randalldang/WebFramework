<?php

class CustomersService extends BaseService {

    private $customersDao;
    
    public function __construct(){
        parent::__construct();
        $this->customersDao = new CustomersDao();
    }
    
    public function getCustomersById($id) {
        return $this->customersDao->getCustomersById($id);
    }
    
    public function getCustomerss($pagerOrder) {
        return $this->customersDao->getCustomerss($pagerOrder);
    }
    
    public function addCustomers($customers) {
        return $this->customersDao->addCustomers($customers);
    }
    
    public function updateCustomers($customers, $id) {
        return $this->customersDao->updateCustomers($customers, $id);
    }
    
    public function deleteCustomers($id) {
        return $this->customersDao->deleteCustomers($id);
    }
}
?>
