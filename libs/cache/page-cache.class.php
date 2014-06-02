<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call: page-cache!');
}

class PageCache extends Cache {

    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    public function get($key, $default = null) {
        
    }
    
    public function has($key) {
        
    }
    
    public function set($key, $data, $lifetime = null) {
        
    }
    
    public function remove($key) {
        
    }
    
    public function removePattern($pattern) {
        
    }
    
    public function clean($mode = self::ALL) {
        
    }
    
    public function getTimeout($key) {
        
    }
    
    public function getLastModified($key) {
        
    }
}
?>