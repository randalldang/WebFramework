<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

class MailAppender extends Appender {
    protected function writeLogMessage($message, Event $event) {
        
        $event_type = $event->type;
        if("ERROR" == strtoupper($event_type)) {
            
            // SMTP服务器设置
        	$host = var_get('smtp_server');
        	$auth = var_get('need_auth');
        	$user_name = var_get('smtp_user');
        	$user_password = var_get('smtp_password');
        	
        	// 邮件设置
        	$email_type = var_get('mail_to_cctv_manager/mail_type');
        	$email_from = var_get('mail_to_cctv_manager/mail_from');
        	$email_to = var_get('mail_to_cctv_manager/mail_to');
        	$email_sbuject = var_get('mail_to_cctv_manager/mail_subject');
        	
        	$smtp = new SmtpMail($host, $auth, $user_name, $user_password);
            $smtp->setDebug(false);
            $smtp->setSubject($this->getMailSubject($event));
            $smtp->setFrom($email_from);
            $smtp->addTo($email_to);
            $smtp->setMailType($email_type);
            
            // 信息回车换行格式化html
            if($email_type=='html') {
            	$message = str_replace("\r\n", '<br />', $message);
        	    $message = str_replace("\r", '<br />', $message);
        	    $message = str_replace("\n", '<br />', $message);
            }
            $smtp->setMimeMail($message);
            $smtp->send();
        }
    }
    
    private function getMailSubject(Event $event) {
    	$subject = "系统错误: ";
    	if ($event instanceof ExceptionEvent) {
    		$e = $event->cacheException;
    		if (NULL != $e) {
    			$subject .= $e->getMessage();
    		}
    	}
    	return $subject;
    }
}
?>
