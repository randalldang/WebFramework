<?php
class OrdersDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getOrdersById($id) {
        $orders = new Orders();
        if (empty($id)) {
          return $orders;
        }
        return $this->selectEntity($orders, array("id = $id"));
    }
    
    public function getOrderss($pagerOrder) {
        return $this->selectEntities(new Orders(), NULL, $pagerOrder);
    }
    
    public function addOrders($orders) {
        if (empty($orders)) {
          return;
        }
        return $this->insertEntity($orders);
    }
    
    public function updateOrders($orders, $id) {
        if (empty($orders) || empty($id)) {
          return;
        }
        return $this->updateEntity($orders, array("id = $id"));
    }
    
    public function deleteOrders($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new Orders(), array("id = $id"));
    }
}
?>
