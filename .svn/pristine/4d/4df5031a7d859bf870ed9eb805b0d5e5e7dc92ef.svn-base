<?php

class CourierActivityService extends BaseService {

    private $courier_activityDao;
    
    public function __construct(){
        parent::__construct();
        $this->courier_activityDao = new CourierActivityDao();
    }
    
    public function getCourierActivityById($id) {
        return $this->courier_activityDao->getCourierActivityById($id);
    }
    
    public function getCourierActivitys($pagerOrder) {
        return $this->courier_activityDao->getCourierActivitys($pagerOrder);
    }
    
    public function addCourierActivity($courier_activity) {
        return $this->courier_activityDao->addCourierActivity($courier_activity);
    }
    
    public function updateCourierActivity($courier_activity, $id) {
        return $this->courier_activityDao->updateCourierActivity($courier_activity, $id);
    }
    
    public function deleteCourierActivity($id) {
        return $this->courier_activityDao->deleteCourierActivity($id);
    }
}
?>
