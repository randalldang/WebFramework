<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

/**
 * Utils function to get the calling stack.
 */
function backtrace() {
    $debug_trace = debug_backtrace();
    
    array_reverse($debug_trace);
    $debug_info = array();
    
    foreach ($debug_trace as $key=>$value) {  
        $func = isset($value['function']) ? $value['function']:'';
        $file = isset($value['file']) ? $value['file'] : '';
        $line = isset($value['line']) ? $value['line'] : '';
        $args = $value['args'];
        $class = isset($value['class']) ? $value['class'] : '';
        $type = isset($value['type']) ? $value['type'] : '';
        
        $arg_info = '';
        
        if (count($args) > 0) {
            foreach ($args as $arg_name => $arg_value) {
                $arg_info .= "$arg_name = $arg_value, ";
            }
        }
        
        if ($class) {
            $debug_info[] = "#$key {$class} $type {$func}($arg_info) at [$file : $line]";
        }
        else {
            $debug_info[] = "#$key $func($arg_info) at [$file : $line]";
        }
    }  
    
    return $debug_info;
}