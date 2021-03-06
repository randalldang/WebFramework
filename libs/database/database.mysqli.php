<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call:database!');
}

/**
 * @file
 * Database interface code for MySQL database servers using the mysqli client libraries. mysqli is included in PHP 5 by default and allows developers to use the advanced features of MySQL 4.1.x, 5.0.x and beyond.
 */

// Include functions shared between mysql and mysqli.
require_once ROOT_PATH . 'libs/database/database.mysql-common.php';

/**
 * Returns the version of the database server currently in use.
 *
 * @return Database server version
 */
function db_version() {
    global $active_db;

    list($version) = explode('-', mysqli_get_server_info($active_db));
    return $version;
}

/**
 * Initialise a database connection.
 *
 * Note that mysqli does not support persistent connections.
 */
function db_connect($url) {
    // Check if MySQLi support is present in PHP
    if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
        _db_error_page('Unable to use the MySQLi database because the MySQLi extension for PHP is not installed. Check your <code>php.ini</code> to see how you can enable it.');
    }

    $url = parse_url($url);

    // Decode url-encoded information in the db connection string
    $url['user'] = urldecode($url['user']);

    // Test if database url has a password.
    $url['pass'] = isset($url['pass']) ? urldecode($url['pass']) : '';
    $url['host'] = urldecode($url['host']);
    $url['path'] = urldecode($url['path']);
    if (!isset($url['port'])) {
        $url['port'] = NULL;
    }

    $connection = mysqli_init();
    @mysqli_real_connect($connection, $url['host'], $url['user'], $url['pass'], substr($url['path'], 1), $url['port'], NULL, MYSQLI_CLIENT_FOUND_ROWS);

    if (mysqli_connect_errno() > 0) {
        _db_error_page(mysqli_connect_error());
    }

    // Force UTF-8.
    mysqli_query($connection, 'SET NAMES "utf8"');

    return $connection;
}

/**
 * Helper function for db_query().
 */
function _db_query($query, $debug = 0) {
    global $active_db, $queries, $user;

    $result = mysqli_query($active_db, $query);

    if (!mysqli_errno($active_db)) {
        return $result;
    }
    else {
        //trigger_error(check_plain(mysqli_error($active_db) ."\nquery: ". $query), E_USER_WARNING);

        return FALSE;
    }
}

/**
 * Fetch one result row from the previous query as an object.
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @return
 *   An object representing the next row of the result, or FALSE. The attributes
 *   of this object are the table fields selected by the query.
 */
function db_fetch_object($result) {
    if ($result) {
        $object = mysqli_fetch_object($result);

        return isset($object) ? $object : FALSE;
    }
}

/**
 * Fetch one result row from the previous query as an array.
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @return
 *   An associative array representing the next row of the result, or FALSE.
 *   The keys of this object are the names of the table fields selected by the
 *   query, and the values are the field values for this result row.
 */
function db_fetch_array($result) {
    if ($result) {
        $array = mysqli_fetch_array($result, MYSQLI_ASSOC);

        return isset($array) ? $array : FALSE;
    }
}

/**
 * Return an individual result field from the previous query.
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @return
 *   The resulting field or FALSE.
 */
function db_result($result) {
    if ($result && mysqli_num_rows($result) > 0) {
        // The mysqli_fetch_row function has an optional second parameter $row
        // but that can't be used for compatibility with Oracle, DB2, etc.
        $array = mysqli_fetch_row($result);

        return $array[0];
    }

    return FALSE;
}

/**
 * Determine whether the previous query caused an error.
 */
function db_error() {
    global $active_db;
    return mysqli_error($active_db);
}

function db_errno() {
    global $active_db;

    return mysqli_errno($active_db);
}

/**
 * Determine the number of rows changed by the preceding query.
 */
function db_affected_rows() {
    global $active_db; /* mysqli connection resource */
    return mysqli_affected_rows($active_db);
}

/**
 * Runs a limited-range query in the active database.
 * @param $query
 *   A string containing an SQL query.
 * @param ...
 *   A variable number of arguments which are substituted into the query
 *   using printf() syntax. The query arguments can be enclosed in one
 *   array instead.
 *   Valid %-modifiers are: %s, %d, %f, %b (binary data, do not enclose
 *   in '') and %%.
 *
 *   NOTE: using this syntax will cast NULL and FALSE values to decimal 0,
 *   and TRUE values to decimal 1.
 *
 * @param $from
 *   The first result row to return.
 * @param $count
 *   The maximum number of result rows to return.
 * @return
 *   A database query result resource, or FALSE if the query was not executed
 *   correctly.
 */
function db_query_range($query) {
    $args = func_get_args();
    $count = array_pop($args);
    $from = array_pop($args);
    array_shift($args);

    $query = db_prefix_tables($query);
    if (isset($args[0]) and is_array($args[0])) { // 'All arguments in one array' syntax
        $args = $args[0];
    }

    _db_query_callback($args, TRUE);
    $query = preg_replace_callback(DB_QUERY_REGEXP, '_db_query_callback', $query);
    $query .= ' LIMIT '. (int)$from .', '. (int)$count;

    return _db_query($query);
}

/**
 * Runs a SELECT query and stores its results in a temporary table.
 * @param $query
 *   A string containing a normal SELECT SQL query.
 * @param ...
 *   A variable number of arguments which are substituted into the query
 *   using printf() syntax. The query arguments can be enclosed in one
 *   array instead.
 *   Valid %-modifiers are: %s, %d, %f, %b (binary data, do not enclose
 *   in '') and %%.
 *
 *   NOTE: using this syntax will cast NULL and FALSE values to decimal 0,
 *   and TRUE values to decimal 1.
 *
 * @param $table
 *   The name of the temporary table to select into. This name will not be
 *   prefixed as there is no risk of collision.
 * @return
 *   A database query result resource, or FALSE if the query was not executed
 *   correctly.
 */
function db_query_temporary($query) {
    $args = func_get_args();
    $tablename = array_pop($args);
    array_shift($args);

    $query = preg_replace('/^SELECT/i', 'CREATE TEMPORARY TABLE '. $tablename .' Engine=HEAP SELECT', db_prefix_tables($query));
    if (isset($args[0]) and is_array($args[0])) { // 'All arguments in one array' syntax
        $args = $args[0];
    }

    _db_query_callback($args, TRUE);
    $query = preg_replace_callback(DB_QUERY_REGEXP, '_db_query_callback', $query);

    return _db_query($query);
}

/**
 * Returns a properly formatted Binary Large Object value.
 *
 * @param $data
 *    Data to encode.
 * @return
 *    Encoded data.
 */
function db_encode_blob($data) {
    global $active_db;
    return "'". mysqli_real_escape_string($active_db, $data) ."'";
}

/**
 * Returns text from a Binary Large OBject value.
 *
 * @param $data
 *   Data to decode.
 * @return
 *  Decoded data.
 */
function db_decode_blob($data) {
    return $data;
}

/**
 * Prepare user input for use in a database query, preventing SQL injection attacks.
 */
function db_escape_string($text) {
    global $active_db;
    return mysqli_real_escape_string($active_db, $text);
}

/**
 * Lock a table.
 */
function db_lock_table($table) {
    db_query('LOCK TABLES {'. db_escape_table($table) .'} WRITE');
}

/**
 * Unlock all locked tables.
 */
function db_unlock_tables() {
    db_query('UNLOCK TABLES');
}

/**
 * Check if a table exists.
 */
function db_table_exists($table) {
    return (bool) db_fetch_object(db_query("SHOW TABLES LIKE '{". db_escape_table($table) ."}'"));
}

/**
 * Check if a column exists in the given table.
 */
function db_column_exists($table, $column) {
    return (bool) db_fetch_object(db_query("SHOW COLUMNS FROM {". db_escape_table($table) ."} LIKE '". db_escape_table($column) ."'"));
}

/**
 * Wraps the given table.field entry with a DISTINCT(). The wrapper is added to
 * the SELECT list entry of the given query and the resulting query is returned.
 * This function only applies the wrapper if a DISTINCT doesn't already exist in
 * the query.
 *
 * @param $table Table containing the field to set as DISTINCT
 * @param $field Field to set as DISTINCT
 * @param $query Query to apply the wrapper to
 * @return SQL query with the DISTINCT wrapper surrounding the given table.field.
 */
function db_distinct_field($table, $field, $query) {
    $field_to_select = 'DISTINCT('. $table .'.'. $field .')';
    // (?<!text) is a negative look-behind (no need to rewrite queries that already use DISTINCT).

    return preg_replace('/(SELECT.*)(?:'. $table .'\.|\s)(?<!DISTINCT\()(?<!DISTINCT\('. $table .'\.)'. $field .'(.*FROM )/AUsi', '\1 '. $field_to_select .'\2', $query);
}
