<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

class LogFactory {
    private static $instance;
    
    public static function getLogger() {
        //TODO: initialize the ILogger according to the configuration
        if (!isset(self::$instance)) {
            self::$instance = new Logger();
        }
        return self::$instance;
    }
}
?>