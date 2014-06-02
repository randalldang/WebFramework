<?php
class AdviceDao extends BaseDao {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getAdviceById($id) {
        $advice = new Advice();
        if (empty($id)) {
          return $advice;
        }
        return $this->selectEntity($advice, array("id = $id"));
    }
    
    public function getAdvices($pagerOrder) {
        return $this->selectEntities(new Advice(), NULL, $pageOrder);
    }
    
    public function addAdvice($advice) {
        if (empty($advice)) {
          return;
        }
        return $this->insertEntity($advice);
    }
    
    public function updateAdvice($advice, $id) {
        if (empty($advice) || empty($id)) {
          return;
        }
        return $this->updateEntity($advice, array("id = $id"));
    }
    
    public function deleteAdvice($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new Advice(), array("id = $id"));
    }
}
?>
