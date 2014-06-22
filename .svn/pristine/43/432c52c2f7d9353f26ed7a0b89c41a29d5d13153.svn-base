<?php
class AppOpenHistoryDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getAppOpenHistoryById($id) {
        $app_open_history = new AppOpenHistory();
        if (empty($id)) {
          return $app_open_history;
        }
        return $this->selectEntity($app_open_history, array("id = $id"));
    }
    
    public function getAppOpenHistorys($pagerOrder) {
        return $this->selectEntities(new AppOpenHistory(), NULL, $pagerOrder);
    }
    
    public function addAppOpenHistory($app_open_history) {
        if (empty($app_open_history)) {
          return;
        }
        return $this->insertEntity($app_open_history);
    }
    
    public function updateAppOpenHistory($app_open_history, $id) {
        if (empty($app_open_history) || empty($id)) {
          return;
        }
        return $this->updateEntity($app_open_history, array("id = $id"));
    }
    
    public function deleteAppOpenHistory($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new AppOpenHistory(), array("id = $id"));
    }
}
?>
