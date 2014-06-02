<?php
class LoginHistory extends Entity {
    public function __construct() {
        $this->p = array(
            'HistoryId' => '',
            'UserId' => '',
            'Device' => '',
            'UserType' => '',
            'LoginTime' => '',
            'LoginIp' => '',
            'NetworkType' => '',
            'AppType' => '',
            'HistoryX' => '',
            'HistoryY' => '',
            'IMEI' => '',
            'AppVersion' => '',
        );
    }
}
?>
