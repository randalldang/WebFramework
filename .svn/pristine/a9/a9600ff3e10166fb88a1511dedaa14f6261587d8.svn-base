<?php

class CancelReasonService extends BaseService {

    private $cancel_reasonDao;
    
    public function __construct(){
        parent::__construct();
        $this->cancel_reasonDao = new CancelReasonDao();
    }
    
    public function getCancelReasonById($id) {
        return $this->cancel_reasonDao->getCancelReasonById($id);
    }
    
    public function getCancelReasons($pagerOrder) {
        return $this->cancel_reasonDao->getCancelReasons($pagerOrder);
    }
    
    public function addCancelReason($cancel_reason) {
        return $this->cancel_reasonDao->addCancelReason($cancel_reason);
    }
    
    public function updateCancelReason($cancel_reason, $id) {
        return $this->cancel_reasonDao->updateCancelReason($cancel_reason, $id);
    }
    
    public function deleteCancelReason($id) {
        return $this->cancel_reasonDao->deleteCancelReason($id);
    }
}
?>
