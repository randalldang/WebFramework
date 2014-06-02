<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call:file-operator!');
}

/**
 * This class is used to operate/upload a file.
 */
class FileOperator {
    /**
     * Current file name.
     * @var string
     */
    protected $name;

    /**
     * Sets current file.
     * @param string $name the name of the file to be operated on
     */
    public function __construct($name) {
        if (!is_file($name)) {
            $temp_handle = fopen($name, 'x');
            fclose($temp_handle);
        }
        $this->name = $name;
    }

    /**
     * Unsets file.
     */
    public function __destruct() {
        unset($this->name);
    }

    /**
     * Deletes the file.
     * @return void
     */
    public function remove() {
        unlink($this->name);
    }

    /**
     * Copies a file to this one.
     * @param string $source the source file to be copied
     * @return void
     */
    public function copy($source) {
        copy($source, $this->name);
    }

    /**
     * 上传图片．
     * @param Array $temp_file_name
     * @param Array $temp_file_type
     * @param Array $temp_file_size
     * @param Array $temp_file_path
     * @param Array $temp_file_errorCode
     * @return String 图片路径
     */
    public static function uploadIMG($temp_file_name, $temp_file_type, $temp_file_size, $temp_file_path, $temp_file_errorCode) {
        //TODO
        $attachment = new AttachmentOperator();
        $attachment->setIMGTempFileInfo($temp_file_name, $temp_file_type, $temp_file_size, $temp_file_path, $temp_file_errorCode);
        return $attachment->uploadIMGAttachment();
    }

    /**
     * 上传视频．
     * @param Array $temp_file_name
     * @param Array $temp_file_type
     * @param Array $temp_file_size
     * @param Array $temp_file_path
     * @param Array $temp_file_errorCode
     * @param unknown_type $video_uuid
     * @return Boolean 数据库操作成功／失败 TRUE/FALSE
     */
    public static function uploadVideo($temp_file_name, $temp_file_type, $temp_file_size, $temp_file_path, $temp_file_errorCode, $video_uuid) {
        //TODO
        $attachment = new AttachmentOperator();
        $attachment->setVideoTempFileInfo($temp_file_name, $temp_file_type, $temp_file_size, $temp_file_path, $temp_file_errorCode);
        return $attachment->uploadVideoAttachment($video_uuid);
    }

    /**
     * Renames current file to another one as specified.
     * @param string $new_name new file name to be renamed
     * @return void
     */
    public function rename($new_name) {
        if (rename($this->name, $new_name)) {
            $this->name = $new_name;
        }
    }

    /**
     * Gets the file size.
     * @return int the file's size
     */
    public function size() {
        return filesize($this->name);
    }

    /**
     * Fetches an object of FileStream.
     * @param string $mode the open mode on the file stream
     * @return FileStream
     */
    public function fetchFileStream($mode = 'r') {
        return new FileStream($this->name, $mode);
    }
}
?>