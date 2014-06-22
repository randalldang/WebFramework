<?php

class OrderLocationService extends BaseService {

    private $order_locationDao;
    
    public function __construct(){
        parent::__construct();
        $this->order_locationDao = new OrderLocationDao();
    }
    
    public function getOrderLocationById($id) {
        return $this->order_locationDao->getOrderLocationById($id);
    }
    
    public function getOrderLocations($pagerOrder) {
        return $this->order_locationDao->getOrderLocations($pagerOrder);
    }
    
    public function addOrderLocation($order_location) {
        return $this->order_locationDao->addOrderLocation($order_location);
    }
    
    public function updateOrderLocation($order_location, $id) {
        return $this->order_locationDao->updateOrderLocation($order_location, $id);
    }
    
    public function deleteOrderLocation($id) {
        return $this->order_locationDao->deleteOrderLocation($id);
    }
}
?>
