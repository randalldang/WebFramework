<?php

include '../include.php';

class CourierRecommendAction extends BaseAction {

    private $courier_recommendService;
    
    function __construct() {
        parent::__construct();
        $this->courier_recommendService = new CourierRecommendService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->courier_recommendService->getCourierRecommendById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->courier_recommendService->
                getCourierRecommends($this->getPagerOrder()));
        }
    }

    public function doPost(){
    }
}

run_admin('CourierRecommendAction');
?>
