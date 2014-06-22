<?php

class AppVersionService extends BaseService {

    private $app_versionDao;
    
    public function __construct(){
        parent::__construct();
        $this->app_versionDao = new AppVersionDao();
    }
    
    public function getAppVersionById($id) {
        return $this->app_versionDao->getAppVersionById($id);
    }
    
    public function getAppVersions($pagerOrder) {
        return $this->app_versionDao->getAppVersions($pagerOrder);
    }
    
    public function addAppVersion($app_version) {
        return $this->app_versionDao->addAppVersion($app_version);
    }
    
    public function updateAppVersion($app_version, $id) {
        return $this->app_versionDao->updateAppVersion($app_version, $id);
    }
    
    public function deleteAppVersion($id) {
        return $this->app_versionDao->deleteAppVersion($id);
    }
}
?>
