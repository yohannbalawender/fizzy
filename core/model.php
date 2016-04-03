<?php

/**
 * @var Abstract
 */
abstract class Model {
    /* Must be overriden */
    protected static $keys;

    protected $_isFetched = false;
    protected $attr;
    public $stackErrors;

    public function __construct() {
        if (!is_array(static::$keys) || empty(static::$keys)) {
            throw new Exception("Excepted keys model to be an non-array.");
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

        foreach ($this->attr as $key => $value) {
            $param = ':'.$key;
            $params[] = $key.' = '.$param;

            $exec[$param] = $value;
        }

        return array($exec, implode(', ', $params));
    }
}

?>