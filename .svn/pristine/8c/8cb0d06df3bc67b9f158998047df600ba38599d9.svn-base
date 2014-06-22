<?php
class CourierTrackingDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getCourierTrackingById($id) {
        $courier_tracking = new CourierTracking();
        if (empty($id)) {
          return $courier_tracking;
        }
        return $this->selectEntity($courier_tracking, array("id = $id"));
    }
    
    public function getCourierTrackings($pagerOrder) {
        return $this->selectEntities(new CourierTracking(), NULL, $pagerOrder);
    }
    
    public function addCourierTracking($courier_tracking) {
        if (empty($courier_tracking)) {
          return;
        }
        return $this->insertEntity($courier_tracking);
    }
    
    public function updateCourierTracking($courier_tracking, $id) {
        if (empty($courier_tracking) || empty($id)) {
          return;
        }
        return $this->updateEntity($courier_tracking, array("id = $id"));
    }
    
    public function deleteCourierTracking($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new CourierTracking(), array("id = $id"));
    }
}
?>
