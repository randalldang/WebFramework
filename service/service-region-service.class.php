<?php

class ServiceRegionService extends BaseService {

    private $service_regionDao;
    
    public function __construct(){
        parent::__construct();
        $this->service_regionDao = new ServiceRegionDao();
    }
    
    public function getServiceRegionById($id) {
        return $this->service_regionDao->getServiceRegionById($id);
    }
    
    public function getServiceRegions($pagerOrder) {
        return $this->service_regionDao->getServiceRegions($pagerOrder);
    }
    
    public function addServiceRegion($service_region) {
        return $this->service_regionDao->addServiceRegion($service_region);
    }
    
    public function updateServiceRegion($service_region, $id) {
        return $this->service_regionDao->updateServiceRegion($service_region, $id);
    }
    
    public function deleteServiceRegion($id) {
        return $this->service_regionDao->deleteServiceRegion($id);
    }
}
?>
