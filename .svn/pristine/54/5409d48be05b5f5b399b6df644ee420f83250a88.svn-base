<?php
/**
 * Provides the functionalities that session management related.
 */
class SessionManager {
    /**
     * Adds a new session variable.
     * @param array $session the combination of session name and session value
     * @return boolean
     */
    public function addEntity($session) {
        $_SESSION[$session['session_name']] = $session['session_value'];

        return TRUE;
    }

    /**
     * Updates a session variable value.
     * @param mixed $new_session_value the newly session variable value
     * @param string $session_name session name
     * @return boolean
     */
    public function updateEntity($session_name) {        
        //TODO
    }

    /**
     * Unsets a session according to session variable name.
     * @param string $session_name session variable name
     * @return boolean
     */
    public function deleteEntity($session_name) {
        unset($_SESSION[$session_name]);

        return TRUE;
    }

    /**
     * Returns a session variable value according to the specified session name.
     * @param string $session_name session name
     * @return mixed session variable value
     */
    public function getEntityByKey($session_name) {
        $session_value = isset($_SESSION[$session_name]) ? $_SESSION[$session_name] : NULL;

        return $session_value;
    }

    /**
     * Gets a session variable vaule with the specifed session variable name.
     * @param string $name session variable name
     * @return mixed session variable value
     */
    public  function __get($name) {
        return $this->getEntityByKey($name);
    }

    /**
     * Sets a session variable.
     * @param string $name session variable name
     * @param mixed $value session variable value
     * @return void
     */
    public function __set($session_name, $session_value) {
        $session = array (
            'session_name' => $session_name,
            'session_value' => $session_value
        );
        $this->addEntity($session);
    }
}
?>