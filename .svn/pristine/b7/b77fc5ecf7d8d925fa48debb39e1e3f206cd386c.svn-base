<?php

class CustomerShareService extends BaseService {

    private $customer_shareDao;
    
    public function __construct(){
        parent::__construct();
        $this->customer_shareDao = new CustomerShareDao();
    }
    
    public function getCustomerShareById($id) {
        return $this->customer_shareDao->getCustomerShareById($id);
    }
    
    public function getCustomerShares($pagerOrder) {
        return $this->customer_shareDao->getCustomerShares($pagerOrder);
    }
    
    public function addCustomerShare($customer_share) {
        return $this->customer_shareDao->addCustomerShare($customer_share);
    }
    
    public function updateCustomerShare($customer_share, $id) {
        return $this->customer_shareDao->updateCustomerShare($customer_share, $id);
    }
    
    public function deleteCustomerShare($id) {
        return $this->customer_shareDao->deleteCustomerShare($id);
    }
}
?>
