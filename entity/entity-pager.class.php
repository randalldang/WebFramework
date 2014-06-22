<?php
/**
 * Provides the interface definition of entity pagination.
 */
class EntityPager {

    public $entities;

    public $count;

    public function __construct($entities, $count){
        $this->entities = $entities;
        $this->count = $count;
    }
}
?>