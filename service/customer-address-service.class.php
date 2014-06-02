<?php

class CustomerAddressService extends BaseService {

    private $customer_addressDao;
    
    public function __construct(){
        parent::__construct();
        $this->customer_addressDao = new CustomerAddressDao();
    }
    
    public function getCustomerAddressById($id) {
        return $this->customer_addressDao->getCustomerAddressById($id);
    }
    
    public function getCustomerAddresss($pagerOrder) {
        return $this->customer_addressDao->getCustomerAddresss($pagerOrder);
    }
    
    public function addCustomerAddress($customer_address) {
        return $this->customer_addressDao->addCustomerAddress($customer_address);
    }
    
    public function updateCustomerAddress($customer_address, $id) {
        return $this->customer_addressDao->updateCustomerAddress($customer_address, $id);
    }
    
    public function deleteCustomerAddress($id) {
        return $this->customer_addressDao->deleteCustomerAddress($id);
    }
}
?>
