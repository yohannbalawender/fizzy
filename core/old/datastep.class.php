<?php
/**
 * Gestion du "Data Step", insertion / selection de donnees au pas a pas
 *
 * TODO: prevoir un systeme pour charger dans les etapes des fichiers CSS/JS specifiques
 */

class DataStep {
	/**
	 * Structure des Steps
	 * Steps => StepIndex => [Name, Path, Status]
	 */
	public $steps;
	private $currentStep;
	private $controller;

	public function __construct($_steps, $_currentStep, $_controller) {
		if (!is_array($_steps)) {
			throw new Exception("Erreur, les &eacute;tapes n'ont pas pu &ecirc;tre r&eacute;cup&eacute;r&eacute;es.");
		}

		foreach ($_steps as $index => $step) {
			$step['index'] = $index;
			$this->steps[$step['index']] = $step;
		}

		if (!isset($_steps[$_currentStep])) {
			throw new Exception("&Eacute;tape courante non trouv&eacute;e.");
		}

		$this->currentStep =& $this->steps[$_currentStep];

		$this->controller = $_controller;
	}

	public function getAttr($_attr) {
		return isset($this->currentStep->$_attr) ? $this->currentStep->$_attr : '';
	}

	public function getStepIndex($stepName) {
		foreach($this->steps as $idx => $step) {
			if ($step['name'] === $stepName) {
				return $idx;
			}
		}

		return -1;
	}

	public function getContent() {
		$stepPath = $this->currentStep['path'];
		$stepName = $this->currentStep['name'];

		if (!$stepPath || !is_string($stepPath)) {
			throw new Exception("Chemin non accessible pour le DataStep courant.");
		}

		$stepIndex = $this->getStepIndex($stepName);

		require_once('datastep/' . $stepPath . '.php');
	}

	public function getSteps() {
		$content = '';
		switch ($this->currentStep['status']) {
		  case 'last':
			$prevButtonContent = '< Retour';
			$nextButtonContent = 'Terminer >';
			break;
		  case 'first':
			$prevButtonContent = '';
			$nextButtonContent = 'Suivant >';
			break;
		  default:
			$prevButtonContent = '< Retour';
			$nextButtonContent = 'Suivant >';
			break;
		}

		$currentStepIdx = 1;
		foreach ($this->steps as $idx => $step) {
			$isCurrent = $step == $this->currentStep;

			if ($isCurrent) {
				$currentStepIdx = $idx;
			}

			$content.= $this->getSingleStep($step, $idx, $isCurrent);
		}

		$prevButton = $prevButtonContent != '' ? 
					'<button class="btn btn-info datastep-prev" data-source="'. $this->controller .'_'. ($currentStepIdx - 1) .'">'. 
						$prevButtonContent .
					'</button>'
				  : '';

		$nextButton = $nextButtonContent != '' ? 
					'<button class="btn btn-success datastep-submit">'. $nextButtonContent .'</button>'
				  : '';

		return '
			<div id="dataStep">
				<div class="action"> ' .
					$prevButton . 
					$nextButton . 
				'</div>
				<ul class="steps">
					'. $content .'
				</ul>
			</div>';
	}

	public function getSingleStep($step, $idx, $isCurrent) {
		return '<li class="step '. ($isCurrent ? "current" : "") .'">' . $step['name'] . '</li>';
	}

	public static function store($data, $index) {
		if (!isset($_SESSION)) {
			session_start();
		}

		$_SESSION['dataStep'][$index] = $data;
	}

	public static function dig($index) {
		if (!isset($_SESSION) || !isset($_SESSION['dataStep'][$index])) {
			return array();
		}

		return $_SESSION['dataStep'][$index];
	}

	public static function flush() {
		if (!self::check()) {
			return false;
		}

		foreach ($_SESSION['dataStep'] as $step => $stepContent) {
			unset($_SESSION['dataStep'][$step]);
		}
	}

	public static function check() {
		if (!isset($_SESSION)) {
			session_start();
		}

		if (!isset($_SESSION['dataStep'])) {
			return false;
		}

		return true;
	}
}

?>