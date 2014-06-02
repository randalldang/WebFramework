<?php

class LoginHistoryService extends BaseService {

    private $login_historyDao;
    
    public function __construct(){
        parent::__construct();
        $this->login_historyDao = new LoginHistoryDao();
    }
    
    public function getLoginHistoryById($id) {
        return $this->login_historyDao->getLoginHistoryById($id);
    }
    
    public function getLoginHistorys($pagerOrder) {
        return $this->login_historyDao->getLoginHistorys($pagerOrder);
    }
    
    public function addLoginHistory($login_history) {
        return $this->login_historyDao->addLoginHistory($login_history);
    }
    
    public function updateLoginHistory($login_history, $id) {
        return $this->login_historyDao->updateLoginHistory($login_history, $id);
    }
    
    public function deleteLoginHistory($id) {
        return $this->login_historyDao->deleteLoginHistory($id);
    }
}
?>
