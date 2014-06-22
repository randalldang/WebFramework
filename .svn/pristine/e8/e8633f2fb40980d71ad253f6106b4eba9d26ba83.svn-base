<?php
class CustomerAddressDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getCustomerAddressById($id) {
        $customer_address = new CustomerAddress();
        if (empty($id)) {
          return $customer_address;
        }
        return $this->selectEntity($customer_address, array("id = $id"));
    }
    
    public function getCustomerAddresss($pagerOrder) {
        return $this->selectEntities(new CustomerAddress(), NULL, $pagerOrder);
    }
    
    public function addCustomerAddress($customer_address) {
        if (empty($customer_address)) {
          return;
        }
        return $this->insertEntity($customer_address);
    }
    
    public function updateCustomerAddress($customer_address, $id) {
        if (empty($customer_address) || empty($id)) {
          return;
        }
        return $this->updateEntity($customer_address, array("id = $id"));
    }
    
    public function deleteCustomerAddress($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new CustomerAddress(), array("id = $id"));
    }
}
?>
