<?php

class OrdersService extends BaseService {

    private $ordersDao;
    
    public function __construct(){
        parent::__construct();
        $this->ordersDao = new OrdersDao();
    }
    
    public function getOrdersById($id) {
        return $this->ordersDao->getOrdersById($id);
    }
    
    public function getOrderss($pagerOrder) {
        return $this->ordersDao->getOrderss($pagerOrder);
    }
    
    public function addOrders($orders) {
        return $this->ordersDao->addOrders($orders);
    }
    
    public function updateOrders($orders, $id) {
        return $this->ordersDao->updateOrders($orders, $id);
    }
    
    public function deleteOrders($id) {
        return $this->ordersDao->deleteOrders($id);
    }
}
?>
