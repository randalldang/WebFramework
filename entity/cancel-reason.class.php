<?php
class CancelReason extends Entity {
    public function __construct() {
        $this->p = array(
            'ReasonId' => '',
            'Reason' => '',
            'DisplayOrder' => '',
            'CreateUserId' => '',
            'CreateTime' => '',
            'Status' => '',
        );
    }
}
?>
