<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call:database!');
}

/**
 * Indicates the place holders that should be replaced in _db_query_callback().
 */
define('DB_QUERY_REGEXP', '/(%d|%s|%%|%f|%b|%n)/');

/**
 * @file
 * Wrapper for database interface code.
 */

//Assign the db settings
$db_url = var_get('db_url');
$db_prefix = var_get('db_prefix');

/**
 * Perform an SQL query and return success or failure.
 *
 * @param $sql
 *   A string containing a complete SQL query.  %-substitution
 *   parameters are not supported.
 * @return
 *   An array containing the keys:
 *      success: a boolean indicating whether the query succeeded
 *      query: the SQL query executed, passed through check_plain()
 */
function update_sql($sql) {
    $result = db_query($sql, true);

    return array('success' => $result !== FALSE, 'query' => check_plain($sql));
}

/**
 * Append a database prefix to all tables in a query.
 * @param $sql
 *   A string containing a partial or entire SQL query.
 * @return
 *   The properly-prefixed string.
 */
function db_prefix_tables($sql) {
    global $db_prefix;

    if (is_array($db_prefix)) {
        if (array_key_exists('default', $db_prefix)) {
            $tmp = $db_prefix;
            unset($tmp['default']);

            foreach ($tmp as $key => $val) {
                $sql = strtr($sql, array('{'. $key .'}' => $val . $key));
            }

            return strtr($sql, array('{' => $db_prefix['default'], '}' => ''));
        }
        else {
            foreach ($db_prefix as $key => $val) {
                $sql = strtr($sql, array('{'. $key .'}' => $val . $key));
            }

            return strtr($sql, array('{' => '', '}' => ''));
        }
    }
    else {
        return strtr($sql, array('{' => $db_prefix, '}' => ''));
    }
}

/**
 * Activate a database for future queries.
 *
 * @param $name
 *   The name assigned to the newly active database connection. If omitted, the
 *   default connection will be made active.
 *
 * @return the name of the previously active database or FALSE if non was found.
 */
function db_set_active($name = 'HorseDB') {
    global $db_url, $db_type, $active_db;
    static $db_conns, $active_name = FALSE;

    if (!isset($db_conns[$name])) {

        // Initiate a new connection, using the named DB URL specified.
        if (is_array($db_url)) {
            $connect_url = array_key_exists($name, $db_url) ? $db_url[$name] : $db_url['default'];
        }
        else {
            $connect_url = $db_url;
        }

        $db_type = substr($connect_url, 0, strpos($connect_url, '://'));
        $handler = ROOT_PATH . "/libs/database/database.$db_type.php";

        if (is_file($handler)) {
           include_once $handler;
        }
        else {
            _db_error_page("The database type '". $db_type ."' is unsupported. Please use either 'mysql' or 'mysqli' for MySQL, or 'pgsql' for PostgreSQL databases.");
        }
        
        $db_conns[$name] = db_connect($connect_url);
    }

    $previous_name = $active_name;

    // Set the active connection.
    $active_name = $name;
    $active_db = $db_conns[$name];

    return $previous_name;
}

/**
 * Gets NOW time.
 */
function db_now() {
    db_set_active();
    $now = db_result(db_query('SELECT NOW()'));
    if (!isset($now)) {
        $now = date('Y-m-d H:i:s');
    }

    return $now;
}

function db_uuid() {
    db_set_active();
    return db_result(db_query('SELECT UUID()'));
}

/**
 * Gets current date.
 */
function db_current_date() {
    db_set_active();
    $date = db_result(db_query('SELECT CURDATE()'));
    if (!isset($date)) {
        $date = date('Y-m-d');
    }

    return $date;
}

/**
 * Helper function to show fatal database errors.
 *
 * @param $error
 *   The error message to be appended if 'display_errors' is on.
 */
function _db_error_page($error = '') {

}

/**
 * Returns a boolean depending on the availability of the database.
 */
function db_is_active() {
    global $active_db;

    return !empty($active_db);
}

function db_handler() {
    global $active_db;

    return $active_db;
}

/**
 * Helper function for db_query().
 */
function _db_query_callback($match, $init = FALSE) {
    static $args = NULL;
    if ($init) {
        $args = $match;
        return;
    }

    switch ($match[1]) {
        case '%d': // We must use type casting to int to convert FALSE/NULL/(TRUE?)
            return (int) array_shift($args); // We don't need db_escape_string as numbers are db-safe
        case '%s':
            return db_escape_string(array_shift($args));
        case '%n':
            // Numeric values have arbitrary precision, so can't be treated as float.
            // is_numeric() allows hex values (0xFF), but they are not valid.
            $value = trim(array_shift($args));
            return is_numeric($value) && !preg_match('/x/i', $value) ? $value : '0';
        case '%%':
            return '%';
        case '%f':
            return (float) array_shift($args);
        case '%b': // binary data
            return db_encode_blob(array_shift($args));
    }
}

/**
 * Generate placeholders for an array of query arguments of a single type.
 *
 * @param $arguments
 *  An array with at least one element.
 * @param $type
 *   The Schema API type of a field (e.g. 'int', 'text', or 'varchar').
 */
function db_placeholders($arguments, $type = 'int') {
    $placeholder = db_type_placeholder($type);

    return implode(',', array_fill(0, count($arguments), $placeholder));
}

/**
 * Restrict a dynamic table, column or constraint name to safe characters.
 *
 * Only keeps alphanumeric and underscores.
 */
function db_escape_table($string) {
    return preg_replace('/[^A-Za-z0-9_]+/', '', $string);
}

/**
 * Create a new table from a system table definition.
 *
 * @param $ret
 *   Array to which query results will be added.
 * @param $name
 *   The name of the table to create.
 * @param $table
 *   A Schema API table definition array.
 */
function db_create_table(&$ret, $name, $table) {
    $statements = db_create_table_sql($name, $table);

    foreach ($statements as $statement) {
        $ret[] = update_sql($statement);
    }
}

/**
 * Return an array of field names from an array of key/index column specifiers.
 * @param $fields
 *   An array of key/index column specifiers.
 * @return
 *   An array of field names.
 */
function db_field_names($fields) {
    $ret = array();

    foreach ($fields as $field) {
        if (is_array($field)) {
            $ret[] = $field[0];
        }
        else {
            $ret[] = $field;
        }
    }

    return $ret;
}

/**
 * Given a Schema API field type, return the correct %-placeholder.
 * @param $type
 *   The Schema API type of a field.
 * @return
 *   The placeholder string to embed in a query for that type.
 */
function db_type_placeholder($type) {
    switch ($type) {
        case 'varchar':
        case 'char':
        case 'text':
        case 'datetime':
            return "'%s'";

        case 'numeric':
            // Numeric values are arbitrary precision numbers.  Syntacically, numerics
            // should be specified directly in SQL. However, without single quotes
            // the %s placeholder does not protect against non-numeric characters such
            // as spaces which would expose us to SQL injection.
            return '%n';

        case 'serial':
        case 'int':
            return '%d';

        case 'float':
            return '%f';

        case 'blob':
            return '%b';
    }

    // There is no safe value to return here, so return something that
    // will cause the query to fail.
    return 'unsupported type '. $type .'for db_type_placeholder';
}