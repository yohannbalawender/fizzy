<?php

/**
 * Utilitary libraries
 */
class FError {
    public static $UNKNOWN = 999;

    public $response = array();

    public function __construct($error, $code = null) {
        if (is_null($code)) {
            $code = self::$UNKNOWN;
        }

        $this->response = array(
            'error' => $error,
            'code' => $code
        );
    }

    public function getResponse($fmt) {
        $response = $this->response;

        switch ($fmt) {
          case 'json':
            return json_encode($response);
        }

        return $response;
    }
}

?>