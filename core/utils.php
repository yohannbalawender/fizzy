<?php

/**
 * Utilitary libraries
 */
class Utils {
    public static function getAllDeps($deps, $name) {
        $defaults = self::getDeps($deps, 'defaults');

        $localDeps = self::getDeps($deps, $name);

        return array_merge_recursive($localDeps, $defaults);
    }

    public static function getDeps($deps, $name) {
        $dep = __::find($deps, function($dep) use ($name) {
            return $dep['name'] === $name;
        });

        if (!is_array($dep)) {
            error_log(sprintf('Empty dependencies for %s', $name));

            return array();
        }

        return $dep;
    }
}

?>