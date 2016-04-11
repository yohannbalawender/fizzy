<?php

/**
 * @var Abstract
 */
abstract class Collection {
    /* Must be overriden */
    protected $_isFetched = false;
    protected $models;

    public $order = null;
    public $offset = null;
    public $limit = null;
    public $stackErrors;

    public function __construct() {
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
}

?>