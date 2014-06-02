<?php
class OrderLocationDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getOrderLocationById($id) {
        $order_location = new OrderLocation();
        if (empty($id)) {
          return $order_location;
        }
        return $this->selectEntity($order_location, array("id = $id"));
    }
    
    public function getOrderLocations($pagerOrder) {
        return $this->selectEntities(new OrderLocation(), NULL, $pagerOrder);
    }
    
    public function addOrderLocation($order_location) {
        if (empty($order_location)) {
          return;
        }
        return $this->insertEntity($order_location);
    }
    
    public function updateOrderLocation($order_location, $id) {
        if (empty($order_location) || empty($id)) {
          return;
        }
        return $this->updateEntity($order_location, array("id = $id"));
    }
    
    public function deleteOrderLocation($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new OrderLocation(), array("id = $id"));
    }
}
?>
