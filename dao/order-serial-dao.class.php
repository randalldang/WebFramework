<?php
class OrderSerialDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getOrderSerialById($id) {
        $order_serial = new OrderSerial();
        if (empty($id)) {
          return $order_serial;
        }
        return $this->selectEntity($order_serial, array("id = $id"));
    }
    
    public function getOrderSerials($pagerOrder) {
        return $this->selectEntities(new OrderSerial(), NULL, $pagerOrder);
    }
    
    public function addOrderSerial($order_serial) {
        if (empty($order_serial)) {
          return;
        }
        return $this->insertEntity($order_serial);
    }
    
    public function updateOrderSerial($order_serial, $id) {
        if (empty($order_serial) || empty($id)) {
          return;
        }
        return $this->updateEntity($order_serial, array("id = $id"));
    }
    
    public function deleteOrderSerial($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new OrderSerial(), array("id = $id"));
    }
}
?>
