<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call: apc-cache!');
}

/**
 * Cache class that stores cached content in APC.
 *
 * @package    geefull
 * @subpackage cache
 */
class APCCache extends Cache {
      /**
       * Initializes this Cache instance.
       *
       * Available options:
       *
       * * see Cache for options available for all drivers
       *
       * @see Cache
       */
    public function initialize($options = array()) {
          parent::initialize($options);

          if (!function_exists('apc_store') || !ini_get('apc.enabled')) {
              throw new Exception('You must have APC installed and enabled to use APCCache class.');
          } 
    }

     /**
      * @see Cache
      */
    public function get($key, $default = null) {
        $value = apc_fetch($this->getOption('prefix') . $key);

        return false === $value ? $default : $value;
    }

      /**
       * @see Cache
       */
    public function has($key) {
        return !(false === apc_fetch($this->getOption('prefix') . $key));
    }

      /**
       * @see Cache
       */
    public function set($key, $data, $lifetime = null) {
        return apc_store($this->getOption('prefix') . $key, $data, $this->getLifetime($lifetime));
    }

      /**
       * @see Cache
       */
    public function remove($key) {
        return apc_delete($this->getOption('prefix') . $key);
    }

      /**
       * @see Cache
       */
    public function clean($mode = Cache::ALL) {
        if (Cache::ALL === $mode) {
            return apc_clear_cache('user');
        }
    }

      /**
       * @see Cache
       */
    public function getLastModified($key) {
       $info = $this->getCacheInfo($key);
       if ($info) {
          return $info['creation_time'] + $info['ttl'] > time() ? $info['mtime'] : 0;
        }

        return 0;
    }

      /**
       * @see Cache
       */
    public function getTimeout($key) {
          $info = $this->getCacheInfo($key);
          if ($info) {
              return $info['creation_time'] + $info['ttl'] > time() ? $info['creation_time'] + $info['ttl'] : 0;
          }

        return 0;
    }

      /**
       * @see Cache
       */
    public function removePattern($pattern) {
        $infos = apc_cache_info('user');
        if (!is_array($infos['cache_list'])) {
            return;
        }

        $regexp = self::patternToRegexp($this->getOption('prefix') . $pattern);

        foreach ($infos['cache_list'] as $info) {
            if (preg_match($regexp, $info['info'])) {
               apc_delete($info['info']);
            }
         }

    }

    protected function getCacheInfo($key) {
        $infos = apc_cache_info('user');

        if (is_array($infos['cache_list'])) {
            foreach ($infos['cache_list'] as $info) {
                if ($this->getOption('prefix') . $key == $info['info']) {
                    return $info;
                }
            }
        }

        return null;
    }
}
