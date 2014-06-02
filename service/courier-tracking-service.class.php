<?php

class CourierTrackingService extends BaseService {

    private $courier_trackingDao;
    
    public function __construct(){
        parent::__construct();
        $this->courier_trackingDao = new CourierTrackingDao();
    }
    
    public function getCourierTrackingById($id) {
        return $this->courier_trackingDao->getCourierTrackingById($id);
    }
    
    public function getCourierTrackings($pagerOrder) {
        return $this->courier_trackingDao->getCourierTrackings($pagerOrder);
    }
    
    public function addCourierTracking($courier_tracking) {
        return $this->courier_trackingDao->addCourierTracking($courier_tracking);
    }
    
    public function updateCourierTracking($courier_tracking, $id) {
        return $this->courier_trackingDao->updateCourierTracking($courier_tracking, $id);
    }
    
    public function deleteCourierTracking($id) {
        return $this->courier_trackingDao->deleteCourierTracking($id);
    }
}
?>
