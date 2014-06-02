<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call: Memocached cache!');
}

/**
 * Description of memocachedcacheclass
 *
 * @author geefull
 */
class Memocached extends Cache  {
  protected $memcache = null;

  /**
   * Initializes this Cache instance.
   *
   * Available options:
   *
   * * memcache: A memcache object (optional)
   *
   * * host:       The default host (default to localhost)
   * * port:       The port for the default server (default to 11211)
   * * persistent: true if the connection must be persistent, false otherwise (true by default)
   *
   * * servers:    An array of additional servers (keys: host, port, persistent)
   *
   * * see Cache for options available for all drivers
   *
   * @see Cache
   */
  public function initialize($options = array()) {
    parent::initialize($options);

    if (!class_exists('Memcache'))
    {
      throw new InitializationException('You must have memcache installed and enabled to use MemcacheCache class.');
    }

    if ($this->getOption('memcache'))
    {
      $this->memcache = $this->getOption('memcache');
    }
    else
    {
      $this->memcache = new Memcache();

      if ($this->getOption('servers'))
      {
        foreach ($this->getOption('servers') as $server)
        {
          $port = isset($server['port']) ? $server['port'] : 11211;
          $weight = isset($server['weight']) ? $server['weight'] : 1;
          if (!$this->memcache->addServer($server['host'], $port, isset($server['persistent']) ? $server['persistent'] : true, $weight))
          {
            throw new InitializationException(sprintf('Unable to connect to the memcache server (%s:%s).', $server['host'], $port));
          }
        }
      }
      else
      {
        $method = $this->getOption('persistent', true) ? 'pconnect' : 'connect';
        if (!$this->memcache->$method($this->getOption('host', 'localhost'), $this->getOption('port', 11211), $this->getOption('timeout', 1)))
        {
          throw new InitializationException(sprintf('Unable to connect to the memcache server (%s:%s).', $this->getOption('host', 'localhost'), $this->getOption('port', 11211)));
        }
      }
    }
  }

  /**
   * @see Cache
   */
  public function getBackend()
  {
    return $this->memcache;
  }

 /**
  * @see Cache
  */
  public function get($key, $default = null)
  {
    $key = md5($key);
    $value = $this->memcache->get($this->getOption('prefix').$key);

    return false === $value ? $default : $value;
  }

  /**
   * @see Cache
   */
  public function has($key)
  {
    $key = md5($key);
    return !(false === $this->memcache->get($this->getOption('prefix').$key));
  }

  /**
   * @see Cache
   */
  public function set($key, $data, $lifetime = null)
  {
    $key = md5($key);
    $lifetime = is_null($lifetime) ? $this->getOption('lifetime') : $lifetime;

    // save metadata
    $this->setMetadata($key, $lifetime);

    // save key for removePattern()
    if ($this->getOption('storeCacheInfo', false))
    {
      $this->setCacheInfo($key);
    }

    return $this->memcache->set($this->getOption('prefix').$key, $data, false, $lifetime);
  }

  /**
   * @see Cache
   */
  public function remove($key)
  {
    $key = md5($key);
    $this->memcache->delete($this->getOption('prefix').'_metadata'.self::SEPARATOR.$key);

    return $this->memcache->delete($this->getOption('prefix').$key);
  }

  /**
   * @see Cache
   */
  public function clean($mode = Cache::ALL)
  {
    $key = md5($key);
    if (Cache::ALL === $mode)
    {
      return $this->memcache->flush();
    }
  }

  /**
   * @see Cache
   */
  public function getLastModified($key)
  {
    $key = md5($key);
    if (false === ($retval = $this->getMetadata($key)))
    {
      return 0;
    }

    return $retval['lastModified'];
  }

  /**
   * @see Cache
   */
  public function getTimeout($key)
  {
    $key = md5($key);
    if (false === ($retval = $this->getMetadata($key)))
    {
      return 0;
    }

    return $retval['timeout'];
  }

  /**
   * @see Cache
   */
  public function removePattern($pattern)
  {
    if (!$this->getOption('storeCacheInfo', false))
    {
      throw new CacheException('To use the "removePattern" method, you must set the "storeCacheInfo" option to "true".');
    }

    $regexp = self::patternToRegexp($this->getOption('prefix').$pattern);

    foreach ($this->getCacheInfo() as $key)
    {
      if (preg_match($regexp, $key))
      {
        $this->memcache->delete($key);
      }
    }
  }

  /**
   * @see Cache
   */
  public function getMany($keys)
  {
    $values = array();
    foreach ($this->memcache->get(array_map(create_function('$k', 'return "'.$this->getOption('prefix').'".$k;'), $keys)) as $key => $value)
    {
      $key = md5($key);
      $values[str_replace($this->getOption('prefix'), '', $key)] = $value;
    }

    return $values;
  }

  /**
   * Gets metadata about a key in the cache.
   *
   * @param  string $key A cache key
   *
   * @return array  An array of metadata information
   */
  protected function getMetadata($key)
  {
    $key = md5($key);
    return $this->memcache->get($this->getOption('prefix').'_metadata'.self::SEPARATOR.$key);
  }

  /**
   * Stores metadata about a key in the cache.
   *
   * @param  string $key A cache key
   * @param  string $key The lifetime
   */
  protected function setMetadata($key, $lifetime)
  {
    $key = md5($key);
    $this->memcache->set($this->getOption('prefix').'_metadata'.self::SEPARATOR.$key, array('lastModified' => time(), 'timeout' => time() + $lifetime), false, $lifetime);
  }

  /**
   * Updates the cache information for the given cache key.
   *
   * @param string $key The cache key
   */
  protected function setCacheInfo($key)
  {
    $key = md5($key);
    $keys = $this->memcache->get($this->getOption('prefix').'_metadata');
    if (!is_array($keys))
    {
      $keys = array();
    }
    $keys[] = $this->getOption('prefix').$key;
    $this->memcache->set($this->getOption('prefix').'_metadata', $keys, 0);
  }

  /**
   * Gets cache information.
   */
  protected function getCacheInfo()
  {
    $keys = $this->memcache->get($this->getOption('prefix').'_metadata');
    if (!is_array($keys))
    {
      return array();
    }

    return $keys;
  }
}
?>
