<?php

require_once 'core/query.php';
require_once 'core/collection.php';
require_once 'core/models/post.php';

/**
 * Post model
 */
class Posts extends Collection {
    public $models = array();

    public function fetch() {
        $this->_isFetched = false;

        $q = Query::getInstance();
        $stmt = $q->prepare('SELECT * FROM posts');

        try {
            $stmt->execute();

            while ($l = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $this->models[] = new Post($l);
            }

            $this->_isFetched = true;

            return true;
        } catch(Exception $e) {
            $this->stackErrors[] = $e;

            return false;
        }
    }
}

?>