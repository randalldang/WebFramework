<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

class StringFormatter implements IFormatter {
    public function format(Event $event) {
        return $event->toString();//TODO
    }
}
?>