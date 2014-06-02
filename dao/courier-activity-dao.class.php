<?php
class CourierActivityDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getCourierActivityById($id) {
        $courier_activity = new CourierActivity();
        if (empty($id)) {
          return $courier_activity;
        }
        return $this->selectEntity($courier_activity, array("id = $id"));
    }
    
    public function getCourierActivitys($pagerOrder) {
        return $this->selectEntities(new CourierActivity(), NULL, $pagerOrder);
    }
    
    public function addCourierActivity($courier_activity) {
        if (empty($courier_activity)) {
          return;
        }
        return $this->insertEntity($courier_activity);
    }
    
    public function updateCourierActivity($courier_activity, $id) {
        if (empty($courier_activity) || empty($id)) {
          return;
        }
        return $this->updateEntity($courier_activity, array("id = $id"));
    }
    
    public function deleteCourierActivity($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new CourierActivity(), array("id = $id"));
    }
}
?>
