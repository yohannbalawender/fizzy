<?php

require_once 'core/query.php';
require_once 'core/model.php';

/**
 * Post model
 */
class Post extends Model {
    protected static $keys = array('Id');

    protected $attr;

    public function __construct($attrs) {
        if (!is_array($attrs)) {
            throw new Exception("Expected an array to define post model attributes.");
        }

        foreach ($attrs as $key => $value) {
            $this->set($key, $value);
        }

        $this->_isFetched = true;
    }

    public function fetch($id) {
        $this->_isFetched = false;

        $q = Query::getInstance();
        $stmt = $q->prepare('SELECT * FROM posts WHERE Id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $stmt->execute();

            while ($l = $stmt->fetch(PDO::FETCH_ASSOC)) {
                foreach ($l as $key => $val) {
                    $this->set($key, $val);
                }
            }

            $this->_isFetched = true;

            return true;
        } catch(Exception $e) {
            $this->stackErrors[] = $e;

            return false;
        }
    }

    public function update() {
        parent::check();

        $this->save();
    }

    public function save() {
        $q = Query::getInstance();
        list($exec, $params) = $this->getBindedParams();

        $stmt = $q->prepare(
            sprintf('REPLACE INTO posts SET %s', $params)
        );

        try {
            $stmt->execute($exec);

            return true;
        } catch(Exception $e) {
            $this->stackErrors[] = $e;

            return false;
        }
    }
}

?>