<?php

class OrderEstimationService extends BaseService {

    private $order_estimationDao;
    
    public function __construct(){
        parent::__construct();
        $this->order_estimationDao = new OrderEstimationDao();
    }
    
    public function getOrderEstimationById($id) {
        return $this->order_estimationDao->getOrderEstimationById($id);
    }
    
    public function getOrderEstimations($pagerOrder) {
        return $this->order_estimationDao->getOrderEstimations($pagerOrder);
    }
    
    public function addOrderEstimation($order_estimation) {
        return $this->order_estimationDao->addOrderEstimation($order_estimation);
    }
    
    public function updateOrderEstimation($order_estimation, $id) {
        return $this->order_estimationDao->updateOrderEstimation($order_estimation, $id);
    }
    
    public function deleteOrderEstimation($id) {
        return $this->order_estimationDao->deleteOrderEstimation($id);
    }
}
?>
