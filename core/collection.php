<?php

/**
 * @var Abstract
 */
abstract class Collection {
    /* Must be overriden */
    protected $_isFetched = false;
    protected $models;
    public $stackErrors;

    public function __construct() {
    }

    public function at($index) {
        if ($index > count($this->models)) {
            return false;
        }

        return $this->models[$index];
    }

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