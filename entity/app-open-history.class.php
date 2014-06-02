<?php
class AppOpenHistory extends Entity {
    public function __construct() {
        $this->p = array(
            'AppOpenId' => '',
            'Device' => '',
            'Province' => '',
            'City' => '',
            'District' => '',
            'OpenX' => '',
            'OpenY' => '',
            'AppType' => '',
            'OpenTime' => '',
        );
    }
}
?>
