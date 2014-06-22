<?php

class AppOpenHistoryService extends BaseService {

    private $app_open_historyDao;
    
    public function __construct(){
        parent::__construct();
        $this->app_open_historyDao = new AppOpenHistoryDao();
    }
    
    public function getAppOpenHistoryById($id) {
        return $this->app_open_historyDao->getAppOpenHistoryById($id);
    }
    
    public function getAppOpenHistorys($pagerOrder) {
        return $this->app_open_historyDao->getAppOpenHistorys($pagerOrder);
    }
    
    public function addAppOpenHistory($app_open_history) {
        return $this->app_open_historyDao->addAppOpenHistory($app_open_history);
    }
    
    public function updateAppOpenHistory($app_open_history, $id) {
        return $this->app_open_historyDao->updateAppOpenHistory($app_open_history, $id);
    }
    
    public function deleteAppOpenHistory($id) {
        return $this->app_open_historyDao->deleteAppOpenHistory($id);
    }
}
?>
