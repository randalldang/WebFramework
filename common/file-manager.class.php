<?php
/**
 * Provides the functionalities to manage upload file.
 */
class FileManager {
    /**
     * The array copy of $_FILES.
     * @var array
     */
    private $file_data = array ();
    
    /**
     * Sets the member variable.
     */
    public function __construct() {
        $this->file_data = $_FILES;            
    }

    /**
     * Gets the file's extension name with the specified upload file control name.
     * @param string $name the upload file control name
     * @return string the uploaded file type
     */
    public function getFileType($name) {
        $type = NULL;

        if (isset($this->file_data[$name])) {
            $type = strtolower(trim($this->file_data[$name]['type']));
            //the following section is to fix the issue under IE that uses nonstandard MIME type
            if ('image/pjpeg' == $type) {
                $type = 'image/jpeg';
            }
            else if ('image/x-png' == $type) {
                $type = 'image/png';
            }
        }

        return $type;;
    }

    /**
     * Gets the file size according to the specified file name.
     * @param string $name the upload file control name
     * @return float file size
     */
    public function getFileSize($name) {
        return $this->file_data[$name]['size'];
    }

    /**
     * Validates the file format.
     * @param string $name upload file control name
     * @param array $format desired file format
     * @return boolean
     */
    public function fileFormatValidation($name, $format) {
        $file_type = $this->getFileType($name);
        $wrapped_format = array ();

        foreach ($format as $type) {
            $wrapped_format[] = strtolower($type);
        }
        $result = array_search($file_type, $wrapped_format) !== FALSE;

        return $result;
    }

    /**
     * Gets the original file name.
     * @param string $name upload file control name
     * @return string original file name
     */
    public function getOriginalName($name) {
        return isset($this->file_data[$name]['name']) ? $this->file_data[$name]['name'] : NULL;
    }

    /**
     * Uploads the file to the specified folder.
     * @param string $name the upload file control name
     * @param string $destination the destination folder path
     * @return string uploaded file's temp name
     */
    public function getUploadedName($name) {
          return $this->file_data[$name]['tmp'];
    }

    /**
     * Returns the file size by specified unit.
     * @param string $string gives the unit
     * @return string the files size with specified unit
     */
    public function getSizeByByte($string) {
        $return_value = NULL;

        switch (substr($string, -1, 1)) {
            case 'M':
                $return_value = intval($string) * 1024 * 1024;
            break;
            case 'K':
                $return_value = intval($string) * 1024;
            break;
            case 'B':
                switch (substr($string, -1, 2)) {
                    case 'MB':
                        $return_value = intval($string) * 1024 * 1024;
                    break;
                    case 'KB':
                        $return_value = intval($string) * 1024;
                    break;
                    default:
                        $return_value = 0;
                    break;
                }
            default:
                $return_value = 0;
            break;
        }

        return $return_value;
    }

    /**
     * Gets the limitation for uploaded file size based on PHP setting and system setting.
     * @param int $file_size the setting in system
     * @return int
     */
    public function getLimitSize($file_size) {
        $php_ini_filesize = $this->getSizeByByte(strtoupper(ini_get('upload_max_filesize')));
        $config_php_filesize = $this->getSizeByByte($file_size . 'K');

        return ($php_ini_filesize > $config_php_filesize) ? $config_php_filesize : $php_ini_filesize;
    }

    /**
     * Checks if the file is a valid image type.
     * @param string $name the file type name
     * @return boolean
     */
    function isImageType($name) {
        $allowed_image_type = array (
            'image/gif' => TRUE,
            'image/jpeg' => TRUE,
            'image/png' => TRUE
        );
        $file_type = $this->getFileType($name);        

        return array_key_exists($file_type, $allowed_image_type);
    }

    /**
     * Checks if the image size is under limitation.
     * @param string $name the file name
     * @param int $config_image_size the file size limitation setting in system
     * @return boolean
     */
    function isImageSize($name, $config_image_size) {
        return ($this->getFileSize($name) < $this->getLimitSize($config_image_size));
    }

    /**
     * Gets the uploaded file's path.
     * @param sting $name the file name
     * @return sting the file path
     */
    public function getFilePath($name) {
        return $this->file_data[$name]['tmp_name'];
    }

    /**
     * Gets the file's whole content.
     * @param string $name the file name
     * @return string the file's content
     */
    public function getFileContent($name) {
        $image_content = NULL;
        $file_name = $this->getFilePath($name);

        if (file_exists($file_name) && is_file($file_name)) {
            $fp = fopen($file_name, 'r');
            $image_content = fread($fp, filesize($file_name));
        }

        return $image_content;
    }
}
?>