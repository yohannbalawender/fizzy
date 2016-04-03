<?php
/**
 * Classe abstraite de lecture de fichier et d'enregistrement dans la base
 */

abstract class CsvReader {
	public $fileDir = 'uploads/'; 							  // Repertoire d'upload
	private $separatedChar = ""; 							  // Caractere de separation
	// Tableau de caracteres de separation
	// La virgule n'est pas pris en compte car elle peut faire echouer l'import
	protected $possibleSeparatedChar = array("	", ";");
	// Tableau representant les champs de la table
	protected $tableMap = array();
	// Tableau representant les colonnes du fichier
	protected $fileMap = array('');
	// Donnees du fichier
	protected $fileInfo = array('');

	public function __construct() {

	}

	public function setTableMap($_tableMap) {
		$this->tableMap = $_tableMap;
	}

	public function setFileMap($_fileMap) {
		$this->fileMap = $_fileMap;
	}

	/**
	 * @var $_file : tableau des vars globale du fichier
	 * @return $fullPath : retourne le chemin absolu du fichier
	 */
	public function checkUploadedFile($_file) {
		// return $_file['tmp_name'];
		// Nom et emplacement du fichier
		$fileName = basename($_file['name']);
		$fullPath = $this->fileDir . $fileName;
		// Suppression de l'ancien fichier, s'il existe
		if(file_exists($fullPath)) {
			unlink($fullPath);
		}
		// Changement des droits du fichier pour autoriser plus tard sa suppression
		chmod($_file['tmp_name'], 0775);
		if(move_uploaded_file($_file['tmp_name'], $fullPath)) {
			// Date de modif du fichier
			$fileModificationTime = filemtime($fullPath);
			// Infos du fichier
			$this->fileInfo['name'] = $fileName;
			$this->fileInfo['modificationTime'] = $fileModificationTime;
			$this->fileInfo['fullPath'] = $fullPath;

			return $fullPath;
		} else {
			ContextMessage::putExtraErrorMessage("Erreur, &eacute;chec du chargement du fichier &laquo; ".$fileName." &raquo; sur le serveur.
				Veuillez r&eacute;essayer ou contactez directement l'administrateur.");
		}
		return false;
	}

	/**
	 * Helper pour creer des arguments pour les requetes prepares
	 * @var {Integer} $count: nombre d'arguments a ajouter
	 */
	public function createPreparedQuery($count) {
		$ret = "(";
		for($i=0; $i<$count; $i++)
			$ret.= "?,";
		// Supprimer la derniere virgule
		$ret = substr($ret, 0, -1);
		// Fermer la requete
		$ret.= "),";
		return $ret;
	}

	/* {{{  Methodes abstraites, doivent etre overridees par les classes filles */

	/**
	 * Lecture du fichier Csv et recuperation des donnees
	 * @var {Resource} $inputFile: Ressource du fichier a traiter
	 */
	abstract protected function readFile($inputFile) {
	}

	/**
	 * Sauvegarde les donnees dans la base
	 * @var {Mixed} $data: Donnees a inserer dans la base
	 */
	abstract protected function saveInDb($data); {
	}

	/**
	 * Actions si la lecture et la sauvegarde a reussi
	 */
	abstract protected function onSuccess() {
	}

	/**
	 * Sinon, actions si ca a echoue
	 */
	abstract protected function onError() {
	}

	/* }}} */
}
?>
