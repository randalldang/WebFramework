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
    'BaseDao' => ROOT_PATH . 'dao/base-dao.class.php',
    'BaseService' => ROOT_PATH . 'service/base-service.class.php',
    'BaseAction' => ROOT_PATH . 'web/base-action.class.php',

    'Advice' => ROOT_PATH . 'entity/advice.class.php',
    'AdviceDao' => ROOT_PATH . 'dao/advice-dao.class.php',
    'AdviceService' => ROOT_PATH . 'service/advice-service.class.php',
    'AdviceAction' => ROOT_PATH . 'web/advice.php',

    'AppOpenHistory' => ROOT_PATH . 'entity/app-open-history.class.php',
    'AppOpenHistoryDao' => ROOT_PATH . 'dao/app-open-history-dao.class.php',
    'AppOpenHistoryService' => ROOT_PATH . 'service/app-open-history-service.class.php',
    'AppOpenHistoryAction' => ROOT_PATH . 'web/app-open-history.php',

    'AppVersion' => ROOT_PATH . 'entity/app-version.class.php',
    'AppVersionDao' => ROOT_PATH . 'dao/app-version-dao.class.php',
    'AppVersionService' => ROOT_PATH . 'service/app-version-service.class.php',
    'AppVersionAction' => ROOT_PATH . 'web/app-version.php',

    'Cms' => ROOT_PATH . 'entity/cms.class.php',
    'CmsDao' => ROOT_PATH . 'dao/cms-dao.class.php',
    'CmsService' => ROOT_PATH . 'service/cms-service.class.php',
    'CmsAction' => ROOT_PATH . 'web/cms.php',

    'LoginHistory' => ROOT_PATH . 'entity/login-history.class.php',
    'LoginHistoryDao' => ROOT_PATH . 'dao/login-history-dao.class.php',
    'LoginHistoryService' => ROOT_PATH . 'service/login-history-service.class.php',
    'LoginHistoryAction' => ROOT_PATH . 'web/login-history.php',

    'Notice' => ROOT_PATH . 'entity/notice.class.php',
    'NoticeDao' => ROOT_PATH . 'dao/notice-dao.class.php',
    'NoticeService' => ROOT_PATH . 'service/notice-service.class.php',
    'NoticeAction' => ROOT_PATH . 'web/notice.php',

    'ServiceRegion' => ROOT_PATH . 'entity/service-region.class.php',
    'ServiceRegionDao' => ROOT_PATH . 'dao/service-region-dao.class.php',
    'ServiceRegionService' => ROOT_PATH . 'service/service-region-service.class.php',
    'ServiceRegionAction' => ROOT_PATH . 'web/service-region.php',

    'Couriers' => ROOT_PATH . 'entity/couriers.class.php',
    'CouriersDao' => ROOT_PATH . 'dao/couriers-dao.class.php',
    'CouriersService' => ROOT_PATH . 'service/couriers-service.class.php',
    'CouriersAction' => ROOT_PATH . 'web/couriers.php',

    'CourierActivity' => ROOT_PATH . 'entity/courier-activity.class.php',
    'CourierActivityDao' => ROOT_PATH . 'dao/courier-activity-dao.class.php',
    'CourierActivityService' => ROOT_PATH . 'service/courier-activity-service.class.php',
    'CourierActivityAction' => ROOT_PATH . 'web/courier-activity.php',

    'CourierCompany' => ROOT_PATH . 'entity/courier-company.class.php',
    'CourierCompanyDao' => ROOT_PATH . 'dao/courier-company-dao.class.php',
    'CourierCompanyService' => ROOT_PATH . 'service/courier-company-service.class.php',
    'CourierCompanyAction' => ROOT_PATH . 'web/courier-company.php',

    'CourierRecommend' => ROOT_PATH . 'entity/courier-recommend.class.php',
    'CourierRecommendDao' => ROOT_PATH . 'dao/courier-recommend-dao.class.php',
    'CourierRecommendService' => ROOT_PATH . 'service/courier-recommend-service.class.php',
    'CourierRecommendAction' => ROOT_PATH . 'web/courier-recommend.php',

    'CourierTracking' => ROOT_PATH . 'entity/courier-tracking.class.php',
    'CourierTrackingDao' => ROOT_PATH . 'dao/courier-tracking-dao.class.php',
    'CourierTrackingService' => ROOT_PATH . 'service/courier-tracking-service.class.php',
    'CourierTrackingAction' => ROOT_PATH . 'web/courier-tracking.php',

    'Customers' => ROOT_PATH . 'entity/customers.class.php',
    'CustomersDao' => ROOT_PATH . 'dao/customers-dao.class.php',
    'CustomersService' => ROOT_PATH . 'service/customers-service.class.php',
    'CustomersAction' => ROOT_PATH . 'web/customers.php',

    'CustomerAddress' => ROOT_PATH . 'entity/customer-address.class.php',
    'CustomerAddressDao' => ROOT_PATH . 'dao/customer-address-dao.class.php',
    'CustomerAddressService' => ROOT_PATH . 'service/customer-address-service.class.php',
    'CustomerAddressAction' => ROOT_PATH . 'web/customer-address.php',

    'CustomerShare' => ROOT_PATH . 'entity/customer-share.class.php',
    'CustomerShareDao' => ROOT_PATH . 'dao/customer-share-dao.class.php',
    'CustomerShareService' => ROOT_PATH . 'service/customer-share-service.class.php',
    'CustomerShareAction' => ROOT_PATH . 'web/customer-share.php',

    'OrderEstimation' => ROOT_PATH . 'entity/order-estimation.class.php',
    'OrderEstimationDao' => ROOT_PATH . 'dao/order-estimation-dao.class.php',
    'OrderEstimationService' => ROOT_PATH . 'service/order-estimation-service.class.php',
    'OrderEstimationAction' => ROOT_PATH . 'web/order-estimation.php',

    'OrderLocation' => ROOT_PATH . 'entity/order-location.class.php',
    'OrderLocationDao' => ROOT_PATH . 'dao/order-location-dao.class.php',
    'OrderLocationService' => ROOT_PATH . 'service/order-location-service.class.php',
    'OrderLocationAction' => ROOT_PATH . 'web/order-location.php',

    'Orders' => ROOT_PATH . 'entity/orders.class.php',
    'OrdersDao' => ROOT_PATH . 'dao/orders-dao.class.php',
    'OrdersService' => ROOT_PATH . 'service/orders-service.class.php',
    'OrdersAction' => ROOT_PATH . 'web/orders.php',

    'OrderSerial' => ROOT_PATH . 'entity/order-serial.class.php',
    'OrderSerialDao' => ROOT_PATH . 'dao/order-serial-dao.class.php',
    'OrderSerialService' => ROOT_PATH . 'service/order-serial-service.class.php',
    'OrderSerialAction' => ROOT_PATH . 'web/order-serial.php',

    'CancelReason' => ROOT_PATH . 'entity/cancel-reason.class.php',
    'CancelReasonDao' => ROOT_PATH . 'dao/cancel-reason-dao.class.php',
    'CancelReasonService' => ROOT_PATH . 'service/cancel-reason-service.class.php',
    'CancelReasonAction' => ROOT_PATH . 'web/cancel-reason.php'

);

$config['po_path'] = ROOT_PATH . 'entity/';
?>
