<?php

include '../include.php';

class CourierTrackingAction extends BaseAction {

    private $courier_trackingService;
    
    function __construct() {
        parent::__construct();
        $this->courier_trackingService = new CourierTrackingService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->courier_trackingService->getCourierTrackingById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->courier_trackingService->
                getCourierTrackings($this->getPagerOrder()));
        }
    }

    public function doPost(){
    }
}

run_admin('CourierTrackingAction');
?>
