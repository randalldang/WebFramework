<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call: convert.class.php!');
}

/**
 * This class is used to convert a resource into specified format.
 */
class Convert {
    /**
     * Atom function to convert a date to Unix timestamp.
     * @param string $date date to be converted
     * @return int
     */
    public static function toTimeStamp($date) {
        if (0 > ($date = strtotime($date))) {
            $date = 0;
        }

        return $date;
    }

    /**
     * Atom function to convert a date as specified format.
     * @param string $date date to be converted
     * @param string $format specified format
     * @return string
     */
    public static function toDateTime($date, $format = NULL) {
        $date = strtotime($date);
        if (0 > $date) {
            $date = 0;
        }

        if ($format) {
            $result = date($format, $date);
        }
        else {
            $result = date("Y-m-d", $date);
        }

        return $result;
    }

    /**
     * Atom function to convert a number as '$xx,xxx.xx' format.
     * @param float $amount original number
     * @return string
     */
    public static function toDollar($amount, $is_N = FALSE) {
        $value = '$' . number_format($amount, 2);
        if ($is_N) {
            $value = ($value != '$0.00') ? $value : 'N/A';
        }

        return $value;
    }

    /**
     * Atom function to convert a number as specified format.
     * @param float $number original number
     * @param int $decimals reserved decimals
     * @return string
     */
    public static function toNumber($number, $decimals = 0, $is_N = FALSE) {
        $value = number_format($number, $decimals);
        if ($is_N) {
            $value = ($number != 0) ? $value : 'N/A';
        }

        return $value;
    }

    /**
     * Atom function to convert a number as 'XX.XX%' percentage format.
     * @param float $number the original number
     * @return string
     */
    public static function toPercent($number) {
        return number_format($number * 100, 2) . '%';
    }

    /**
     * Encodes an URL by converting '&' to '%26'.
     * @param string $url URL to be encoded
     * @return string
     */
    public static function encodeUrl($url) {
        $url = rawurlencode($url);
        $url = str_replace('_', '%5F', $url);
        $url = str_replace('-', '%2D', $url);
        $url = str_replace('.', '%2E', $url);

        return $url;
    }

    /**
     * Decodes URL by converting '%26' to '&'.
     * @param string $url URL to be decoded
     * @return string
     */
    public static function decodeUrl($url) {
        return rawurldecode($url);
    }

    /**
     * Converts special characters to HTML entities htmlspecialchars().
     * @param string $string original string
     * @return string
     */
    public static function escapeHtml($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Converts all applicable characters to HTML entities by htmlentities().
     * @param string $string original string
     * @return string
     */
    public static function toHtml($string) {
        return htmlentities($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Adds slashes to a string by using function addslashes().
     * @param string or array $value original object.
     * @return string or array
     */
    public static function quote($value) {
        return is_array($value) ? array_map(array($this, 'quote'), $value) : addslashes($value);
    }

    /**
     * Escapes the special characters.
     * @param String $string
     * @return String
     */
    public static function escape($string) {
        $escaped = preg_replace('/<(.*)>/i', "&lt;$1&gt;", $string);
        $escaped = preg_replace('/<(\/.*)>/i', "&lt;$1&gt;", $escaped);
        $escaped = addslashes($escaped);

        return $escaped;
    }

    /**
     * Adds slashes to a string by using function addslashes() and escape wildcard % and _.
     * @param string $string original string
     * @return string
     */
    public static function quoteWildcard($string) {
        return str_replace('_', '\_', str_replace('%', '\%', addslashes($string)));
    }

    /**
     * Unquotes a string by using function stripslashes().
     * @param string or array $value original object.
     * @return string or array
     */
    public static function unquote($value) {
        return is_array($value) ? array_map(array($this, 'unquote'), $value) : stripslashes($value);
    }

    /**
     * Unquotes a string and format the HTML special chars in it.
     * @param string $string original string
     * @return string
     */
    public static function resumeHtml($string) {
        return htmlspecialchars(stripslashes($string), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Converts resource to an array if necessary.
     * @param mixed $convert_source the source to be converted
     * @return array if the source is array, return itself; or an array with an element of the source
     */
    public static function toArray($convert_source) {
        return is_array($convert_source) ? $convert_source : array ($convert_source);
    }

    /**
     * Generates 'INSERT' SQL based on given tables, parameters.
     * @param string $table table to be inserted
     * @param array $parameters array contains insert key and value
     * @return string the generated SQL statement
     */
    public static function toSqlInsert($table, $parameters) {
        $names = array ();
        $values = array ();

        foreach ($parameters as $name => $value) {
            $names[] = $name;

            if ('NOW()' == $value || 'UUID()' == $value) {
                $values[] = $value;
            }
            else if ('' == $value || 'NULL' == $value) {
                $values[] = "NULL";
            }
            else {
                $value = mysql_real_escape_string(stripslashes($value));
                $values[] = "'{$value}'";
            }
        }
        $names = implode(',', $names);
        $values = implode(',', $values);

        $sql = "INSERT INTO {$table} ({$names}) VALUES ({$values})";

        self::logSql('Insert', $sql);

        return $sql;
    }

    /**
     * Generates 'DELETE' SQL based on give table, conditions.
     * @param string $table table name to delete record(s)
     * @param mixed $conditions array or string specifies the deletion conditions
     * @return string the generated SQL statement
     */
    public static function toSqlDelete($table, $conditions) {
        $wheres = implode(' AND ', self::toArray($conditions));
        if (NULL == $wheres) {
            $wheres = '1 = 1';
        }

        $sql = "DELETE FROM {$table} WHERE {$wheres}";

        self::logSql('Delete', $sql);

        return $sql;
    }

    /**
     * Generates 'SELECT' SQL based on given tables, columns and conditions.
     * @param mixed $tables array or string specifies tables
     * @param mixed $cols array or string specifies fetched fields
     * @param mixed $conditions array or string specifies conditions
     * @param string $others other conditions like GROUP BY, ORDER BY, LIMIT...
     * @return string the generated SQL statement
     */
    public static function toSqlSelect($tables, $cols, $conditions, $others = '') {
        $table_names = implode(',', Convert::toArray($tables));
        $col_names = implode(',', Convert::toArray($cols));
        if (NULL == $col_names) {
            $col_names = '*';
        }
        $wheres = implode(' AND ', Convert::toArray($conditions));
        if (NULL == $wheres) {
            $wheres = '';
        }
        else {
            $wheres = 'WHERE ' . $wheres;
        }

        if (is_array($others)) {
            $others = implode('  ',  $others);
        }

        $sql = "SELECT {$col_names} FROM ({$table_names}) {$wheres} {$others}";

        self::logSql('Select', $sql);

        return $sql;
    }

    /**
     * Generates 'UPDATE' SQL based on given table, parameters.
     * @param string $table table name to be updated
     * @param array $parameters array with field names and values
     * @param mixed $conditions array or string specifies the update conditions
     * @param string $others other conditions like ORDER BY, LIMIT...
     * @return string the generated SQL statement
     */
    public static function toSqlUpdate($table, $parameters, $conditions, $others = '') {
        $sets = array ();

        foreach ($parameters as $name => $value) {
            if (NULL === $value && Convert::checkNullField($table, $name)) {
                $sets[] = "{$name}=NULL";
            }
            else  {
                $value = mysql_real_escape_string(stripslashes($value));
                $sets[] = ($value == 'NOW()' || $value == 'UUID()') ? "{$name}={$value}" : "{$name}='{$value}'";
            }
        }

        $sets = implode(',', $sets);
        $wheres = implode(' AND ', Convert::toArray($conditions));
        if (NULL == $wheres) {
            $wheres = '1 = 1';
        }

        $sql = "UPDATE {$table} SET {$sets} WHERE {$wheres} {$others}";

        self::logSql('Update', $sql);

        return $sql;
    }

    /**
     * Checks whether the array is integers indexed.
     * @param array $array
     * @return boolean
     */
    public static function isPureArray($array) {
        $is_pure_array = TRUE;
        $i = 0;
        foreach ($array as $key => $value) {
            if ($key != $i++) {
                $is_pure_array = FALSE;
                break;
            }
        }

        return $is_pure_array;
    }

    /**
     * Replace the special characters in given string with underlines.
     * @param string $string
     * @return boolean
     */
    public static function toUnderline($string) {
        return preg_replace('/\W/', '_', $string);
    }

    public static function checkNullField($table, $name) {
        return TRUE;
    }

    /**
     * 把字符串中的中文逗号替换为英文逗号
     */
    public static function replaceCommas($string) {
    	return str_replace('，', ',', $string);
    }

    /**
     * 在debug模式下记录所有的SQL语句。
     *
     * @param String $type, SQL 语句的类型。
     * @param String $sql，要记录的SQL语句。
     */
    public static function logSql($type, $sql) {
	    if (var_get('system_debugging', FALSE)) {
	       	$sql_event = new SqlEvent();
	       	$sql_event->sql_type = $type;
	       	$sql_event->sql = $sql;

	       	$logger = LogFactory::getLogger();
	       	$logger->logInfo($sql_event);
	    }
    }
   
    /**
     * XSS 过滤。
     *
     * @param String $string, 提交的参数。
     * @param boolean $html_tag,是否删除HTML标记,默认删除。
     */
    public static function escapeXSS($string, $html_tag = TRUE) {
        if (TRUE == $html_tag) {
        	$string = strip_tags($string);
        }
        $result = htmlspecialchars($string);
        
        return $result;
    }
}
?>