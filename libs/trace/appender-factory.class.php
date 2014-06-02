<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

class AppenderFactory {
    protected static $appender_cache = array();

    public static function getAppenders(Event $event) {
        $log_type = $event->type;
        $event_type = get_class($event);
        $cache_key = $log_type . '/' .$event_type;

        // If event is not exists in local cache, is retrieved from GLOBAL config var.
        if (!array_key_exists($cache_key, self::$appender_cache)) {
            $log_config = var_get('log_settings');
            self::$appender_cache[$cache_key] = array();

            if(array_key_exists($event_type, $log_config)) {
                $type_appender = $log_config[$event_type];

                if(array_key_exists($log_type, $type_appender)) {
                    self::$appender_cache[$cache_key] = array_keys($type_appender[$log_type]);
                }
            }
        }

        return self::$appender_cache[$cache_key];
    }

}
?>