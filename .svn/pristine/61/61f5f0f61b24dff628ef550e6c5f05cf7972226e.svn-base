<?php
/**
 * This fils is to store the setting for system.
 */
//system config
$config['version'] = '1.000';
$config['system_debugging'] = FALSE;
$config['system_cache_on'] = FALSE;
$config['admin_theme_path'] = '../themes/default';

//smarty config
$config['smarty_debugging'] = FALSE;
$config['smarty_compile_dir'] = ROOT_PATH . 'templates_c';
$config['smarty_template_dir'] = ROOT_PATH . 'templates';
$config['smarty_cache_dir'] = ROOT_PATH . 'cache';

//i18n settings
$config['application_domain'] = 'globals';
$config['application_locale_dir'] = ROOT_PATH . 'locale';

//Validation code font setting
$config['validation_url'] = 'captcha.php';


//配置存放搜索词的memcache数组key值，及最多记录数
$config['memocache_search_keyword']= 'memocache_search_keyword';
$config['memocache_search_keyword_records'] = 5;

//图片上传参数
$config['max_file_size'] = 2000000;
$config['upload_path'] = 'themes/default/images/upload/';

/**
 * The util function to retrieve the configuration information.
 * @param string $key is the configuration key.
 * @param mixed $default is the default value of the configuration, if there is no key exists
 * in the config array, the $default value will be returned.
 */
function var_get($key = '', $default = '') {
    global $config;

    if ('' === $key) {
        return $config;
    }

    if (array_key_exists($key, $config)) {
        return $config[$key];
    } else {
        $default;
    }
}
?>