<?php
/**
 * Gestion des connexions au site et a la BDD
 * @version 1.00
 */

class Utils {
	public static $monthsLabel = array('Janvier','F&eacute;vrier','Mars','Avril','Mai','Juin','Juillet','Ao&ucirc;t','Septembre','Octobre','Novembre','D&eacute;cembre');
	public static $outagesVal = array('L', 'M', 'Me', 'J', 'V', 'S', 'D');
	function __construct() {
	}

	public static function getMonthLabel($monthNum) {
		return self::$monthLabel[--$monthNum];
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
	 * Redirige et arrete le script courant
	 */
	public static function redirect($page) {
		header('Location: '.$page);
		exit;
	}

	/**
	 * Verifie si l'utilisateur est connecte,
	 * Sinon, le redirige vers la page d'accueil du site
	 */
	public static function checkIfUserIsConnected() {
		// Demarre la session
		session_start();
		
		if(isset($_SESSION['Licence']) && $_SESSION['Licence']!="")
			return true;

		/* header("Location: index.php?e=a");
		return; */
	}
	
	/**
	 * Deconnecte l'utilisateur et detruit sa session
	 */
	public static function userDisconnection() {
		foreach($_SESSION as $var) {
			unset($var);
		}
		session_destroy();
		header("Location: index.php?event=logout");
	}

	/**
	 * Verifie si l'utilisateur a les droits necessaires pour consulter la page
	 * Sinon, le redirige vers la page d'accueil du site
	 */
	public static function checkIfUserHasRight($rights) {
		if (Utils::doesUserHasRightsOnPage($rights)) {
			return true;
		} else {
			// Sinon, redirige vers la page d'accueil avec une erreur
			header("Location: index.php?e=a");
		}
		return;
	}
	
	// VERIFIER SI L'UTILISATEUR A DES DROITS SUR LA PAGE (PAR EXEMPLE, SANCTION, Modif_Indispos ETC...) MAIS SANS REDIRECTION
	public static function doesUserHasRightsOnPage($rights) {
		// Si c'est une chaine de caractere, convertir en tableau
		if (!is_array($rights))
			$rights = array($rights);
		// Verifier si l'utilisateur a le droit dans le tableau des droits
		foreach ($rights as $idx => $val) {
			if (isset($_SESSION['status']) && $_SESSION['status'] == $val) {
				return true;
			} else if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == $val) {
				return true;
			}
		}
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

	/**
	 * Verifie la validite d'une date
	 */
	public static function isDateFrValidated($date) {
		$regexDateFr = '~^\d{2}/\d{2}/\d{4}$~';
		if( preg_match($regexDateFr, $date) ) {
			return $date;
		} else {
			return false;
		}
	}

	/**
	 * Conversion des dates DD/MM/YY vers 20YY-MM-DD
	 */
	public static function convertDMytoYMD($ddmmyy) {
		return '20'.substr($ddmmyy, 6, 2).'-'.substr($ddmmyy, 3, 2).'-'.substr($ddmmyy, 0, 2);
	}

	/**
	 * Conversion des dates DD/MM/YY vers 20YY-MM-DD
	 */
	public static function formatBirthDateSQL($ddmmyy) {
		return '19'.substr($ddmmyy, 6, 2).'-'.substr($ddmmyy, 3, 2).'-'.substr($ddmmyy, 0, 2);
	}
	
	/**
	 * Conversion des dates DD/MM/YYYY vers YYYY-MM-DD
	 */
	public static function convertDMYtoSQL_YMD($ddmmyyyy) {
		return substr($ddmmyyyy, 6, 4).'-'.substr($ddmmyyyy, 3, 2).'-'.substr($ddmmyyyy, 0, 2);
	}
	
	/**
	 * Conversion des dates DD/MM/YY vers YYYY-MM-DD
	 */
	public static function convertDMY2toSQL_YMD($ddmmyyyy) {
		return '20'.substr($ddmmyyyy, 6, 2).'-'.substr($ddmmyyyy, 3, 2).'-'.substr($ddmmyyyy, 0, 2);
	}

	/**
	 * Conversion des dates SQL YYYY-MM-DD vers DD/MM/YY
	 */
	public static function convertSQL_YMDtoDMy($yyyymmdd) {
		return substr($yyyymmdd, 8, 2).'/'.substr($yyyymmdd, 5, 2).'/'.substr($yyyymmdd, 2, 2);
	}

	/**
	 * Conversion des dates SQL YYYY-MM-DD vers DD/MM/YYYY
	 */
	public static function convertSQL_YMDtoDMYY($yyyymmdd) {
		return substr($yyyymmdd, 8, 2).'/'.substr($yyyymmdd, 5, 2).'/'.substr($yyyymmdd, 0, 4);
	}

	public static function convertSQL_YMDtoMY($yyyymmdd) {
		return substr($yyyymmdd, 5, 2).'/'.substr($yyyymmdd, 0, 4);
	}

	public static function shiftDateSQL_YMD($date, $shiftDays) {
		$newTs = mktime(0, 0, 0, substr($date, 5, 2), substr($date, 8, 2)+$shiftDays, substr($date, 0, 4));
		return date("Y-m-d", $newTs);
	}

	/**
	 * Compare deux dates et retourne la plus recente
	 * Format DD/MM/YY
	 * Valable uniquement pour les dates FR
	 */
	public static function getMaxDate($d1, $d2) {
		$offsetYear = strlen($d1) - 2;
		$d1_eval = (int)substr($d1, $offsetYear, 2).substr($d1, 3, 2).substr($d1, 0, 2);
		$d2_eval = (int)substr($d2, $offsetYear, 2).substr($d2, 3, 2).substr($d2, 0, 2);
		if($d1_eval<$d2_eval)
			return $d2;
		else
			return $d1;
	}

	/**
	 * Compare deux dates et retourne la plus ancienne
	 * Format DD/MM/YY
	 * Valable uniquement pour les dates FR
	 */
	public static function getMinDate($d1, $d2) {
		$offsetYear = strlen($d1) - 2;
		$d1_eval = (int)substr($d1, $offsetYear, 2).substr($d1, 3, 2).substr($d1, 0, 2);
		$d2_eval = (int)substr($d2, $offsetYear, 2).substr($d2, 3, 2).substr($d2, 0, 2);
		if($d1_eval<$d2_eval)
			return $d1;
		else
			return $d2;
	}

	/**
	 * Fonction retournant les mois et annees courantes et suivantes a partir d'une source externe (comme $_REQUEST)
	 * @var $monthYear: mois et annee de la forme MM/YYYY
	 * @return array(): tableau de dates 
	 * 					$curMonth (mois courant), $curYear (annee courante), $followingMonth (mois suivant), $followingYear (annee suivante)
	 */
	public static function getGlobalDatesFromExternalSource($monthYear) {
		// Mois courant
		if(self::isStringValidated($monthYear)) { // Dates correctement definies
			list($curMonth, $curYear) = explode('/', trim(htmlentities($monthYear)));
		}
		// Si mal defini, prendre les dates par defaut
		else {
			list($curMonth, $curYear) = explode('/', date('m/Y'));
		}
		// Mois suivant
		$followingMonth = $curMonth+1;
		if($followingMonth>12) {
			$followingMonth = 1;
			$followingYear 	= $curYear+1;
		} else {
			$followingYear 	= $curYear;
		}
		if((int)$curMonth<10)
			$curMonth		= "0".(int)$curMonth;
		if($followingMonth<10)
			$followingMonth = "0".$followingMonth;
		// -- Var divers
		// Libelle de la date
		$curDateLabel = $curMonth."/".$curYear;
		// Premier jour du mois
		$firstDayOfCurMonth = $curYear."-".$curMonth."-01";
		// Premier jour du mois
		$lastDayOfFollowingMonth = $followingYear."-".$followingMonth."-07";
		return array($curMonth, $curYear, $followingMonth, $followingYear, $curDateLabel, $firstDayOfCurMonth, $lastDayOfFollowingMonth);
	}

	/**
	 * Fonction d'impression des donnees d'un arbitre ou d'un delegue en fonction des donnees d'entree
	 * @var $refereeData : tableau de donnees de l'arbitre (obligatoires : Licence, Nom, Prenom)
	 *		$isEditable : permet l'edition des donnees de l'arbitre
	 *		$infosToHide : tableau des libelles des donnees a masquer a l'utilisateur
	 */
	public static function getDivContentRefereeData($refereeData, $infosToHide) {
		$absolutePath = explode('/', $_SERVER['PHP_SELF']);
		$curPage = $absolutePath[count($absolutePath)-1];
		// Correction des donnees de l'arbitres
		$refereeData['Age'] = (date('Y')-substr($refereeData['Date_Naissance'], 0, 4));
		$refereeData['Date_Naissance'] = self::convertSQL_YMDtoDMYY($refereeData['Date_Naissance']);

		$html = "";
		$refereeData['Prenom'] = ucwords(strtolower($refereeData['Prenom']));
		unset($refereeData["Password"]);
		unset($refereeData["first_pass"]);
		unset($refereeData["Is_Admin"]);
		unset($refereeData['Sexe']);
		if ($curPage != 'fiche_perso.php' && $curPage != 'indispo_excep.php') {
			unset($refereeData['Base']);
		}
		$infosToHide = array ("Adresse", "Tel_Fixe", "Tel_Mobile", "Tel_Bureau", "Mail", "Maillot", "Short", "Chaussettes");
		$html.= "<table id='referee-infos'>";
		foreach($refereeData as $label => $var) {
				$refereeData[$label] = str_replace('é', '&eacute;', $refereeData[$label]);
			if ($_SESSION['Is_Admin'] != 1) {
				if (!in_array($label, $infosToHide)) {
					$right = "class='infosToHide'";
					$right = "style='background-color: lightgrey;'";
				} else {
					$right = '';
				}
			} else {
				$right = '';
			}
			$html.= "<tr>";
				$label = str_replace('_', ' ', $label);
				$html .= "<th>".str_replace('Tel', 'T&eacute;l&eacute;phone', $label)."</th>";
				if ($var == '') {
					$html .= "<td ".$right."><i>non renseign&eacute;</i></td>";
				} else {
					$html .= "<td ".$right.">".$var."</td>";
				}
			$html.="</tr>";
		}
		$html.= "</table>";
		return $html;
	}
	
	public static function UpdateRefereeData($refereeData, $infosToHide, $page) {
		$absolutePath = explode('/', $_SERVER['PHP_SELF']);
		$curPage = $absolutePath[count($absolutePath)-1];
		if ($curPage == "modif_infos_arbitre.php") {
			$target  = "modif_infos_arbitre.php";
			$backUrl = "fiche_perso.php?id=".$refereeData['Licence'];
		} else {
			$target  = "modif_infos.php";
			$backUrl = "mes_infos.php";
		}

		// Lien annuler
		if ($page == 'fiche_perso') {
			$html = "<p><a class='back-link' href='".$backUrl."'>Retour &agrave; la fiche personnelle</a></p>";
		} else {
			$html = "<p><a class='back-link' href='".$backUrl."'>Retour &agrave; ma fiche</a></p>";
		}

		unset($refereeData['Password']);
		unset($refereeData['Is_Admin']);
		unset($refereeData['first_pass']);
		unset($refereeData['Sexe']);
		if ($curPage == 'modif_infos.php') {
			unset($refereeData['Base']);
		}
		$refereeData['Date_Naissance'] = self::convertSQL_YMDtoDMYY($refereeData['Date_Naissance']);

		$html .= "<form name='updateRefereeData' method='POST' action='".$target."'>";
		// Tableau d'infos
		$html .= "<table id='updateRefereeData'>";
		$infosToHide = array ("Adresse", "Tel_Fixe", "Tel_Mobile", "Tel_Bureau", "Mail", "Maillot", "Short", "Chaussettes");
		foreach($refereeData as $label => $var) {
			if ($_SESSION['Is_Admin'] != 1) {
				if (!in_array($label, $infosToHide)) {
					$right = "class='infosToHide' readonly='readonly'";
				} else {
					$right = '';
				}
			} else {
				$right = '';
			}
				$html.= "<tr>";
				$label = str_replace('_', ' ', $label);
				$html .= "<th>".str_replace('Tel', 'T&eacute;l&eacute;phone', $label)."</th>";

				if ($var!="") {
					if ($_SESSION['Is_Admin'] == 1) {
						if ($label == 'Centre') {
							$html.= "<td><select name='".$label."' id='".$label."' ".$right.">";
							$html.= "<option ".($var=='78/92'?"selected='selected'":"")." value='78/92'>78/92</option>";
							$html.= "<option ".($var=='91/94'?"selected='selected'":"")." value='91/94'>91/94</option>";
							$html.= "<option ".($var=='77/51/02/10'?"selected='selected'":"")." value='77/51/02/10'>77/51/02/10</option>";
							$html.= "<option ".($var=='93/95/60'?"selected='selected'":"")." value='93/95/60'>93/95/60</option>";
							$html.= "<option ".($var==''?"selected='selected'":"")." value=''>Aucun</option>";
							$html.= "</select></td>";
						} else if ($label == 'Groupe') {
							$html.= "<td><select name='".$label."' id='".$label."' ".$right.">";
							$html.= "<option ".($var=='Evolution'?"selected='selected'":"")." value='Evolution'>Evolution</option>";
							$html.= "<option ".($var=='Classés'?"selected='selected'":"")." value='Classés'>Class&eacute;s</option>";
							$html.= "<option ".($var=='JEB'?"selected='selected'":"")." value='JEB'>JEB</option>";
							$html.= "<option ".($var=='Arrêt'?"selected='selected'":"")." value='Arrêt'>Arr&ecirc;t</option>";
							$html.= "<option ".($var=='Mutation'?"selected='selected'":"")." value='Mutation'>Mutation</option>";
							$html.= "<option ".($var=='Superviseurs'?"selected='selected'":"")." value='Superviseurs'>Superviseurs</option>";
							$html.= "<option ".($var==''?"selected='selected'":"")." value=''>Aucun</option>";
							$html.= "</select></td>";
						} else {
							$html.= "<td><input type='text' id='".$label."' name='".$label."' ".$right." value='".$var."'></td>";
						}
					} else {
						$html.= "<td><input type='text' id='".$label."' name='".$label."' ".$right." value='".$var."'></td>";
					}
				} else {
					if ($label == 'Centre') {
						$html.= "<td><select name='".$label."' id='".$label."' ".$right.">";
						$html.= "<option ".($var=='78/92'?"selected='selected'":"")." value='78/92'>78/92</option>";
						$html.= "<option ".($var=='91/94'?"selected='selected'":"")." value='91/94'>91/94</option>";
						$html.= "<option ".($var=='77/51/02/10'?"selected='selected'":"")." value='77/51/02/10'>77/51/02/10</option>";
						$html.= "<option ".($var=='93/95/60'?"selected='selected'":"")." value='93/95/60'>93/95/60</option>";
						$html.= "<option ".($var==''?"selected='selected'":"")." value=''>Aucun</option>";
						$html.= "</select></td>";
					} else if ($label == 'Groupe') {
						$html.= "<td><select name='".$label."' id='".$label."' ".$right.">";
						$html.= "<option ".($var=='Evolution'?"selected='selected'":"")." value='Evolution'>Evolution</option>";
						$html.= "<option ".($var=='Classés'?"selected='selected'":"")." value='Classés'>Class&eacute;s</option>";
						$html.= "<option ".($var=='JEB'?"selected='selected'":"")." value='JEB'>JEB</option>";
						$html.= "<option ".($var=='Arrêt'?"selected='selected'":"")." value='Arrêt'>Arr&ecirc;t</option>";
						$html.= "<option ".($var=='Mutation'?"selected='selected'":"")." value='Mutation'>Mutation</option>";
						$html.= "<option ".($var=='Superviseurs'?"selected='selected'":"")." value='Superviseurs'>Superviseurs</option>";
						$html.= "<option ".($var==''?"selected='selected'":"")." value=''>Aucun</option>";
						$html.= "</select></td>";
					} else {
						$html.= "<td><input type='text' id='".$label."' name='".$label."' ".$right." placeholder='non renseign&eacute;'></td>";
					}
				}
				$html .= "</tr>";
			// }
		}
		$html .= "</tr>";
		$html.= "</table>";
		$html .= "<input type='submit' value='Enregistrer vos informations'>";
		$html .= "</form>";
		return $html;
	}

	public static function printHistoryActionInUserFriendlyMode($action) {
		if($action == "DELETED") {
			return "Suppression";
		}
		return "";
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
