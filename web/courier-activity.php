<?php

include '../include.php';

class CourierActivityAction extends BaseAction {

    private $courier_activityService;
    
    function __construct() {
        parent::__construct();
        $this->courier_activityService = new CourierActivityService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->courier_activityService->getCourierActivityById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->courier_activityService->
                getCourierActivitys($this->getPagerOrder()));
        }
    }

    public function doPost(){
    }
}

run_admin('CourierActivityAction');
?>
