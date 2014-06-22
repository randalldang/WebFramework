<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call:global-function!');
}
define('QUERY_REGEXP', '/(%d|%s|%%|%f|%b|%n)/');

function validate_remote_request() {
    $refer_page = Common::getReferPage();
    if (!var_get('system_debugging') && FALSE === strstr($refer_page, var_get('host_secret', 'geefull.com'))) {
        //从未知的链接过来的请求，拒绝，记录客户端IP
//        die('Invalid call!');
    }
}

/**
 * Converts all PHP errors to an exception thrown as {@link PHPException}.
 * @return void
 */
function hook_error_as_exception() {
    if (get_system_debugging_status()) {
        set_error_handler('throw_error_as_exception', E_ALL & ~E_NOTICE);
    }
    else {
        set_error_handler('throw_error_as_exception', E_WARNING);
    }
}

/**
 * 过滤掉不需要静态化的链接。
 * @param String 页面模块名字。
 * @return 如果当前页面需要静态化，返回TRUE, 否则返回FALSE.
 */
function filter_url($module) {
    $urls_to_be_ignored = var_get('urls_to_be_ignored', NULL);
    if (NULL != $urls_to_be_ignored) {
        if (array_key_exists($module, $urls_to_be_ignored) && $urls_to_be_ignored{$module}) {
            return FALSE;
        }
    }

    return TRUE;
}

function url($module, $additional_params = NULL, $seperator = '/') {
    $url = var_get('main_url');
    $query_string_key_values = array();
    if (NULL != $additional_params && !is_array($additional_params)) {
        $additional_params = explode('&', $additional_params);
        foreach ($additional_params as $value) {
            $url_value = explode('=', $value);
            if (count($url_value) > 0) {
                $query_string_key_values[$url_value[0]] = $url_value[1];
            }
        }
    }
    else if (NULL != $additional_params) {
        $query_string_key_values = $additional_params;
    }

    if (TRUE && filter_url($module)) {
        $user_func = $module . '_' . 'urlprocessor';
        if (function_exists($user_func)) {
            $url = call_user_func_array($user_func, array($url, $module, $query_string_key_values, $seperator));
        }
        else {
            $url .=  get_module_mapping($module);
            if (NULL != $additional_params) {
                foreach ($query_string_key_values as $key => $value) {
                   $url .= $seperator . Convert::encodeUrl($value);
                }
            }

            if (NULL === $additional_params) {
                $url .= '.html';
            }
        }
    }
    else {
        $url .= $module . '.php';
        if (NULL != $additional_params) {
            foreach ($query_string_key_values as $key => $value) {
                $query_string_key_values[$key] = Convert::encodeUrl($value);
            }
            $url .= '?' . http_build_query($query_string_key_values);
        }
    }

    return $url;
}

/**
 * A callback function implementation for using with set_error_handler.
 * @param int $code the error code
 * @param string $message the error message
 * @param string $file the file name
 * @param int $line the line location error occurs
 * @throws PHPException
 * @return void
 */
function throw_error_as_exception($code, $message, $file, $line) {
    throw new PHPException($message, $code, $file, $line);
}

/**
 * Autoload the file contains the class called in script.
 * @param string $class_name called class name
 * @return void
 */
function __autoload($class_name) {
    $autoload_classes = var_get('autoload_classes');;

    $file = isset($autoload_classes[$class_name]) ? $autoload_classes[$class_name] : NULL;
    if (isset($file)) {
        $try_times = 0;
        while (!file_exists($file) && ($try_times <= 5)) { //set try times to 5 for finding the file
            $file = '../' . $file;
            $try_times++;
        }

        require_once $file;
    }
}

/**
 * Checks whether a string is valid UTF-8.
 * @param $text
 *   The text to check.
 * @return
 *   TRUE if the text is valid UTF-8, FALSE if not.
 */
function validate_utf8($text) {
    if (strlen($text) == 0) {
      return TRUE;
    }

    return (preg_match('/^./us', $text) == 1);
}

/**
 * Encode special characters in a plain-text string for display as HTML.
 *
 * Uses validate_utf8 to prevent cross site scripting attacks on
 * Internet Explorer 6.
 */
function check_plain($text) {
    return validate_utf8($text) ? htmlspecialchars($text, ENT_QUOTES) : '';
}

/**
 * Gets microsecond from current system.
 * @return float current system time with microsecond
 */
function get_microtime() {
    list($usec, $sec) = explode(' ', microtime());

    return (float)$usec + (float)$sec;
}

/**
 * Utility function used to retrieve the messages from locale file.
 * @param $resource_key the resource message key.
 */
function t($resource_key) {
    return '';
}

/**
 * 解析SQL语句。对于系统中的SQL的构造，需要经过这个函数的处理，该函数会屏蔽SQL注入的问题。
 * @param String, SQL 语句。
 * @param Mixed
 * @example
 *   parse_sql('SELECT * FROM {object_user} where name = %s', "Wyatt'Fang");
 *   output: SELECT * FROM {object_user} where name = 'Wyatt\'s Fang';
 */
function parse_sql($message) {
     $args = func_get_args();
     array_shift($args);

     if (isset($args[0]) && is_array($args[0])) { // 'All arguments in one array' syntax
        $args = $args[0];
     }

     _sql_parse_callback($args, TRUE);

     $message = preg_replace_callback(QUERY_REGEXP, '_sql_parse_callback', $message);

     return $message;
}

/**
 * Usage sample: parse_string('hi %s', 'Wyatt'); the output is: hi Wyatt.
 * @param $message the message contains %s, %d, %f, %%, %n
 * @param $args
 */
function parse_string($message) {
    $args = func_get_args();
     array_shift($args);

     if (isset($args[0]) && is_array($args[0])) { // 'All arguments in one array' syntax
        $args = $args[0];
     }

    _message_callback($args, TRUE);

    $message = preg_replace_callback(QUERY_REGEXP, '_message_callback', $message);

    return $message;
}

/**
 * Helper function used by parse_sql.
 */
function _sql_parse_callback($match, $init = FALSE) {
    static $args = NULL;

    if ($init) {
        $args = $match;
        return;
    }

    switch ($match[1]) {
        case '%d': // We must use type casting to int to convert FALSE/NULL/(TRUE?)
          return (int) array_shift($args);

        case '%s':
            $str = (string) array_shift($args);
            $str = Convert::escape($str);
          return $str;

        case '%n':
          // Numeric values have arbitrary precision, so can't be treated as float.
          // is_numeric() allows hex values (0xFF), but they are not valid.
          $value = trim(array_shift($args));
          return is_numeric($value) && !preg_match('/x/i', $value) ? $value : '0';

        case '%f':
          return (float) array_shift($args);

        case '%%':
            return '%';

        case '%b': // binary data
            return db_encode_blob(array_shift($args));
    }
}

/**
 * Helper function used by parse_string.
 */
function _message_callback($match, $init = FALSE) {
    static $args = NULL;

    if ($init) {
        $args = $match;
        return;
    }

    switch ($match[1]) {
        case '%d': // We must use type casting to int to convert FALSE/NULL/(TRUE?)
          return (int) array_shift($args);

        case '%s':
          return (string) array_shift($args);

        case '%n':
          // Numeric values have arbitrary precision, so can't be treated as float.
          // is_numeric() allows hex values (0xFF), but they are not valid.
          $value = trim(array_shift($args));
          return is_numeric($value) && !preg_match('/x/i', $value) ? $value : '0';

        case '%f':
          return (float) array_shift($args);

        case '%%':
            return '%';

        case '%b': // binary data
            return db_encode_blob(array_shift($args));
    }
}

/**
 * Disables all the effects from magic quotes.
 * @return void
 */
function disable_magic_quotes() {
    set_magic_quotes_runtime(0);

    if (get_magic_quotes_gpc()) {
        $in = array(&$_GET, &$_POST, &$_COOKIE);
        while (list($k,$v) = each($in)) {
            foreach ($v as $key => $val) {
                if (!is_array($val)) {
                    $in[$k][$key] = stripslashes($val);
                    continue;
                }

                $in[] =& $in[$k][$key];
            }
        }
        unset($in);
    }
}

/**
 * Gets the debugging setting.
 * @return bool
 */
function get_system_debugging_status() {
    return var_get('system_debugging', FALSE);
}

/**
 * Traces and deals with the system exception.
 * @param Exception $e
 * @param String $log_level
 * @return mixed outputs the debug information
 */
function trace_exception($e, $log_level='ERROR') {
    if (get_system_debugging_status()) {
        print_var(get_class($e) . ' caught:');
        print_var('File(' . $e->getLine() .'): ' . $e->getFile() . '<br/>Error(' . $e->getCode() . '): ' . $e->getMessage());
        print_var($e->getTrace());
    }
    else {
        if (!defined('__RPC__')) {
            //echo '<script type="text/javascript" language="javascript">document.location.href="error.php";</script>';
        }
        else {
            echo 'System internal error...';
        }

        // Log exceptions.
        $exception_log = new ExceptionEvent();
        $exception_log->cacheException = $e;
        log_by_level($exception_log, $log_level);
    }
}

/**
 * Exception Handler, which with a default error level.
 * Default operation is log the exception, and can be nodified.
 * @param Exception $ex
 * @param String $log_level
 */
function handle_exception($ex, $log_level='WARN') {
    $exception_log = new ExceptionEvent();
    $exception_log->cacheException = $ex;
    log_by_level($exception_log, $log_level);
}

/**
 * Log Exception by level.
 * @param ExceptionEvent $event
 * @param String $log_level
 */
function log_by_level($event, $log_level) {
    $logger = LogFactory::getLogger();

    switch ($log_level) {
        case "INFO" :
            $logger->logInfo($event);
            break;
        case "DEBUG" :
            $logger->logDebug($event);
            break;
        case "WARN" :
            $logger->logWarn($event);
            break;
        case "ERROR" :
            $logger->LogError($event);
            break;
    }
}

function log_debug($message) {
    $event = new SystemEvent();
    $event->url = $message;

    $logger = LogFactory::getLogger();
    $logger->logDebug($event);
}

/**
 * Prints the variable in a frindly format.
 * @param mixed $var the variable
 * @return mixed outputs the content
 */
function print_var($var) {
    echo '<pre style="font-family:Verdana;font-size:10px;color:blue">';
    print_r($var);
    echo '</pre>';
}

/**
 * 获取登陆用户的信息。如果用户已经登陆，则放回登陆用户的实体，如果用户尚未登陆，则返回NULL。
 */
function get_login_user() {
    static $user = NULL;

    //Try to fetch user using id in cookie.
    if (NULL == $user && array_key_exists('user_cookie', $_COOKIE)) {
        $user_cookie = get_from_cookie('user_cookie', false, get_crypt_key());
    }
    return $user_cookie;
}

/**
 * 将登录用户的信息保存到COOKIE中。
 */
function set_user_to_cookie($user, $expire_time = 0) {

    if (NULL != $user) {
        put_into_cookie('user_cookie',
            "$user->id",
            $expire_time, false, get_crypt_key());
    }
}

/**
 * 根据处理每个具体的Action的缓存时间设置，设定smarty的缓存、缓存时间，并创建缓存文件夹
 * @param $smarty
 * @param $_time 0表示不缓存
 * @param $key
 * @param $_deep
 * @return null
 */
function set_cache(&$smarty, $_time = 10, $key = NULL, $_deep = 3) {
    if (0 < $_time) {
        if($key == NULL) {
            $key = $_SERVER['REQUEST_URI'];
        }

        $_path = md5($key);
        $_path_str = '/';

        for ($i = 0, $j = 0, $k = min(strlen($_path) / 2, $_deep); $i < $k; $i++) {
            $_path_str .= $_path{$j++} . $_path{$j++} . '/';
        }

        $smarty->caching = var_get('system_cache_on', TRUE);
        $smarty->cache_lifetime = $_time;
        $smarty->cache_dir .= $_path_str;
        if (!is_dir($smarty->cache_dir)) {
            mkdir($smarty->cache_dir, 0777, TRUE);
            chmod($smarty->cache_dir, 0777);
        }
    }
}

/**
 * 判断页面是否被缓存
 * @param $smarty
 * @param $cache_dir
 * @param $req_type
 * @return boolean
 */
function is_cached(&$smarty, $cache_dir, $template='page-layout.tpl') {
    return var_get('system_cache_on', TRUE)
               ? $smarty->is_cached('common/' . (empty($template) ? 'page-layout.tpl' : $template), $_SERVER['REQUEST_URI'])
               : FALSE;
}

function run($page_class) {
    try {
        $page = new $page_class;
        //$page->setOnline();
		header('Content-Type: text/html; charset=utf-8');

        // 输出本机IP地址第四部分信息到header中,用于调试
        header('Processor: ' . substr(strrchr($_SERVER['SERVER_ADDR'], '.'), 1));

        if (NULL == get_from_cookie('access_key')) {
            put_into_cookie('access_key', Common::generateGuid());
        }

        date_default_timezone_set(var_get('default_timezone', 'Asia/Shanghai'));
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':     
                if ($page->doValidation()) {
                    $page->doGet();
                } else {
                    $page->validationFailAction();
                }
            break;
            case 'POST':
                if ($page->doValidation()) {
                    $page->doPost();
                } else {
                    $page->validationFailAction();
                }
            break;
        }
    }
    catch (DBException $mysql_exception) {
        trace_exception($mysql_exception);
        die();
    }
    catch (BusinessException $php_exception) {
        trace_exception($php_exception);
        die();
    }
    catch (PHPException $ex) {
        trace_exception($ex);
        die();
    }
    catch (Exception $e) {
        trace_exception($e);
        die();
    }
}

function put_into_cookie($name, $value, $expire_time = 0 , $encrypt = false, $key = '') {

    if ($encrypt) {
        $value = encrypt($value, $key);
    }
    $life = $expire_time == 0 ? 0 : time() + $expire_time;
    setcookie($name, $value, $life, '/' , var_get('cookie_domain'));
}

function get_from_cookie($name, $decrypt = false, $key = '') {

    $value = null;
    if (array_key_exists($name, $_COOKIE)) {
        $value = $_COOKIE[$name];
        if ($decrypt) {
            $value = decrypt($value, $key);
        }
    }
    return $value;
}

function encrypt($string = '', $key = '') {

    $key = md5($key ? $key : get_crypt_key());
    list($key, $keyb) = array(substr($key,0, 24), substr($key, 24));
    $string = substr(md5($string.$keyb), 0, 16).$string;
    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
    $ivSize = mcrypt_enc_get_iv_size($td);
    $iv = mcrypt_create_iv ($ivSize, MCRYPT_RAND);
    mcrypt_generic_init($td, $key, $iv);
    $result = mcrypt_generic($td, $string);
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    return str_replace('=', '', base64_encode($iv.$result));
}

function decrypt($string = '', $key = '') {

    $key = md5($key ? $key : get_crypt_key());
    list($key, $keyb) = array(substr($key,0, 24), substr($key, 24));
    $string = base64_decode($string);
    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
    $ivSize = mcrypt_enc_get_iv_size($td);
    $iv = substr($string, 0, $ivSize);
    mcrypt_generic_init($td, $key, $iv);

    $string = trim(mdecrypt_generic($td, substr($string, $ivSize)));
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);
    $result = substr($string, 16);
    if (substr($string, 0, 16) == substr(md5($result.$keyb), 0, 16)) {
        return $result;
    } else {
        return null;
    }
}

function get_crypt_key() {
    return var_get('crypt_key') . $_SERVER['HTTP_USER_AGENT']; //. $_SERVER['REMOTE_ADDR'];
}

function get_image_url($img_url) {
    if (strlen($img_url) < 7) {
        return photo_url() . $img_url;
    }

    $sub_str = substr($img_url, 0, 7);
    if (0 == strcmp($sub_str, '/thumb/')) {
        return thumb_url() . $img_url;
    }
    else {
        return photo_url() . $img_url;
    }
}

function get_login_user_id() {
	static $user_id = NULL;
	
	if (NULL == $user_id && array_key_exists('user_cookie', $_COOKIE)) {
	    $user_cookie = get_from_cookie('user_cookie', true, get_crypt_key());
        $user_id = (int)$user_cookie;
	}
	return $user_id;
}
?>