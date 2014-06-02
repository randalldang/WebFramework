<?php
class CourierRecommend extends Entity {
    public function __construct() {
        $this->p = array(
            'RecommendId' => '',
            'CourierId' => '',
            'ReceiveMobile' => '',
            'RecommendType' => '',
            'RecommendContext' => '',
            'RecommendTime' => '',
        );
    }
}
?>
