<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call!');
}

/**
 * Event information to record common information for log.
 */
class Event {
    /**
     * The properties container of the entity.
     * @var array
     */
    protected $properties;
    
    public function __construct() {
        $this->properties = array(
            'type' => 'Info',
            'eventId' => 100,
            'threadId' => 100,
            //'createTime' => date('Y-m-d H:i:s'),
            'priority' => 4,
        );
    }

    /**
     * Gets a property value with the specified property name.
     * @param string $name property name
     * @return mixed property value
     */
    public function __get($name) {
        $value = NULL;

        if (isset($this->properties[$name])) {
            $value = $this->properties[$name];
        }

        return $value;
    }

    /**
     * Sets a property value with the specified property name.
     * @param string $name property name
     * @param mixed $value property value
     * @return void
     */
    public function __set($name, $value) {
        if (array_key_exists($name, $this->properties)) {
            $this->properties[$name] = $value;
        }
    }
    
    public function toString() {
        return "{$this->type}"
        ." {$this->createTime}"
        ." {$this->threadId}";
    }
}
?>