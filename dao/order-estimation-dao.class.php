<?php
class OrderEstimationDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getOrderEstimationById($id) {
        $order_estimation = new OrderEstimation();
        if (empty($id)) {
          return $order_estimation;
        }
        return $this->selectEntity($order_estimation, array("id = $id"));
    }
    
    public function getOrderEstimations($pagerOrder) {
        return $this->selectEntities(new OrderEstimation(), NULL, $pagerOrder);
    }
    
    public function addOrderEstimation($order_estimation) {
        if (empty($order_estimation)) {
          return;
        }
        return $this->insertEntity($order_estimation);
    }
    
    public function updateOrderEstimation($order_estimation, $id) {
        if (empty($order_estimation) || empty($id)) {
          return;
        }
        return $this->updateEntity($order_estimation, array("id = $id"));
    }
    
    public function deleteOrderEstimation($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new OrderEstimation(), array("id = $id"));
    }
}
?>
