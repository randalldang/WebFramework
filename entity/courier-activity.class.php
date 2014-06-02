<?php
class CourierActivity extends Entity {
    public function __construct() {
        $this->p = array(
            'ActivityId' => '',
            'CourierId' => '',
            'StartTime' => '',
            'EndTime' => '',
            'StartX' => '',
            'StartY' => '',
            'EndX' => '',
            'EndY' => '',
        );
    }
}
?>
