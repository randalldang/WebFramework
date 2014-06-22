<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call:file-stream!');
}

/**
 * Wrapper class for file stream handle.
 */
class FileStream {
    /**
     * File stream handle.
     * @var resource
     */
    protected $handle;

    /**
     * Opens the file handle, read only by default.
     * @param string $name file name to be opened
     * @param string $mode open mode
     */
    public function __construct($name, $mode = 'r', $handle = NULL) {
        if (is_resource($handle)) {
            $this->handle = $handle;
        }
        else {
            $this->handle = fopen($name, $mode);
        }
        $this->handle = fopen($name, $mode);
    }

    /**
     * Closes file handle.
     * @see close()
     */
    public function __destruct() {
        $this->close();
    }

    /**
     * Closes file handle.
     * @return void
     */
    public function close() {
        if (is_resource($this->handle)) {
            fclose($this->handle);
        }
        unset($this->handle);
    }

    /**
     * Gets current file handle.
     * @return resource handler of the file stream
     */
    public function getHandle() {
        return $this->handle;
    }

    /**
     * Reads the file content in binary-safe mode.
     * @param int $length the length bytes to be read
     * @return string content read out from the file
     */
    public function read($length) {
        return fread($this->handle, $length);
    }
    
    /**
     * Reads all the remainder content of the file in binary-safe mode.
     * @param int $bucket_size the bytes number to be read each time
     * @return string content read out from the file
     */
    public function readAll($bucket_size = 4096) {
        $contents = "";
        while (!$this->eof()) {
            $contents .= $this->read($bucket_size);
        }

        return $contents;
    }

    /**
     * Gets one line from current handle.
     * @param int $length the string length to be read out
     * @return string one line of the file
     */
    public function getLine($length = 0) {
        $content = NULL;

        if (0 < $length) {
            $content = fgets($this->handle, $length);
        }
        else {
            $content = fgets($this->handle);
        }

        return $content;
    }

    /**
     * Writes into the file in binary-safe mode.
     * @param string $content content to be written in
     * @param int $length writing stops after length bytes have been written
     * @return int the bytes have been written
     */
    public function write($content, $length = NULL) {
        $written_bytes = 0;
        
        if (is_null($length)) {
            $written_bytes = fwrite($this->handle, $content);
        }
        else {
            $written_bytes = fwrite($this->handle, $content, $length);
        }

        return $written_bytes;
    }

    /**
     * Checks if the line end.
     * @return boolean
     */
    public function eof() {
        return feof($this->handle);
    }

    /**
     * Rewinds the position of file handle.
     * @return boolean
     */
    public function rewind() {
        rewind($this->handle);
    }
}
?>