<?php
class OrderEstimation extends Entity {
    public function __construct() {
        $this->p = array(
            'EstimationId' => '',
            'OrderId' => '',
            'CustomerId' => '',
            'Score' => '',
            'EstimationTime' => '',
            'Remark' => '',
        );
    }
}
?>
