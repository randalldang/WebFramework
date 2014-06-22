<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

/*
 * Created on 2009-2-13
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 class ExceptionEventFormatter implements IFormatter {
     public function format(Event $event) {
         if($event instanceof ExceptionEvent) {    
             $new_lines = array (
             'win' => "\r\n",
             'unix' => "\n",
             'mac' => "\r"
            );
           
           $new_line = $new_lines[var_get('log_sys_env/newline', 'win')];  
                   
             $e = $event->cacheException;
             $print_exception = $event->toString() . $new_line
             . get_class($e) . " caught: " . $new_line
             . "File(" . $e->getLine() . "): " . $e->getFile() . " Error(" . $e->getCode() . "): " . $e->getMessage() .$new_line 
             . $e->getTraceAsString() . $new_line. $new_line;
             return $print_exception;
         }
     }
 }
?>
