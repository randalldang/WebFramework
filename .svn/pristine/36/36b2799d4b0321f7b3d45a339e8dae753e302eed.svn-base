<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

class Logger implements ILogger {
    private static $appender_cache = array();

    public function logDebug(Event $event) {
        $event->type = 'Debug';

        $this->logEvent($event);
    }

    public function logInfo(Event $event) {
        $event->type = 'Info';

        $this->logEvent($event);
    }

    public function logWarn(Event $event) {
        $event->type = 'Warn';

        $this->logEvent($event);
    }

    public function logError(Event $event) {
        $event->type = 'Error';

        $this->logEvent($event);
    }

    protected function logEvent(Event $event) {
        $cache_key = $event->type . '/' . get_class($event);
        $log_appenders = array();

        if (!array_key_exists($cache_key, self::$appender_cache)) {
            $log_appenders = AppenderFactory::getAppenders($event);
            self::$appender_cache[$cache_key] = $log_appenders;
        }

        $log_appenders = self::$appender_cache[$cache_key];
        foreach ($log_appenders as $appender) {
            //call_user_func will call the appender->write($event)
            if (class_exists($appender, TRUE)) {
                $appender_object = new $appender;
                if (!call_user_func(array($appender_object, 'write'), $event)) {
                    //TODO: Log the wrong configuration

                }
            }
        }
    }
}
?>