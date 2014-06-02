<?php

class CourierCompanyService extends BaseService {

    private $courier_companyDao;
    
    public function __construct(){
        parent::__construct();
        $this->courier_companyDao = new CourierCompanyDao();
    }
    
    public function getCourierCompanyById($id) {
        return $this->courier_companyDao->getCourierCompanyById($id);
    }
    
    public function getCourierCompanys($pagerOrder) {
        return $this->courier_companyDao->getCourierCompanys($pagerOrder);
    }
    
    public function addCourierCompany($courier_company) {
        return $this->courier_companyDao->addCourierCompany($courier_company);
    }
    
    public function updateCourierCompany($courier_company, $id) {
        return $this->courier_companyDao->updateCourierCompany($courier_company, $id);
    }
    
    public function deleteCourierCompany($id) {
        return $this->courier_companyDao->deleteCourierCompany($id);
    }
}
?>
