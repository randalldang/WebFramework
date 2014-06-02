<?php
/**
 * Provides the interface definition of entity management related.
 */
abstract class Entity {
    /**
     * The p container of the entity.
     * @var array
     */
    protected $p;

    /**
     * DB Name
     */
    public $connection = '';

    /**
     * DB Table
     */
    public $table = '';

    /**
     * Table Fields
     */
    public $fields = array();

    /**
     * Gets a property value with the specified property name.
     * @param string $name property name
     * @return mixed property value
     */
    public function __get($name) {
        $value = NULL;

        if (isset($this->p[$name])) {
            $value = $this->p[$name];
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
        if (array_key_exists($name, $this->p)) {
            $this->p[$name] = $value;
        }
    }

    /**
     * Initializes the entity with the specified information.
     * @param array $entity_info an array of entity properties information
     * @return void
     */
    public function initializeEntity($entity_info) {
        foreach ($entity_info as $name => $value) {
            $this->__set($name, $value);
        }
    }

    public function toXML($with_head=TRUE) {
        return XML::clientSerialize($this->p,$with_head,get_class($this));
    }

    public function toJson() {
        return Json::jsonEncode($this->p);
    }
}
?>