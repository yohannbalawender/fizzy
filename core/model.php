<?php

/**
 * @var Abstract
 */
abstract class Model {
    public static $name = null;

    /* Must be overriden */
    protected static $keys;

    protected $_isFetched = false;
    protected $attr = array();
    public $stackErrors;

    public function __construct() {
        if (!is_array(static::$keys) || empty(static::$keys)) {
            throw new Exception("Excepted keys model to be an non-array.");
        }

        if (is_null(static::$name)) {
            throw new Exception("Expected name model not to be null.");
        }
    }

    /**
     * Set attribute value
     * 
     * @param string $prop
     * @param mixed $val
     */
    public function set($prop, $val) {
        $this->attr[$prop] = $val;
    }

    /**
     * Get attribute value
     * 
     * @param string $prop
     */
    public function get($prop) {
        return $this->attr[$prop];
    }

    /**
     * Check if the model is fetched before performing request to server
     */
    public function check() {
        if (!$this->_isFetched) {
            throw new Exception('Fail because model is unfetched.');
        }
    }

    /**
     * @return exec Array to bind to "execute" query method
     *         params String to give to "prepare" query method
     */
    public function getBindedParams() {
        $params = array();
        $exec = array();

        foreach ($this->getAttrs() as $key => $value) {
            $param = ':'.$key;
            $params[] = $key.' = '.$param;

            $exec[$param] = $value;
        }

        return array($exec, implode(', ', $params));
    }

    public function toJson() {
        $json = $this->getAttrs();

        $json['__url__'] = static::$name;

        return json_encode($json);
    }

    public function getAttrs() {
        return $this->attr;
    }
}

?>