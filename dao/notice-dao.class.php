<?php
class NoticeDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getNoticeById($id) {
        $notice = new Notice();
        if (empty($id)) {
          return $notice;
        }
        return $this->selectEntity($notice, array("id = $id"));
    }
    
    public function getNotices($pagerOrder) {
        return $this->selectEntities(new Notice(), NULL, $pagerOrder);
    }
    
    public function addNotice($notice) {
        if (empty($notice)) {
          return;
        }
        return $this->insertEntity($notice);
    }
    
    public function updateNotice($notice, $id) {
        if (empty($notice) || empty($id)) {
          return;
        }
        return $this->updateEntity($notice, array("id = $id"));
    }
    
    public function deleteNotice($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new Notice(), array("id = $id"));
    }
}
?>
