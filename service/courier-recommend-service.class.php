<?php

class CourierRecommendService extends BaseService {

    private $courier_recommendDao;
    
    public function __construct(){
        parent::__construct();
        $this->courier_recommendDao = new CourierRecommendDao();
    }
    
    public function getCourierRecommendById($id) {
        return $this->courier_recommendDao->getCourierRecommendById($id);
    }
    
    public function getCourierRecommends($pagerOrder) {
        return $this->courier_recommendDao->getCourierRecommends($pagerOrder);
    }
    
    public function addCourierRecommend($courier_recommend) {
        return $this->courier_recommendDao->addCourierRecommend($courier_recommend);
    }
    
    public function updateCourierRecommend($courier_recommend, $id) {
        return $this->courier_recommendDao->updateCourierRecommend($courier_recommend, $id);
    }
    
    public function deleteCourierRecommend($id) {
        return $this->courier_recommendDao->deleteCourierRecommend($id);
    }
}
?>
