<?php
class CourierCompanyDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getCourierCompanyById($id) {
        $courier_company = new CourierCompany();
        if (empty($id)) {
          return $courier_company;
        }
        return $this->selectEntity($courier_company, array("id = $id"));
    }
    
    public function getCourierCompanys($pagerOrder) {
        return $this->selectEntities(new CourierCompany(), NULL, $pagerOrder);
    }
    
    public function addCourierCompany($courier_company) {
        if (empty($courier_company)) {
          return;
        }
        return $this->insertEntity($courier_company);
    }
    
    public function updateCourierCompany($courier_company, $id) {
        if (empty($courier_company) || empty($id)) {
          return;
        }
        return $this->updateEntity($courier_company, array("id = $id"));
    }
    
    public function deleteCourierCompany($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new CourierCompany(), array("id = $id"));
    }
}
?>
