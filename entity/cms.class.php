<?php
class Cms extends Entity {
    public function __construct() {
        $this->p = array(
            'CMSID' => '',
            'CMSCode' => '',
            'CMSContext' => '',
            'CreateTime' => '',
            'CreateUserId' => '',
            'EditTime' => '',
            'EditUserId' => '',
        );
    }
}
?>
