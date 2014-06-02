<?php

include '../include.php';

class ServiceRegionAction extends BaseAction {

    private $service_regionService;
    
    function __construct() {
        parent::__construct();
        $this->service_regionService = new ServiceRegionService();
    }

    function doGet() {
        $id = $this->get->id;
        if (!empty($id)) {
            echo $this->service_regionService->getServiceRegionById($id)->toJson();
        } else {         
            echo $this->toJsonArray($this->service_regionService->
                getServiceRegions($this->getPagerOrder()));
        }
    }

    public function doPost(){
        $service_region = new ServiceRegion();
        $service_region->RegionId = $this->post->RegionId;
        $service_region->ParentId = $this->post->ParentId;
        $service_region->RegionName = $this->post->RegionName;
        $service_region->DisplayOrder = $this->post->DisplayOrder;
        $service_region->Depth = $this->post->Depth;
        $service_region->status = $this->post->status;
        $this->service_regionService->addServiceRegion($service_region);       
    }
}

run_admin('ServiceRegionAction');
?>
