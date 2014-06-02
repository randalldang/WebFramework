<?php
class ServiceRegionDao extends BaseDao {

    public function __construct() {
        parent::__construct();
    }
    
    public function getServiceRegionById($id) {
        $service_region = new ServiceRegion();
        if (empty($id)) {
          return $service_region;
        }
        return $this->selectEntity($service_region, array("id = $id"));
    }
    
    public function getServiceRegions($pagerOrder) {
        return $this->selectEntities(new ServiceRegion(), NULL, $pagerOrder);
    }
    
    public function addServiceRegion($service_region) {
        if (empty($service_region)) {
          return;
        }
        return $this->insertEntity($service_region);
    }
    
    public function updateServiceRegion($service_region, $id) {
        if (empty($service_region) || empty($id)) {
          return;
        }
        return $this->updateEntity($service_region, array("id = $id"));
    }
    
    public function deleteServiceRegion($id) {
        if (empty($id)) {
          return;
        }
        return $this->deleteEntities(new ServiceRegion(), array("id = $id"));
    }
}
?>
