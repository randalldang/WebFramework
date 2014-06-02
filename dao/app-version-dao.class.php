<?php
class AppVersionDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getAppVersionById($id) {
        $app_version = new AppVersion();
        if (empty($id)) {
          return $app_version;
        }
        return $this->selectEntity($app_version, array("id = $id"));
    }
    
    public function getAppVersions($pagerOrder) {
        return $this->selectEntities(new AppVersion(), NULL, $pagerOrder);
    }
    
    public function addAppVersion($app_version) {
        if (empty($app_version)) {
          return;
        }
        return $this->insertEntity($app_version);
    }
    
    public function updateAppVersion($app_version, $id) {
        if (empty($app_version) || empty($id)) {
          return;
        }
        return $this->updateEntity($app_version, array("id = $id"));
    }
    
    public function deleteAppVersion($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new AppVersion(), array("id = $id"));
    }
}
?>
