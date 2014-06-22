<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

 class BizEventFormatter implements IFormatter {
     public function format(Event $event) {
         if($event instanceof BizEvent) {
             $new_lines = array (
            'win' => "\r\n",
            'unix' => "\n",
            'mac' => "\r"
            );
           
           $new_line = $new_lines[var_get('log_sys_env/newline', 'win')];          
             return $event->toString()
             ." {$event->userId}"
             ." {$event->ip}"
             ." {$event->bizCode}"
             ." {$event->bizState}"
             .$new_line;
         } 
     }
 }
?>
