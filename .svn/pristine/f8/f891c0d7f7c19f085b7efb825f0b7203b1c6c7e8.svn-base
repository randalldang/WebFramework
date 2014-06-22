<?php

class NoticeService extends BaseService {

    private $noticeDao;
    
    public function __construct(){
        parent::__construct();
        $this->noticeDao = new NoticeDao();
    }
    
    public function getNoticeById($id) {
        return $this->noticeDao->getNoticeById($id);
    }
    
    public function getNotices($pagerOrder) {
        return $this->noticeDao->getNotices($pagerOrder);
    }
    
    public function addNotice($notice) {
        return $this->noticeDao->addNotice($notice);
    }
    
    public function updateNotice($notice, $id) {
        return $this->noticeDao->updateNotice($notice, $id);
    }
    
    public function deleteNotice($id) {
        return $this->noticeDao->deleteNotice($id);
    }
}
?>
