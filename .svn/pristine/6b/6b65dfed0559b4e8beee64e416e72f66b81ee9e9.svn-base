<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call: smtpmail!');
}

class SmtpMail
{
    //
    private $_host;                                   //smtp server's ip
    private $_auth;                                   //auth
    private $_user;                                   //username
    private $_pass;                                   //smtp password
    private $_debug = false;                          //debug
    private $_magicFile;                              //mime path
    private $_Subject;                                //subject
    private $_From;                                   //from
    private $_To = array();                           //to
    private $_Cc = array();                           //cc
    private $_Bcc = array();                          //bcc
    private $_attachment = array();                   //attachment
    private $_mailtype = 'html';                      //trpe('text','html')
    private $_charset = 'utf-8';                      //charset
    private $_mimemail;                               //body
    private $_socket;                                 //smtp connect
    private $_port = 25;                              //smtp port
    private $_timeout = 30;                           //timeout

    //
    public function __construct($host, $auth = false, $user = '', $pass = '')
    {
        $this->_host = $host;
        $this->_auth = $auth;
        $this->_user = $user;
        $this->_pass = $pass;
    }

    //if debug
    public function setDebug($boolDebug)
    {
        $this->_debug = $boolDebug;
    }

    //path
    public function setMagicFile($filename)
    {
        $this->_magicFile = $filename;
    }

    //subject
    public function setSubject($str)
    {
        $this->_Subject = $str;
    }

    //from
    public function setFrom($email)
    {
        $email = $this->stripComment($email);
        $this->_From = $email;
    }

    //to
    public function addTo($email)
    {
        $email = $this->stripComment($email);
        $this->_To[] = $email;
    }

    //cc
    public function addCc($email)
    {
        $email = $this->stripComment($email);
        $this->_Cc[] = $email;
    }

    //bcc
    public function addBcc($email)
    {
        $email = $this->stripComment($email);
        $this->_Bcc[] = $email;
    }

    //attachment
    public function addAttachment($filename)
    {
        if(is_file($filename)) $this->_attachment[] = $filename;
    }

    //type
    public function setMailType($type)
    {
        $this->_mailtype = $type;
    }

    //charset
    public function setCharset($strCharset)
    {
        $this->_charset = $strCharset;
    }

    //body
    public function setMimeMail($str)
    {
        $boundary = uniqid('');

        $this->_mimemail = "From: =?UTF-8?B?" . base64_encode('TESTING') . "?= <no-reply@testing.com>\r\n";
        $this->_mimemail .= "Reply-To: " . $this->_From . "\r\n";
        $this->_mimemail .= "To: " . implode(",", $this->_To) . "\r\n";

        if(count($this->_Cc)) $this->_mimemail .= "Cc: " . implode(",", $this->_Cc) . "\r\n";
        if(count($this->_Bcc)) $this->_mimemail .= "Bcc: " . implode(",", $this->_Bcc) . "\r\n";

        $this->_mimemail .= "Subject: =?UTF-8?B?" . base64_encode($this->_Subject) . "?=\r\n";
        $this->_mimemail .= "Message-ID: <" . time() .  "." . $this->_From . ">\r\n";
        $this->_mimemail .= "Date: " . date("r") . "\r\n";
        $this->_mimemail .= "MIME-Version: 1.0\r\n";
        $this->_mimemail .= "Content-type: multipart/mixed; boundary=\"" . $boundary . "\"\r\n\r\n";
        $this->_mimemail .= "--" . $boundary . "\r\n";

        if($this->_mailtype == 'text')
        {
            $this->_mimemail .= "Content-type: text/plain; charset=\"" . $this->_charset . "\"\r\n\r\n";
        }
        else if($this->_mailtype == 'html')
        {
            $this->_mimemail .= "Content-type: text/html; charset=\"" . $this->_charset . "\"\r\n\r\n";
        }

       $this->_mimemail .= $str . "\r\n\r\n";

        if(count($this->_attachment))
        {
            //$finfo = finfo_open(FILEINFO_MIME);
			$finfo = new finfo(FILEINFO_MIME, $this->_magicFile);
            foreach($this->_attachment as $k => $filename)
            {
                $f = @fopen($filename, 'r');
                if(!$f) continue;

                $mimetype = $finfo->file(realpath($filename));
                $attachment = @fread($f, filesize($filename));
                $attachment = base64_encode($attachment);
                $attachment = chunk_split($attachment);

                $this->_mimemail .= "--" . $boundary . "\r\n";
                $this->_mimemail .= "Content-type: " . $mimetype . "; name=" . basename($filename) . "\r\n";
                $this->_mimemail .= "Content-disposition: attachment; filename=" . basename($filename) . "\r\n";
                $this->_mimemail .= "Content-transfer-encoding: base64\r\n\r\n";
                $this->_mimemail .= $attachment . "\r\n\r\n";

                unset($f);
                unset($mimetype);
                unset($attachment);
            }
        }

        $this->_mimemail .= "--" . $boundary . "--";
    }

    public function send()
    {
        $arrToEmail = $this->_To;
        if(count($this->_Cc)) $arrToEmail = array_merge($arrToEmail, $this->_Cc);
        if(count($this->_Bcc)) $arrToEmail = array_merge($arrToEmail, $this->_Bcc);

        $this->connect();
        $this->sendCMD('HELO localhost');
        $this->smtpOK();

        if($this->_auth)
        {
            $this->sendCMD('AUTH LOGIN ' . base64_encode($this->_user));
            $this->smtpOK();
            $this->sendCMD(base64_encode($this->_pass));
            $this->smtpOK();
        }

        $this->sendCMD('MAIL FROM:<' . $this->_From . '>');
        $this->smtpOK();

        foreach($arrToEmail as $k => $toEmail)
        {
            $this->sendCMD('RCPT TO:<' . $toEmail . '>');
            $this->smtpOK();
        }

        $this->sendCMD('DATA');
        $this->smtpOK();
        $this->sendCMD($this->_mimemail);
        $this->smtpOK();
        $this->sendCMD('.');
        $this->smtpOK();

        $this->disconnect();
    }

    //connect smtp server
    private function connect()
    {
        $fp = @fsockopen($this->_host, $this->_port, $errno, $errstr, $this->_timeout);

        if(!$fp)
        {
            if($this->_debug) $this->showMessage('Error:connot connect to smtpserver!');
            die();
        }
        else
        {
            $this->_socket = $fp;
            if($this->_debug) $this->showMessage('connect to smtp server...successfully');
        }
    }

    //close smtp connection
    private function disconnect()
    {
        $this->sendCMD('QUIT');
        @fclose($this->_socket);
        $this->_socket = null;
        if($this->_debug) $this->showMessage('disconnect connection with smtp server');
    }

    // show message
    private function showMessage($msg)
    {
        echo "[" . date("H:i") . "]" . $msg . "<br/>";
    }

    //send commend
    private function sendCMD($cmd)
    {
        @fputs($this->_socket, $cmd . "\r\n");
        if($this->_debug) $this->showMessage($cmd);
    }

    // is successfully
    private function smtpOK()
    {
        $res = str_replace("\r\n", "", @fgets($this->_socket, 512));

        if(ereg("^[23]", $res))
        {
            if($this->_debug) $this->showMessage('request successfully');
        }
        else
        {
            if($this->_debug) $this->showMessage('Error:server back info <' . $res . '>');
            $this->disconnect();
        }
    }

    //
    private function stripComment($email)
    {
        $comment = "\([^()]*\)";

        while(ereg($comment, $email))
        {
            $email = ereg_replace($comment, "", $email);
        }

        $email = ereg_replace("([ \t\r\n])+", "", $email);
        $email = ereg_replace("^.*<(.+)>.*$", "\1", $email);

        return $email;
    }
}

class MailTemplate {
    var $subject;
    var $body;

    public function __construct($mail_type, $data_array) {
        $this->getSubjectBody($mail_type, $data_array);
    }

    private function getSubjectBody($mail_type, $data_array) {
    	$file_stream = new FileStream($mail_type);
        $content = $file_stream->readAll();
        $xml = new SimpleXMLElement($content);
        $content = (array)$xml;
        $this->subject = $content['subject'];
        $this->body = $content['body'];
        foreach($data_array as $key=>$value) {
            $this->body = str_replace('{$' . $key . '}', $value, $this->body);
        }
    }
}

class UserManager {

    private static $single;
    public static function Single() {
        if (!isset(UserManager :: $single)) {
        	$single = new UserManager();
        }

        return $single;
    }

    public function getUserByEmail($user_email) {
        global $link;

        $str_sql_user = "SELECT * FROM `olympicstv_view_user_info` WHERE email='$user_email';";
        $resource = mysql_query($str_sql_user);

        if (mysql_error($link)) {
            throw new DBException(mysql_error($link));
        }
        return mysql_fetch_object($resource);
    }

    public function read_file() {
        $handle = fopen('/data/wwwroot/web/sns/email/email.txt', "r");
        $content = fread($handle, filesize('/data/wwwroot/web/sns/email/email.txt'));
        fclose($handle);
        return $content;
    }
    public function getAllUserEmail($i) {
        $link = mysql_connect('192.168.115.99', 'sa', ')P:?1qaz');
        mysql_select_db('olympicstv');
        mysql_query("SET NAMES utf8");


        $emails = $this->read_file();
        $emails = substr($emails, 0, -1);
        $emails = str_replace(',', '\',\'', $emails);
        $emails = trim($emails);
        $emails = '\'' . $emails . '\'';

        $str_sql_user = "SELECT `email`, `nick_name` FROM `olympicstv_view_user_info` WHERE `type` = 'TVUser' AND `activated` = 'yes' AND `email` NOT IN ($emails) ORDER BY `email` ASC LIMIT " . $i * 1000 . ',' . 1000;
//print_r($str_sql_user);
        $resource = mysql_query($str_sql_user);
        $user_email_array = array();
        while ($user_email = mysql_fetch_object($resource)) {
        	$user_email_array[] = $user_email;
        }

        if (mysql_error($link)) {
            echo mysql_error($link);die;
        }
        return $user_email_array;
    }
}

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
     * @param resource $handle file stream handle making former parameters be ignored when it's valid.
     */
    public function __construct($name, $mode = 'r', $handle = NULL) {
        if (is_resource($handle)) {
            $this->handle = $handle;
        }
        else {
            $this->handle = fopen($name, $mode);
        }
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
