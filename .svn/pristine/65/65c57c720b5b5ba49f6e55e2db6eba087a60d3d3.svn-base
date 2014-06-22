<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

/*
 * Created on 2009-2-9
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class FileAppender extends Appender {
    protected function writeLogMessage($message, Event $event) {

        $file_path = var_get('system_log/filepath', 'logs/');
        
        $file_type = $event->type;

        try {
            $current_time_day = date('M_d_Y');
            $dir = $file_path . '/' . $current_time_day;
            if (!is_dir($dir)) {
                mkdir($dir, 0700);
            }
            
            $newline_type = var_get('log_sys_env/newline', 'unix');
            $newline = "\n";
            if ('win' == $newline_type) {
            	$newline = "\r\n";
            }
            $message .= $newline . $newline;
            
            $file_name = $file_path. '/' . $current_time_day . '/' . $file_type . '_' .$this->fileNameType($event) . '_' . $current_time_day . '.log';
            file_put_contents($file_name, $message, FILE_APPEND);
        }
        catch (Exception $e) {
            //TODO
        }
    }
    
    private function fileNameType(Event $event) {
        $fileNameType = get_class($event);

        if (substr_compare($fileNameType, 'Event', 0, strlen($fileNameType))) {
            $fileNameType = substr($fileNameType, 0, strlen($fileNameType)-5);
        } 
        return $fileNameType;
    }
}
?>
