<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call:smarty-registration!');
}

/**
 * This class is used to register and initilize functions under Smarty for UI.
 */
class SmartyRegistration {
    /**
     * Registers all common functions under smarty for UI implementation.
     * @param mixed &$smarty reference to a smarty instance
     * @return void
     */
    public function register(&$smarty) {
        $smarty->register_modifier('date_format', array('SmartyRegistration', 'dateFormat'));
        $smarty->register_modifier('num_format', array('SmartyRegistration', 'numFormat'));
        $smarty->register_modifier('show_selected', array('SmartyRegistration', 'showSelected'));
        $smarty->register_modifier('show_checked', array('SmartyRegistration', 'showChecked'));
        $smarty->register_modifier('time_span', array('SmartyRegistration', 'timeSpan'));
        $smarty->register_modifier('t', 't');
        $smarty->register_modifier('url', 'url');
        $smarty->register_modifier('var_get', 'var_get');
        $smarty->register_modifier('thumb_url', 'thumb_url');
        $smarty->register_modifier('hsc_decode', array('SmartyRegistration', 'hsc_decode'));
    }
    
    function hsc_decode($str) {
        return htmlspecialchars_decode($str);
    }

    /**
     * Formats the
     */
    function numFormat($number, $decimals='0', $decpoint='.', $thousandsep=',') {
        return number_format($number, $decimals, $decpoint, $thousandsep);
    }

    /**
     * Formats the date
     * @param string $date_string the value of date
     * @param string $date_format the style need to display
     * @return string needed display style of date
     */
    function dateFormat($date_string, $date_format = 'Y-m-d') {
        return Convert::toDateTime($date_string, $date_format);
    }

    /**
     * Check if the current HTML option is selected.
     * @param string $current_option current option string
     * @param string $selected_option selected option string
     * @return string defines the select status
     */
    public function showSelected($current_option, $selected_option) {
        return ($current_option == $selected_option) ? 'selected="selected"' : '';
    }

    /**
     * Check if the current HTML input element is checked.
     * @param string $current_value current value string
     * @param string $checked_value checked value string
     * @return string defines the check status
     */
    public function showChecked($current_value, $checked_value) {
        return ($current_value == $checked_value) ? 'checked="checked"' : '';
    }

    /**
     * Formats the time span in second as H:i:s.
     * @param numeric $second
     * @return string
     */
    public function timeSpan($second) {
        $date_string = date("H:i:s", mktime(0,0,(NULL == $second ? 0 : (int)$second),0,0,0));
        return Convert::toDateTime($date_string, 'H:i:s');
    }
}
?>