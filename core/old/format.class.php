<?php
/**
 * Gestion, operation et verification des formats de donnees
 * sous forme de sous-classes
 */

class IAFormat {

	function __construct() {
	}

	/**
	 * Verifie la validite d'une variable string
	 * Et renvoie la chaine en echappant les balises
	 */
	public static function isStringValidated($var) {
		if( isset($var) && $var != "" ) {
			return trim(htmlentities($var));
		} else {
			return false;
		}
	}
	
	/**
	 * Verifie la validite d'une variable numerique
	 * Et renvoie le nombre en echappant les balises
	 */
	public static function isNumberValidated($var) {
		if( isset($var) && filter_var($var, FILTER_VALIDATE_INT) ) {
			return $var;
		} else {
			return false;
		}
	}
	
	/**
	 * Verifie la validite d'une adresse mail
	 */
	public static function isMailAddress($var) {
		if( isset($var) && $var != "" && filter_var($var, FILTER_VALIDATE_EMAIL) ) {
			return trim(htmlentities($var));
		} else {
			return false;
		}
	}

	/**
	 * Verifie la validite d'une date
	 */
	public static function isDateValidated($date) {
		$regexp = self::$regexpLang[self::$lang];

		return preg_match($regexp, $date);
	}

	/**
	 * Ajout d'un 0 si le numero.length = 9
	 */
	public static function formatNumeroTel($NumeroTel) {
		if (strlen($NumeroTel) == 9) {
			return '0'.$NumeroTel;
		} else {
			if (strlen($NumeroTel) > 10) {
				$NumeroTel = str_replace(' ', '', $NumeroTel);
			}
			return $NumeroTel;
		}
	}
}

/**
 * TODO
 * Donner format actuel + donner format a acquerir + default lang + lang to set => function convert !
 */
class IADate extends IAFormat {
	// Formats acceptes
	private static $acceptedLang = array('fr', 'en');
	// Regexp correspondants
	private static $regexpLang = array('fr' => '~^\d{2}/\d{2}/\d{4}$~', 'en' => '.');
	// Par defaut
	private static $defaultLang = 'fr';
	private static $defaultSuffixYear = '20';

	function __construct() {
	}

	public static function setDefaultLang($_lang) {
		if (in_array($_lang, self::$acceptedLang)) {
			self::$defaultLang = $_lang;
		} else {
			return false;
		}
	}

	public static function setDefaultSuffixYear($_suff) {
		self::$defaultSuffixYear = $_suff;
	}

	/**
	 * Conversion des dates DD/MM/YY vers YY-MM-DD
	 */
	public static function convertDMYtoYMD($ddmmyy) {
		return substr($ddmmyy, 6, 2).'-'.substr($ddmmyy, 3, 2).'-'.substr($ddmmyy, 0, 2);
	}
	
	/**
	 * Conversion des dates DD/MM/YYYY vers YYYY-MM-DD
	 */
	public static function convertDMYtoYYMD($ddmmyyyy) {
		return substr($ddmmyyyy, 6, 4).'-'.substr($ddmmyyyy, 3, 2).'-'.substr($ddmmyyyy, 0, 2);
	}

	/**
	 * Conversion des dates SQL YYYY-MM-DD vers DD/MM/YY
	 */
	public static function convertYYMDtoDMY($yyyymmdd) {
		return substr($yyyymmdd, 8, 2).'/'.substr($yyyymmdd, 5, 2).'/'.substr($yyyymmdd, 2, 2);
	}

	/**
	 * Conversion des dates SQL YYYY-MM-DD vers DD/MM/YYYY
	 */
	public static function convertYYMDtoDMYY($yyyymmdd) {
		return substr($yyyymmdd, 8, 2).'/'.substr($yyyymmdd, 5, 2).'/'.substr($yyyymmdd, 0, 4);
	}

	public static function convertYYMDtoMY($yyyymmdd) {
		return substr($yyyymmdd, 5, 2).'/'.substr($yyyymmdd, 0, 4);
	}

	public static function shiftDateSQL_YMD($date, $shiftDays) {
		$newTs = mktime(0, 0, 0, substr($date, 5, 2), substr($date, 8, 2)+$shiftDays, substr($date, 0, 4));
		return date("Y-m-d", $newTs);
	}

	/**
	 * Compare deux dates et retourne la plus recente
	 * Format DD/MM/YY
	 */
	public static function getMaxDate($d1, $d2) {
		$d1_eval = (int)substr($d1, 6, 2).substr($d1, 3, 2).substr($d1, 0, 2);
		$d2_eval = (int)substr($d2, 6, 2).substr($d2, 3, 2).substr($d2, 0, 2);
		if($d1_eval<$d2_eval)
			return $d2;
		else
			return $d1;
	}

	/**
	 * Compare deux dates et retourne la plus ancienne
	 * Format DD/MM/YY
	 */
	public static function getMinDate($d1, $d2) {
		$d1_eval = (int)substr($d1, 6, 4).substr($d1, 3, 2).substr($d1, 0, 2);
		$d2_eval = (int)substr($d2, 6, 4).substr($d2, 3, 2).substr($d2, 0, 2);
		if($d1_eval<$d2_eval)
			return $d1;
		else
			return $d2;
	}
}

class IAArray extends IAFormat {

	function __construct() {
	}

	/**
	 * Transfere les donnees d'un tableau source vers un tableau cible
	 */
	public function transferDataFromGivenArrayToAnother(&$fromArr, &$toArr) {
		$toArr[] = $fromArr;
		unset($fromArr);
		return;
	}

	/**
	 * Supprime les cles communes des tableaux passes en parametres
	 */
	public static function unionKeyArrays($arr1, $arr2) {
		foreach ($arr1 as $key => $val) {
			if (array_key_exists($key, $arr2)) {
				unset($arr1[$key]);
				unset($arr2[$key]);
			}
		}

		return array($arr1, $arr2);
	}
}

?>
