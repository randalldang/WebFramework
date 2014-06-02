<?php
class OrderSerial extends Entity {
    public function __construct() {
        $this->p = array(
            'SerialId' => '',
            'SerialCode' => '',
            'OrderId' => '',
            'Status' => '',
            'CreateTime' => '',
            'CourierId' => '',
        );
    }
}
?>
