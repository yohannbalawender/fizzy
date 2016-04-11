<?php

require_once 'core/query.php';
require_once 'core/collection.php';
require_once 'core/models/post.php';

/**
 * Post model
 */
class Posts extends Collection {
    public $models = array();

    public function fetch($conds = '', $values = array()) {
        $this->_isFetched = false;

        $q = Query::getInstance();
        
        $sql = 'SELECT * FROM posts';

        if (!empty($conds)) {
            $sql = sprintf('%s %s', $sql, $conds);
        }

        $stmt = $q->prepare($sql);

        foreach ($values as $key => $value) {
            $stmt->bindParam(':' . $key, $value, PDO::PARAM_INT);
        }

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