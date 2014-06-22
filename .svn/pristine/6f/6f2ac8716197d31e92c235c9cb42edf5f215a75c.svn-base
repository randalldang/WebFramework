<?php

class OrderSerialService extends BaseService {

    private $order_serialDao;
    
    public function __construct(){
        parent::__construct();
        $this->order_serialDao = new OrderSerialDao();
    }
    
    public function getOrderSerialById($id) {
        return $this->order_serialDao->getOrderSerialById($id);
    }
    
    public function getOrderSerials($pagerOrder) {
        return $this->order_serialDao->getOrderSerials($pagerOrder);
    }
    
    public function addOrderSerial($order_serial) {
        return $this->order_serialDao->addOrderSerial($order_serial);
    }
    
    public function updateOrderSerial($order_serial, $id) {
        return $this->order_serialDao->updateOrderSerial($order_serial, $id);
    }
    
    public function deleteOrderSerial($id) {
        return $this->order_serialDao->deleteOrderSerial($id);
    }
}
?>
