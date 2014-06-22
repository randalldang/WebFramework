<?php

class CouriersService extends BaseService {

    private $couriersDao;
    
    public function __construct(){
        parent::__construct();
        $this->couriersDao = new CouriersDao();
    }
    
    public function getCouriersById($id) {
        return $this->couriersDao->getCouriersById($id);
    }
    
    public function getCourierss($pagerOrder) {
        return $this->couriersDao->getCourierss($pagerOrder);
    }
    
    public function addCouriers($couriers) {
        return $this->couriersDao->addCouriers($couriers);
    }
    
    public function updateCouriers($couriers, $id) {
        return $this->couriersDao->updateCouriers($couriers, $id);
    }
    
    public function deleteCouriers($id) {
        return $this->couriersDao->deleteCouriers($id);
    }
}
?>
