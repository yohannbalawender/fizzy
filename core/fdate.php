<?php

/**
 * Date utilitary
 */

class FDate {
    static public $formats = array(
        'SQL' => 'Y-m-d h:i:s',
        'FR_short' => 'd/m/Y',
        'EN_short' => 'm/d/Y'
    );

    static public function convert($date, $startFormat, $endFormat) {
        if (!isset(self::$formats[$startFormat]) || !isset(self::$formats[$endFormat])) {
            throw new Exception("Unknown date format.");
        }

        $dt = Datetime::createFromFormat(FDate::$formats[$startFormat], $date);

        return $dt->format(self::$formats[$endFormat]);
    }
}

?>