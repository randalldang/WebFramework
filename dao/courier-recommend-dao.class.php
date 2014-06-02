<?php
class CourierRecommendDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getCourierRecommendById($id) {
        $courier_recommend = new CourierRecommend();
        if (empty($id)) {
          return $courier_recommend;
        }
        return $this->selectEntity($courier_recommend, array("id = $id"));
    }
    
    public function getCourierRecommends($pagerOrder) {
        return $this->selectEntities(new CourierRecommend(), NULL, $pagerOrder);
    }
    
    public function addCourierRecommend($courier_recommend) {
        if (empty($courier_recommend)) {
          return;
        }
        return $this->insertEntity($courier_recommend);
    }
    
    public function updateCourierRecommend($courier_recommend, $id) {
        if (empty($courier_recommend) || empty($id)) {
          return;
        }
        return $this->updateEntity($courier_recommend, array("id = $id"));
    }
    
    public function deleteCourierRecommend($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new CourierRecommend(), array("id = $id"));
    }
}
?>
