<?php
class CustomersDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getCustomersById($id) {
        $customers = new Customers();
        if (empty($id)) {
          return $customers;
        }
        return $this->selectEntity($customers, array("CustomerId = $id"));
    }
    
    public function getCustomerss($searchKey, $pagerOrder) {
        $customer = new Customers();
        $conditions = null;

        if (strlen($searchKey) > 0) {
            $conditions = array("CustomerCode = '$searchKey'");
        }
        return new EntityPager($this->selectEntities($customer, $conditions, $pagerOrder)
            , $this->getTotal($customer, $conditions));
    }
    
    public function addCustomers($customers) {
        if (empty($customers)) {
          return;
        }
        return $this->insertEntity($customers);
    }
    
    public function updateCustomers($customers, $id) {
        if (empty($customers) || empty($id)) {
          return;
        }
        return $this->updateEntity($customers, array("id = $id"));
    }
    
    public function deleteCustomers($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new Customers(), array("id = $id"));
    }
}
?>
