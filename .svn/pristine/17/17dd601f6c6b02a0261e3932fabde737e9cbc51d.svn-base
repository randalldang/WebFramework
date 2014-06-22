<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call:directory-operator!');
}

/**
 * This class is used to do general operations on directory.
 */
class DirectoryOperator {
    /**
     * Directory path.
     * @var string
     */
    protected $path;

    /**
     * Gets the directory path.
     * @param string $path current directory path
     */
    public function __construct($path = '.') {
        if (!is_dir($path)) {
            mkdir($path);
        }
        $this->path = $path;
    }

    /**
     * Unsets path.
     */
    public function __destruct() {
        unset($this->path);
    }

    /**
     * Deletes directory.
     * @return void
     */
    public function remove() {
        rmdir($this->path);
    }

    /**
     * Renames the directory.
     * @param string $name new directory name
     * @return void
     */
    public function rename($name) {
        if (rename($this->path, $name)) {
            $this->path = $name;
        }
    }

    /**
     * Fetches a directory Object.
     * @return object an instance of dir
     */
    public function fetchDir() {
        return dir($this->path);
    }
}
?>