<?php
class OrderLocation extends Entity {
    public function __construct() {
        $this->p = array(
            'LocationId' => '',
            'LocationType' => '',
            'LocationProvince' => '',
            'LocationCity' => '',
            'LocationDistrict' => '',
            'LocationX' => '',
            'LocationY' => '',
            'LocationAddress' => '',
        );
    }
}
?>
