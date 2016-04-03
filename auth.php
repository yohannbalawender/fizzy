<?php

/**
 * Fonction de connexion utilisateur
 * Retourne true si OK, false si la connexion a echoue
 */
function auth() {
	// Connexion PDO
	require_once('lib/connexion.class.php');
	$co = new Connexion();
	$pdo = $co->setBddConnection(); 
	// Recuperer les variables POST
	if (isset($_POST['licence']) && $_POST['licence'] != "") {
		$licence = trim(htmlentities($_POST['licence']));
	} else {
		ContextMessage::putExtraErrorMessage("Veuillez saisir votre nom d'utilisateur.");
	}

	if (isset($_POST['password']) && $_POST['password'] != "") {
		$password = sha1(trim(htmlspecialchars($_POST['password'], ENT_XHTML, "UTF-8")));
	} else {
		ContextMessage::putExtraErrorMessage("Veuillez saisir votre mot de passe.");
	}

	$query_saison = "SELECT DISTINCT(Saison) FROM arbitres WHERE Licence='".$licence."'";
	try {
		$result_query = $pdo->query($query_saison);
	} catch (PDOException $e) {
		die ('Erreur de connexion avec la base de données - veuillez contacter votre administrateur');
	}
	while ($line = $result_query->fetch(PDO::FETCH_ASSOC)) {
		if ($line['Saison'] == '2015-2016') {
			$season = '2015-2016';
			break;
		} else {
			$season = '2014-2015';
		}
	}
	if (!isset($season)) {
		ContextMessage::putExtraErrorMessage("Ce numéro de licence n'existe pas.");
	}
	
	// Si l'un des 2 parametres n'est pas valide, stopper l'authentification
	if (ContextMessage::$nbErrorMessage > 0) {
		return false;
	}

	$query = "SELECT *, EXISTS(SELECT COUNT(*) FROM delegues WHERE Arbitres_Licence='" . $licence . "') AS Is_Official
		FROM arbitres WHERE Licence = '" . $licence . "' AND Saison='".$season."'";
	try {
		$result_pdo = $pdo->query($query);
	} catch(Exception $e) {
		// Erreur lors de la requete, rediriger
		ContextMessage::putExtraErrorMessage("Erreur de connexion avec la base de donn&eacute;es - veuillez contacter votre administrateur");
		return false;
	}

	// Si result_pdo n'a pas retourne de resultats, il est a false, on retourne false
	if ($line = $result_pdo->fetch(PDO::FETCH_ASSOC)) {
		if ($password == $line['Password']) {
			session_start();
			if ($line['Statut'] == 'VALIDEE') {
				$_SESSION['Is_Validee'] = 1;
			} else {
				$_SESSION['Is_Validee'] = 0;
			}
			$_SESSION['Is_Admin'] = $line['Is_Admin'];
			/* Attention, les centres ne sont plus dans la table arbitres */
			// $_SESSION['Centre'] = $line['Centre_Lk'];
			$_SESSION['Nom'] = $line['Nom'];
			$_SESSION['Prenom'] = $line['Prenom'];
			$_SESSION['Licence'] = $line['Licence'];
			if ($line['Is_Admin'] == "1") {
				$_SESSION['is_admin'] = "Admin";
			} else if ($line['Is_Admin'] == 2) {
				$_SESSION['is_admin'] = "Centre";
			}
			if ($line['Is_Official'] == "1") {
				$_SESSION['status'] = 'Delegues';
			} else {
				$_SESSION['status'] = 'Arbitres';
			}
			$_SESSION['Mail'] = $line['Mail'];
			$_SESSION['Tel_Bureau'] = $line['Tel_Bureau'];
			$_SESSION['Tel_Fixe'] = $line['Tel_Fixe'];
			$_SESSION['Tel_Mobile'] = $line['Tel_Mobile'];
			if ($line['first_pass'] == 1) {
				$_SESSION['first_pass'] = 1;
			} else {
				$_SESSION['first_pass'] = 0;
			}
			$_SESSION['isNew'] = false;
			if ($line['Saison'] != IADate::getCurrentSeason()) {
				$_SESSION['isNew'] = true;
			}
			$_SESSION['saison'] = $line['Saison'];
		} else {
			return false;
		}
	} else {
		return false;
	}
	$result_pdo->closeCursor();

	/* init */
	$_SESSION['hasRegister'] = false;

	$nextSeason = IADate::shiftCurrentSeason(1);
	$registerQuery = "SELECT * FROM arbitres WHERE Licence = '" . $licence . "' AND Saison='" . $nextSeason . "'";
	try {
		$resultRegister = $pdo->query($registerQuery);

		if ($resultRegister) {
			if ($resultRegister->fetch()) {
				$_SESSION['hasRegister'] = true;
			}
		} else {
			throw new Exception("Erreur lors de la r&eacute;cup&eacute;ration des informations de la r&eacute;inscription.");
		}
	} catch (PDOException $e) {
		return false;
	}
	$result_pdo->closeCursor();
	
	// Log de la connexion
	$time = time();
	$_SESSION['user_entree'] = date("Y-m-d H:i:s", $time);
	$query = "INSERT INTO connexions (licence,date_entree,date_sortie,ip) VALUES('".$_SESSION['Licence']."','".$_SESSION['user_entree']."','".$_SESSION['user_entree']."','".$_SERVER['REMOTE_ADDR']."')";
	try {
		$ret = $pdo->query($query);
	} catch (PDOException $e) {
		die( 'Échec de connexion à la base de données');
	}
	// Connexion OK
	$ret->closeCursor();
	return true;
}
?>