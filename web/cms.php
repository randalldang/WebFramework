<?php

include '../include.php';

class CmsAction extends BaseAction {

    private $cmsService;
    
    function __construct() {
        parent::__construct();
        $this->cmsService = new CmsService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->cmsService->getCmsById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->cmsService->
                getCmss($this->getPagerOrder()));
        }
    }

    public function doPost(){
        $cms = new Cms();
        $cms->CMSID = $this->post->CMSID;
        $cms->CMSCode = $this->post->CMSCode;
        $cms->CMSContext = $this->post->CMSContext;
        $cms->CreateTime = $this->post->CreateTime;
        $cms->CreateUserId = $this->post->CreateUserId;
        $cms->EditTime = $this->post->EditTime;
        $cms->EditUserIdNULL = $this->post->EditUserIdNULL;
        $this->cmsService->addCms($cms);       
    }
}

run_admin('CmsAction');
?>
