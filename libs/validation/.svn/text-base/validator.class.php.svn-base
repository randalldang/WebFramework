<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call:validator!');
}

/**
 * This class is used to do general validation with specified rule and resource.
 */
class Validator {
    /**
     * Atom function to check string is not empty.
     * @param string $string string to be checked
     * @return boolean
     */
    public function notEmpty($string) {
        return (bool) (NULL != trim($string));
    }

    /**
     * Atom function to check if a string is a valid username.
     * @param string $string username to be validated
     * @return array
     */
    public function isUserName($string) {
        $is_valid = TRUE;
        $message = 'success';

        if (!eregi('(^[_.0-9a-z-]+$)', $string)) {
            $is_valid = FALSE;
            $message = 'User Name format is incorrect.';
        }
        else if (3 > strlen($string)) {
            $is_valid = FALSE;
            $message = 'User Name is too short. It should contain at least 3 characters.';
        }
        else if (50 < strlen($string)) {
            $is_valid = FALSE;
            $message = 'User Name is too long. It should contain no more than 50 characters.';
        }
        else if (is_numeric($string) || is_numeric($string{0}) || ('_' == $string{0})){
            $is_valid = FALSE;
            $message = 'User Name format is incorrect.';
        }
        
        $result = array();
        $result['valid'] = $is_valid;
        $result['message'] = $message;
        
        return $result;
    }

    /**
     * Atom function to check string is a valid email address.
     * @param string $string string to be checked
     * @return boolean
     */
    public function isEmail($string) {
        return (bool) preg_match('/^[\w-]+(\.[\w-]*)*@([\w-]+\.)+[\w-]{2,4}$/', trim($string));
    }

    /**
     * Atom function to check string is a valid URL.
     * @param string $string string to be checked
     * @return boolean
     */
    public function isUrl($string) {
        return (bool) preg_match('/^(http|https):\/\/([\w-]+\.)+[\w-]{2,4}(:\d+)?(\/[\w- .\/\?%&=]*)?$/', trim($string));
    }

    /**
     * Atom function to check string is a valid date.
     * @param string $string string to be checked
     * @return boolean
     */
    public function isDate($string) {
        $is_valid = TRUE;

        if (!ereg('([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})', $string)) {
            $is_valid = FALSE;
        }
        if ($is_valid) {
            $date_ymd = explode('-', $string);
            try {
                $is_valid = (bool) checkdate($date_ymd[1], $date_ymd[2], $date_ymd[0]);
                if ($is_valid) {
                    $is_valid = (bool) mktime(0, 0, 0, $date_ymd[1], $date_ymd[2], $date_ymd[0]);
                }
            }
            catch (PHPException $e) {
                $is_valid = FALSE;
            }
        }

        return $is_valid;
    }

    /**
     * Atom function to check string is a valid int value.
     * @param string $string string to be checked
     * @return boolean
     */
    public function isInt($string) {
        return (bool) ereg('(^[*0-9]+$)', $string);
    }

    /**
     * Atom function to check string is a valid phone number.
     * @param string $string string to be checked
     * @return boolean
     */
    public function isPhone($string) {
        return (bool) ereg('(^[\ \(*\)0-9\-]+$)', $string);
    }

    /**
     * Atom function to check string is a valid credit card code (3 or 4 digits).
     * @param string $string string to be checked
     * @return boolean
     */
    public function isCardCode($string) {
        return (bool) ereg('(^[0-9][0-9]{1,2}[0-9]$)', $string);
    }
}
?>