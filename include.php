<?php

//ensure session and verify session timeout
//session_cache_limiter('private, must-revalidate');
//session_start();
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', dirname(__FILE__) . '/');
}


if (!defined('__INCLUDE__')) {
    define('__INCLUDE__', TRUE);
}

//include golbal functions
require_once ROOT_PATH . 'config/log.settings.php';
require_once ROOT_PATH . 'config/class.settings.php';
require_once ROOT_PATH . 'config/db.settings.php';
require_once ROOT_PATH . 'config/settings.php';
require_once ROOT_PATH . 'bootstrap.php';

system_bootstrap();

require_once ROOT_PATH . 'libs/trace/tracer.php';
require_once ROOT_PATH . 'libs/trace/event.class.php';
require_once ROOT_PATH . 'libs/trace/system-event.class.php';
require_once ROOT_PATH . 'libs/trace/formatter.interface.php';
require_once ROOT_PATH . 'libs/trace/formatter-factory.class.php';
require_once ROOT_PATH . 'libs/trace/string-formatter.class.php';
require_once ROOT_PATH . 'libs/trace/appender.class.php';
require_once ROOT_PATH . 'libs/trace/appender-factory.class.php';
require_once ROOT_PATH . 'libs/trace/file-appender.class.php';
require_once ROOT_PATH . 'libs/trace/logger.interface.php';
require_once ROOT_PATH . 'libs/trace/logger.class.php';
require_once ROOT_PATH . 'libs/trace/logger-factory.class.php';
require_once ROOT_PATH . 'libs/trace/system-event.class.php';
require_once ROOT_PATH . 'libs/trace/biz-event.class.php';
require_once ROOT_PATH . 'libs/trace/biz-formatter.class.php';
require_once ROOT_PATH . 'libs/trace/system-formatter.class.php';
require_once ROOT_PATH . 'libs/trace/exception-event.class.php';
require_once ROOT_PATH . 'libs/trace/exception-formatter.class.php';
require_once ROOT_PATH . 'libs/trace/mail-appender.php';

require_once ROOT_PATH . 'common/global-functions.php';
require_once ROOT_PATH . 'libs/database/database.php';

//include system level classes
$page_process_time_start = get_microtime();

hook_error_as_exception();

require_once ROOT_PATH . 'common/common.class.php';
require_once ROOT_PATH . 'libs/exception/php-exception.class.php';
require_once ROOT_PATH . 'libs/exception/db-exception.class.php';
require_once ROOT_PATH . 'libs/exception/ui-exception.class.php';
require_once ROOT_PATH . 'libs/conversion/convert.class.php';

//disable magic quotes at the beginnning
disable_magic_quotes();

if (!get_magic_quotes_gpc()) {
	//过滤COOKIE
	foreach($_COOKIE as $key => $val) {
		$_COOKIE[$key] = is_array($_COOKIE[$key]) ? addslashesRec($_COOKIE[$key]) : mysql_escape_string($val);
	}
	//过滤GET
	foreach($_GET as $key => $val) {
		$_GET[$key] = is_array($_GET[$key]) ? addslashesRec($_GET[$key]) : mysql_escape_string($val);
	}
}
?>
