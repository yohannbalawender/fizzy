<?php
/**
 * Gestion des connexions au site et a la BDD
 * @version 1.00
 */

class Layout {
    public static function listDelagates($delegator) {
        /* app, files */
        return array(
            $delegator['app'],
            $delegator['files']
        );
    }
}

?>
