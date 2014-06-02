<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

class FormatterFactory {
    protected static $formatter_cache = array();
    
    public static function getFormatter(Event $event, $appenderType) {
        $log_type = $event->type;
        $event_type = get_class($event);       
        $cache_key = $log_type . '/' . $event_type;
        
        if (!array_key_exists($cache_key, self::$formatter_cache)) {       
            $log_config = var_get('log_settings');
            self::$formatter_cache[$cache_key] = array();
            
            if(array_key_exists($event_type, $log_config)) {
                $type_appender = $log_config[$event_type];             
                
                if(array_key_exists($log_type, $type_appender)) {
                    $event_appender = $type_appender[$log_type];

                    if(array_key_exists($appenderType, $event_appender)) {
                        self::$formatter_cache[$cache_key] = $event_appender[$appenderType];
                    }
                }
            }
        }
        
        return self::$formatter_cache[$cache_key];
    }
}
?>