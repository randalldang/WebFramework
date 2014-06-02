<?php
/**
 * Provides the funcitonalities to manage post data.
 */
class PostManager {
    /**
     * An array for storing post data.
     * @var array
     */ 
    private $post_data = array ();

    /**
     * Gets the $_POST.
     */
    public function __construct() {
        $this->post_data = $_POST;            
    }

    /**
     * Returns the post data value by field name.
     * @param string $name post data index name
     * @return mixed string of the value if the index exists, or NULL
     */
    public function __get($name) {
        $value = isset($this->post_data[$name]) ? $this->post_data[$name] : NULL;

        return $value;
    }
}
?>