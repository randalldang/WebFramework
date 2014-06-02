<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call:attachment-exception!');
}

/**
 * 这个类用来封装文件上传的异常。
 */
class AttachmentException extends Exception {
    public $error_code;

    /**
     * Constructs an exception object with overridden location by specified file name and line number.
     * @param string $message the error message
     * @param int $errcode the error code
     * @param string $file the file name
     * @param int $line the line number error occurs
     */
    public function __construct(&$message, &$errcode, &$file, &$line) {
        parent::__construct($message);
        $this->file = $file;
        $this->line = $line;
        $this->error_code = $errcode;
    }
}
?>