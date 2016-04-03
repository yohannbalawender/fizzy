<?php

/**
 * @var Singleton
 */
class Query {
    private static $_inst = null;
    private static $dsn = null;
    private static $username = null;
    private static $password = null;

    private function __construct() {
    }

    public function define($dsn, $username, $password) {
        self::$dsn = $dsn;
        self::$username = $username;
        self::$password = $password;
    }

    public function getInstance() {
        if (is_null(self::$_inst)) {
            self::$_inst = new PDO(self::$dsn, self::$username, self::$password);

            self::$_inst->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$_inst;
    }
}

?>