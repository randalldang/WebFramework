<?php

include '../include.php';

class CouriersAction extends BaseAction {

    private $couriersService;
    
    function __construct() {
        parent::__construct();
        $this->couriersService = new CouriersService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->couriersService->getCouriersById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->couriersService->
                getCourierss($this->getPagerOrder()));
        }
    }

    public function doPost(){
        $couriers = new Couriers();
        $couriers->CourierId = $this->post->CourierId;
        $couriers->CourierCode = $this->post->CourierCode;
        $couriers->CourierName = $this->post->CourierName;
        $couriers->Password = $this->post->Password;
        $couriers->CompanyId = $this->post->CompanyId;
        $couriers->BranchName = $this->post->BranchName;
        $couriers->IsShow = $this->post->IsShow;
        $couriers->ManagerMobile = $this->post->ManagerMobile;
        $couriers->CourierType = $this->post->CourierType;
        $couriers->ServiceType = $this->post->ServiceType;
        $couriers->Avatar = $this->post->Avatar;
        $couriers->RegisterTime = $this->post->RegisterTime;
        $couriers->Status = $this->post->Status;
        $couriers->Remark = $this->post->Remark;
        $couriers->LastLoginTime = $this->post->LastLoginTime;
        $this->couriersService->addCouriers($couriers);       
    }
}

run('CouriersAction');
?>
