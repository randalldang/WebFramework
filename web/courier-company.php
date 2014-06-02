<?php

include '../include.php';

class CourierCompanyAction extends BaseAction {

    private $courier_companyService;
    
    function __construct() {
        parent::__construct();
        $this->courier_companyService = new CourierCompanyService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->courier_companyService->getCourierCompanyById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->courier_companyService->
                getCourierCompanys($this->getPagerOrder()));
        }
    }

    public function doPost(){
        $courier_company = new CourierCompany();
        $courier_company->CompanyId = $this->post->CompanyId;
        $courier_company->CompanyName = $this->post->CompanyName;
        $courier_company->Address = $this->post->Address;
        $courier_company->ServicePhone = $this->post->ServicePhone;
        $courier_company->CreateTime = $this->post->CreateTime;
        $courier_company->CreateUserId = $this->post->CreateUserId;
        $courier_company->Status = $this->post->Status;
        $this->courier_companyService->addCourierCompany($courier_company);       
    }
}

run_admin('CourierCompanyAction');
?>
