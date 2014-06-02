<?php
class Advice extends Entity {
    public function __construct() {
        $this->p = array(
            'AdviceId' => '',
            'UserId' => '',
            'Context' => '',
            'UserType' => '',
            'CreateTime' => '',
            'AdviceStatus' => '',
            'UpdateUserId' => '',
            'UpdateTime' => '',
            'UpdateContext' => '',
        );
    }
}
?>
