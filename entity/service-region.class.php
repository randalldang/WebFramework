<?php
class ServiceRegion extends Entity {
    public function __construct() {
        $this->p = array(
            'RegionId' => '',
            'ParentId' => '',
            'RegionName' => '',
            'DisplayOrder' => '',
            'Depth' => '',
            'status' => '',
        );
    }
}
?>
