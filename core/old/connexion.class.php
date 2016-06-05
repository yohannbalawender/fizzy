<?php
/**
 * Gestion des connexions au site et a la BDD
 * @version 1.00
 */

class Connexion {
	public $isUserConnected;
	public $connexion;

	function __construct() {
		// Verifie si l'utilisateur est connecte
		if( isset($_SESSION['login']) ) {
			$this->isUserConnected = true;
		} else {
			$this->isUserConnected = false;
		}
	}
	
	/**
	 * Connection a la BDD
	 * Fichier de configuration deja charge au lancement de cette fonction
	 */
	function setBddConnection() {
		try {
			$connexion = new PDO(Conf::$dsn, Conf::$username, Conf::$password, Conf::$opts);
			$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(Exception $e) {
			die ('Erreur de connexion &agrave; la base de donn&eacute;e : veuillez contacter votre administrateur.<br />');
		}
		
		return $connexion;
	}
	
	/**
	 * Deconnecte l'utilisateur et detruit sa session
	 */
	function bddDisconnexion() {
		foreach($_SESSION as $var) {
			unset($var);
		}
		session_destroy();
		header("Location: ./index.php?event=logout");
	}

	public function loadAdminParameters() {
		// Objet PDO
		$pdo = self::setBddConnection();
		// Requete
		$query_params = "SELECT * FROM admin";
		// Execution de la requete
		try {
			// Requete OK
			$result = $pdo->query($query_params);
		} catch(Exception $e) {
			// Erreur lors de la requete, rediriger
			ContextMessage::putExtraErrorMessage("Erreur lors de la requete - veuillez contacter votre administrateur");
			return;
		}
		// Var de boucle, par defaut
		$sanctionDays = 10;
		$delayDays = 15;
		// Alimentation des variables parametres
		$sanctionDays = '';
		$delayDays = '';
		$dateImportReferees = '';
		$dateImportDelegues = '';
		$dateImportOutages = '';
		$dateImportMatchs = '';
		$dateImportCompetitions = '';
		$dateImportClubs = '';
		while($line = $result->fetch()) {
			if ($line['Element'] == "Sanction") {
				$sanctionDays = $line['ValFloat'];
			} else if ($line['Element'] == "Delai") {
				$delayDays = $line['ValFloat'];
			} else if ($line['Element'] == "DateImportArbitres") {
				$dateImportReferees = $line['ValStr'];
			} else if ($line['Element'] == "DateImportIndispos") {
				$dateImportOutages = $line['ValStr'];
			} else if ($line['Element'] == "DateImportMatches") {
				$dateImportMatchs = $line['ValStr'];
			} else if ($line['Element'] == "DateImportCompetitions") {
				$dateImportCompetitions = $line['ValStr'];
			} else if ($line['Element'] == "DateImportClubs") {
				$dateImportClubs = $line['ValStr'];
			} else if ($line['Element'] == "DateImportDelegues") {
				$dateImportDelegues = $line['ValStr'];
			}
		}
		// Libere l'espace memoire
		$pdo = null;
		// Retourne les deux parametres
		return array($sanctionDays, $delayDays, $dateImportReferees, $dateImportOutages, $dateImportMatchs, $dateImportCompetitions, $dateImportClubs, $dateImportDelegues);
	}
}
?>