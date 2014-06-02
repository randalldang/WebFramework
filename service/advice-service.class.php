<?php

class AdviceService extends BaseService {
    
    private $adviceDao;
    
    public function __construct(){
        parent::__construct();
        $this->adviceDao = new AdviceDao();
    }
    
    public function getAdviceById($id) {
        return $this->adviceDao->getAdviceById($id);
    }
    
    public function getAdvices($pagerOrder) {
        return $this->adviceDao->getAdvices($pagerOrder);
    }
    
    public function addAdvice($advice) {
        return $this->adviceDao->addAdvice($advice);
    }
    
    public function updateAdvice($advice, $id) {
        return $this->adviceDao->updateAdvice($advice, $id);
    }
    
    public function deleteAdvice($id) {
        return $this->adviceDao->deleteAdvice($id);
    }
}
?>
