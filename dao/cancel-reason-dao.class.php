<?php
class CancelReasonDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getCancelReasonById($id) {
        $cancel_reason = new CancelReason();
        if (empty($id)) {
          return $cancel_reason;
        }
        return $this->selectEntity($cancel_reason, array("id = $id"));
    }
    
    public function getCancelReasons($pagerOrder) {
        return $this->selectEntities(new CancelReason(), NULL, $pagerOrder);
    }
    
    public function addCancelReason($cancel_reason) {
        if (empty($cancel_reason)) {
          return;
        }
        return $this->insertEntity($cancel_reason);
    }
    
    public function updateCancelReason($cancel_reason, $id) {
        if (empty($cancel_reason) || empty($id)) {
          return;
        }
        return $this->updateEntity($cancel_reason, array("id = $id"));
    }
    
    public function deleteCancelReason($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new CancelReason(), array("id = $id"));
    }
}
?>
