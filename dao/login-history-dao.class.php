<?php
class LoginHistoryDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getLoginHistoryById($id) {
        $login_history = new LoginHistory();
        if (empty($id)) {
          return $login_history;
        }
        return $this->selectEntity($login_history, array("id = $id"));
    }
    
    public function getLoginHistorys($pagerOrder) {
        return $this->selectEntities(new LoginHistory(), NULL, $pagerOrder);
    }
    
    public function addLoginHistory($login_history) {
        if (empty($login_history)) {
          return;
        }
        return $this->insertEntity($login_history);
    }
    
    public function updateLoginHistory($login_history, $id) {
        if (empty($login_history) || empty($id)) {
          return;
        }
        return $this->updateEntity($login_history, array("id = $id"));
    }
    
    public function deleteLoginHistory($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new LoginHistory(), array("id = $id"));
    }
}
?>
