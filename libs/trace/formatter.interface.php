<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

interface IFormatter {
    public function format(Event $event);
}
?>
