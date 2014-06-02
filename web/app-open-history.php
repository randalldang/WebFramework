<?php

include '../include.php';

class AppOpenHistoryAction extends BaseAction {

    private $app_open_historyService;
    
    function __construct() {
        parent::__construct();
        $this->app_open_historyService = new AppOpenHistoryService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->app_open_historyService->getAppOpenHistoryById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->app_open_historyService->
                getAppOpenHistorys($this->getPagerOrder()));
        }
    }

    public function doPost(){
    }
}

run_admin('AppOpenHistoryAction');
?>
