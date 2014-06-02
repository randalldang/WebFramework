<?php
/*
 * Created on 2008-4-8
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
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
?>
