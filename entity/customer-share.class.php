<?php
class CustomerShare extends Entity {
    public function __construct() {
        $this->p = array(
            'ShareId' => '',
            'CustomerId' => '',
            'ShareType' => '',
            'SharePath' => '',
            'ShareContext' => '',
            'ShareTime' => '',
        );
    }
}
?>
