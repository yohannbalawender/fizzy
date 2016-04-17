<?php

/**
 * @var Abstract
 */
abstract class Collection {
    public static $name = null;

    /* Must be overriden */
    protected $_isFetched = false;
    public $models;

    public $order = null;
    public $offset = null;
    public $limit = null;
    public $stackErrors;

    public function __construct() {
        if (is_null(static::$name)) {
            throw new Exception("Expected name collection not to be null.");
        }
    }

    /**
     * Retrieve a model from collection
     * 
     * @param  [Integer] $index Search for a model at given index
     * @return [core/Model|False] Return a model if found, otherwise false
     */
    public function at($index) {
        if ($index > count($this->models)) {
            return false;
        }

        return $this->models[$index];
    }

    /**
     * Push given model into collection
     * 
     * @param  [core/Model] $model Model to add to collection
     */
    public function push($model) {
        $this->models[] = $model;
    }

    public function remove($index) {
        if ($index >= count($this->models)) {
            return false;
        }

        unset($this->models[$index]);
    }

    /**
     * Check if the model is fetched before performing request to server
     */
    public function check() {
        if (!$this->_isFetched) {
            throw new Exception('Fail because collection is unfetched.');
        }
    }

    public function toJson() {
        $json = array_map(function($model) {
            return $model->getAttrs();
        }, $this->models);

        $json['__url__'] = static::$name;

        return json_encode($json);
    }
}

?>