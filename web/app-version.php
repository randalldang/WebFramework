<?php

include '../include.php';

class AppVersionAction extends BaseAction {

    private $app_versionService;
    
    function __construct() {
        parent::__construct();
        $this->app_versionService = new AppVersionService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->app_versionService->getAppVersionById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->app_versionService->
                getAppVersions($this->getPagerOrder()));
        }
    }

    public function doPost(){
        $app_version = new AppVersion();
        $app_version->VesionId = $this->post->VesionId;
        $app_version->Vesion = $this->post->Vesion;
        $app_version->AppType = $this->post->AppType;
        $app_version->CreateTime = $this->post->CreateTime;
        $app_version->AppFile = $this->post->AppFile;
        $app_version->IsUpgrade = $this->post->IsUpgrade;
        $this->app_versionService->addAppVersion($app_version);       
    }
}

run_admin('AppVersionAction');
?>
