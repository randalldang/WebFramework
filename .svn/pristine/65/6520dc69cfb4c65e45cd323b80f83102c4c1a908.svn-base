<?php
class CustomerShareDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getCustomerShareById($id) {
        $customer_share = new CustomerShare();
        if (empty($id)) {
          return $customer_share;
        }
        return $this->selectEntity($customer_share, array("id = $id"));
    }
    
    public function getCustomerShares($pagerOrder) {
        return $this->selectEntities(new CustomerShare(), NULL, $pagerOrder);
    }
    
    public function addCustomerShare($customer_share) {
        if (empty($customer_share)) {
          return;
        }
        return $this->insertEntity($customer_share);
    }
    
    public function updateCustomerShare($customer_share, $id) {
        if (empty($customer_share) || empty($id)) {
          return;
        }
        return $this->updateEntity($customer_share, array("id = $id"));
    }
    
    public function deleteCustomerShare($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new CustomerShare(), array("id = $id"));
    }
}
?>
