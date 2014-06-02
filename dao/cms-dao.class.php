<?php
class CmsDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getCmsById($id) {
        $cms = new Cms();
        if (empty($id)) {
          return $cms;
        }
        return $this->selectEntity($cms, array("id = $id"));
    }
    
    public function getCmss($pagerOrder) {
        return $this->selectEntities(new Cms(), NULL, $pagerOrder);
    }
    
    public function addCms($cms) {
        if (empty($cms)) {
          return;
        }
        return $this->insertEntity($cms);
    }
    
    public function updateCms($cms, $id) {
        if (empty($cms) || empty($id)) {
          return;
        }
        return $this->updateEntity($cms, array("id = $id"));
    }
    
    public function deleteCms($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new Cms(), array("id = $id"));
    }
}
?>
