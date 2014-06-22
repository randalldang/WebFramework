<?php
if (!defined('__INCLUDE__')) {
    die('Invalid call:xml!');
}

function xml_unserialize(&$xml, $isnormal = FALSE) {
    $xml_parser = new XML($isnormal);
    $data = $xml_parser->parse($xml);
    $xml_parser->destruct();

    return $data;
}

function xml_serialize($arr, $htmlon = FALSE, $isnormal = FALSE, $level = 1) {
    $s = $level == 1 ? "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\r\n<root>\r\n" : '';
    $space = str_repeat("\t", $level);
    foreach($arr as $k => $v) {
        if(!is_array($v)) {
            $s .= $space."<item id=\"$k\">".($htmlon ? '<![CDATA[' : '').$v.($htmlon ? ']]>' : '')."</item>\r\n";
        } else {
            $s .= $space."<item id=\"$k\">\r\n".xml_serialize($v, $htmlon, $isnormal, $level + 1).$space."</item>\r\n";
        }
    }
    $s = preg_replace("/([\x01-\x09\x0b-\x0c\x0e-\x1f])+/", ' ', $s);
    return $level == 1 ? $s."</root>" : $s;
}

class XML {

    var $parser;
    var $document;
    var $stack;
    var $data;
    var $last_opened_tag;
    var $isnormal;
    var $attrs = array();
    var $failed = FALSE;

    function __construct($isnormal) {
        $this->XML($isnormal);
    }

    function XML($isnormal) {
        $this->isnormal = $isnormal;
        $this->parser = xml_parser_create('ISO-8859-1');
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_object($this->parser, $this);
        xml_set_element_handler($this->parser, 'open','close');
        xml_set_character_data_handler($this->parser, 'data');
    }

    function destruct() {
        xml_parser_free($this->parser);
    }

    function parse(&$data) {
        $this->document = array();
        $this->stack    = array();
        return xml_parse($this->parser, $data, true) && !$this->failed ? $this->document : '';
    }

    function open(&$parser, $tag, $attributes) {
        $this->failed = FALSE;
        if(!$this->isnormal) {
            if(isset($attributes['id']) && !is_string($this->document[$attributes['id']])) {
                $this->document  = &$this->document[$attributes['id']];
            } else {
                $this->failed = TRUE;
            }
        } else {
            if(!is_string($this->document[$tag])) {
                $this->document  = &$this->document[$tag];
            } else {
                $this->failed = TRUE;
            }
        }
        $this->stack[] = &$this->document;
        $this->last_opened_tag = $tag;
        $this->attrs = $attributes;
    }

    function data(&$parser, $data) {
        if($this->last_opened_tag != NULL) {
            $this->data = $data;
        } else {
            $this->data = '';
        }
    }

    function close(&$parser, $tag) {
        if($this->last_opened_tag == $tag) {
            $this->document = $this->data;
            $this->last_opened_tag = NULL;
        }
        array_pop($this->stack);
        if($this->stack) {
            $this->document = &$this->stack[count($this->stack)-1];
        }
    }

    public static function getArrayTagKey() {
        return 'array_tag';
    }

    public static function clientSerialize($object, $with_head=TRUE, $array_tag='ArrayOfAnyType') {
        $head = '<?xml version="1.0"?>';
        $name_space = 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"';
        $array_tag_key = XML::getArrayTagKey();
        $xml_content = $with_head?$head:'';
        if(is_array($object)) {
            $is_object_list = array_key_exists($array_tag_key,$object);
            if(!$is_object_list) {
                $xml_content = $xml_content . '<' .$array_tag . " $name_space>";
            }

            foreach($object as $key => $value) {
                if(strcmp($key,$array_tag_key) == 0 ) {
                    continue;
                }
                if(!$is_object_list) {
                    $xml_content = $xml_content . "<$key>";
                }
                $xml_content = $xml_content . XML::clientSerialize($value,FALSE);
                if(!$is_object_list) {
                    $xml_content = $xml_content . "</$key>";
                }
            }
            if(!$is_object_list) {
                $xml_content = $xml_content . '</' . $array_tag . '>';
            }

        } else if(is_object($object)) {
            $class_name = get_class($object);
            if(method_exists($object, 'toXML')) {
                $xml_content = $xml_content . $object->toXML(FALSE);
            } else {
                $xml_content = $xml_content . "<$class_name $name_space>";
                foreach($object as $key => $value) {
                    $xml_content = $xml_content . "<$key>";
                    $xml_content = $xml_content . XML::clientSerialize($value,FALSE);
                    $xml_content = $xml_content . "</$key>";
                }
                $xml_content = $xml_content . "</$class_name>";
            }
        } else {
            $xml_content = $xml_content . $object;
        }

        return $xml_content;
    }
}
?>