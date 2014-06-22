<?php
//autoload class path
$config['autoload_classes'] = array (
    'PHPException' => ROOT_PATH . 'libs/exception/php-exception.class.php',
    'BusinessException' => ROOT_PATH . 'libs/exception/business-exception.class.php',
    'Cache' => ROOT_PATH . 'libs/cache/cache.class.php',
    'FileOperator' => ROOT_PATH . 'libs/file-system/file-operator.class.php',
    'Json' => ROOT_PATH . 'libs/data-parsers/json.class.php',    
    'Spyc' => ROOT_PATH . 'libs/data-parsers/spyc.class.php',
    'SqlEvent' => ROOT_PATH . 'libs/trace/sql-event.class.php',
    'XML' => ROOT_PATH . 'libs/data-parsers/xml.class.php',
    
    'Common' => ROOT_PATH . 'common/common.class.php',
    'FileManager' => ROOT_PATH . 'common/file-manager.class.php',
    'GetManager' => ROOT_PATH . 'common/get-manager.class.php',
    'PostManager' => ROOT_PATH . 'common/post-manager.class.php',
    'SessionManager' => ROOT_PATH . 'common/session-manager.class.php',
    'PagerOrder' => ROOT_PATH . 'common/pager-order.class.php',

    'Entity' => ROOT_PATH . 'entity/entity.class.php',
    'EntityPager' => ROOT_PATH . 'entity/entity-pager.class.php',
    'BaseDao' => ROOT_PATH . 'dao/base-dao.class.php',
    'BaseService' => ROOT_PATH . 'service/base-service.class.php',
    'BaseAction' => ROOT_PATH . 'web/base-action.class.php',

    'Customers' => ROOT_PATH . 'entity/customers.class.php',
    'CustomersDao' => ROOT_PATH . 'dao/customers-dao.class.php',
    'CustomersService' => ROOT_PATH . 'service/customers-service.class.php',
    'CustomersAction' => ROOT_PATH . 'web/customers.php'

    );

$config['po_path'] = ROOT_PATH . 'entity/';
?>
