<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

abstract class Appender {
    
    public function write(Event $event) {
        $formatter = $this->getFormatter($event);

        $log_message = $formatter->format($event);

        $this->writeLogMessage($log_message, $event);
    }

    protected function getFormatter(Event $event) {
        $formatter = FormatterFactory::getFormatter($event, (string)get_class($this));

        if (class_exists($formatter, TRUE)) {
            return new $formatter;
        }
        else {
            return new StringFormatter();
        }
    }

    protected abstract function writeLogMessage($log_message, Event $event);
}
?>