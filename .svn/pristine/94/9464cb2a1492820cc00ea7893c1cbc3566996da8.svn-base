<?php

class CmsService extends BaseService {

    private $cmsDao;
    
    public function __construct(){
        parent::__construct();
        $this->cmsDao = new CmsDao();
    }
    
    public function getCmsById($id) {
        return $this->cmsDao->getCmsById($id);
    }
    
    public function getCmss($pagerOrder) {
        return $this->cmsDao->getCmss($pagerOrder);
    }
    
    public function addCms($cms) {
        return $this->cmsDao->addCms($cms);
    }
    
    public function updateCms($cms, $id) {
        return $this->cmsDao->updateCms($cms, $id);
    }
    
    public function deleteCms($id) {
        return $this->cmsDao->deleteCms($id);
    }
}
?>
