<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

 class SystemFormatter implements IFormatter {
     public function format(Event $event) {

         if($event instanceof SystemEvent) {            
             $new_lines = array (
            'win' => "\r\n",
            'unix' => "\n",
            'mac' => "\r"
            );
           
           $new_line = $new_lines[var_get('log_sys_env/newline', 'win')]; 
            
             return 
                $event->toString() 
                . " {$event->ip}" 
                . " {$event->userId}"
                . " {$event->sessionId}"  
                . " {$event->url}"
                . " {$event->referer}" 
                . " {$event->responseTime}"
                . " {$event->userAgent}"
                . $new_line . $new_line;
         }
     }
 }
?>
