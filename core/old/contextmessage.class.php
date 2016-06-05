<?php
/**
 * Classe de gestion et de publication des messages contextuels
 */
class ContextMessage {
	// Lib d'erreurs
	private static $errorsDatabase = 
	array(
		"a" => // "a" pour authentification
			array("err" => // curPage/login/password non initialises pour l'authentification
					"Un problème est survenu lors de l'authentification.<br />
					Veuillez réessayer ultériement ou contacter directement l'administrateur.",
				  "inct" => // Login ou password incorrects
					"Erreur, le nom d'utilisateur ou le mot de passe saisi est incorrect.",
				  "p_emp" => // Password manquant
					"Saississez votre mot de passe.",
				  "l_emp" => // Login manquant
					"Saississez votre nom d'utilisateur.",
				  "s_emp" => // Statut manquant
					"Indiquez un espace correct.",
				  "nt_auth" => // Non authentifie
					"Erreur, vous n'&ecirc;tes pas identifi&eacute;.<br />
					Veuillez vous connecter avec vos identifiants habituels.",
				  "s_unkn" => // Statut inconnu
					"Erreur, nous n'avons pas pu retrouver vos informations.<br />
					Veuillez essayer un autre espace ou contacter directement l'administrateur."
				 ),
		"e" => // "e" pour erreur
			array("a" => // L'utilisateur n'a pas acces a cette page
					"L'acc&egrave;s &agrave; cette page vous a &eacute;t&eacute; refus&eacute;.<br />
					Veuillez réessayer ultériement ou contacter directement l'administrateur."
				 )
	);
	// Message d'erreur
	private static $errorMessage = array();
	// Message de confirmation
	private static $confirmMessage = array();
	// Message d'information
	private static $infoMessage = array();
	// Nb de message dans la "base"
	public static $nbErrorMessage = 0;
	public static $nbConfirmMessage = 0;
	public static $nbInfoMessage = 0;

    function ContextMessage() { 

    }

    // Setter
    public function __set($attr,$value) {
		if (isset($this->$attr)) {
			$this->$attr = $value;
		} else {
			throw new Exception('Unknow attribute '.$attr);
		}
    }

    // Getter
	public function __get($attr) {
		if (isset($this->$attr)) {
			return $this->$attr;
		} else {
			throw new Exception('Unknow attribute '.$attr);
		}
	}

	public static function putErrorMessage($type, $param) {
		if (isset(ContextMessage::$errorsDatabase[$type][$param])) {
			ContextMessage::$errorMessage[] = ContextMessage::$errorsDatabase[$type][$param];
			ContextMessage::$nbErrorMessage++;
		} else {
			return false;
		}
	}

	public static function putExtraErrorMessage($msg) {
		ContextMessage::$errorMessage[] = $msg;
		ContextMessage::$nbErrorMessage++;
	}

	public static function putConfirmMessage($msg) {
		ContextMessage::$confirmMessage[] = $msg;
		ContextMessage::$nbConfirmMessage++;
	}

	public static function putInfoMessage($msg) {
		ContextMessage::$infoMessage[] = $msg;
		ContextMessage::$nbInfoMessage++;
	}

	public static function displayAllContextMessages() {
		// Priorite aux messages d'erreur
		if (ContextMessage::$nbErrorMessage > 0) {
			foreach(ContextMessage::$errorMessage as $idx => $msg) {
				echo "<p><span class=\"errorMessage\">".$msg."</span></p>";	
			}
		} else if(ContextMessage::$nbConfirmMessage > 0) {
			foreach(ContextMessage::$confirmMessage as $idx => $msg) {
				echo "<p><span class=\"confirmMessage\">".$msg."</span></p>";	
			}
		}
	}

}
?>