<?php
/**
 * Gestion de la securite generale du site
 *
 */

/**
 * Gestion des token pour contrer les attaques CSRF
 *
 * Utilisation:
 * 1) Fichier source
 * 
 *		$Token = new Token(true);
 *		$Token->set();
 *		$salt = $Token->getToken();
 *
 * 2) Fichier cible
 * 
 * $Token = new Token(true, 600); // 600s, 10min
 * $extToken = ...
 * $Token->challenge($extToken)
 *
 */
class Token {
	private $token;
	private $time;
	private $referer;
	private static $timeRule;
	private static $isEnable = false;

	function __construct($enable = false, $_timeRule = 600) {
		self::$isEnable = $enable && session_id();

		self::$timeRule = $_timeRule;
	}

	/**
	 * Active ou desactive le token
	 */
	public function enable($enable) {
		self::$isEnable = $bool;
	}

	/**
	 * Test si le token est disponible ou non
	 */
	public function isEnable() {
		return self::$isEnable && session_id() != '';
	}

	/**
	 * Enregistre le token en local et en session
	 */
	public function set() {
		$this->token = uniqid(rand(), true);

		$this->time = time();

		$this->$referer = $_SERVER['HTTP_REFERER'];

		if ($this->isEnable()) {
			$_SESSION['token'] = $this->token;
			$_SESSION['token_time'] = $this->time;
			$_SESSION['token_referer'] = $this->$referer;
		}
	}

	/**
	 * Retourne les attributs du token
	 * @return {Array} token: le hash du jeton
	 *				   token_time: le timestamp d'enregistrement
	 */
	public function get() {
		if (self::$isEnable) {
			if (isset($_SESSION['token']) && isset($_SESSION['token_time'])) {
				$this->token = $_SESSION['token'];
				$this->time = $_SESSION['token_time'];
				$this->token_referer = $_SESSION['token_referer'];
			}
		}
	}

	/**
	 * Retourne le token
	 * @return {String} token: le hash du jeton
	 */
	public function getToken() {
		if (!isset($this->token) || !self::$isEnable) {
			return false;
		}

		return $this->token;
	}

	/**
	 * Test si le token n'est pas expire
	 * @return {Boolean} True si la validite est bonne, false sinon
	 */
	public function challenge($extToken) {
		if (!$this->isEnable() && $extToken !== ''
		&&  !isset($this->token) && !isset($this->time)) {
			return false;
		}

		if ($this->token === $extToken
		&&  $this->time + self::$timeRule > time()) {
			return true;
		}

		return false;
	}
}

?>