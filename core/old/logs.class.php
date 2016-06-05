<?php
/**
 * Classe de gestion et de publication des logs internes
 */
class IALogs {
	
	// Lib d'erreurs
	private static $levels = array('error', 'warning', 'info', 'debug', 'unknown');
	private static $contents = array();
	private static $logsRepo;
	private static $fileLog;
	private static $errors;

	function IALogs() {
	}

	private static function updateConfs() {
		self::$logsRepo = Conf::$logsDir . '/logs-' . date('Y-m');
		self::$fileLog = self::$logsRepo . '/iarbitres-log-' . date('Y-m-d') . '.txt';
	}

	private static function getLogProperties() {
		$ip = "[".$_SERVER['REMOTE_ADDR']."]";
		$date = date("d/m/y à H:i:s");
		$session = (isset($_SESSION['Licence'])? $_SESSION['Licence'] : 'undefined');

		return array('ip' => $ip,
					 'date' => $date,
					 'session' => $session);
	}

	private static function formatLog($level, $params, $message) {
		if (!preg_grep("/".$level."/i", self::$levels))
			$level = 'unknown';

		return strtoupper($level) . " :: " . 
			   $params['ip'] . " - - " . 
			   $params['date'] . 
			   " Session:{" . $params['session'] . "} - - " .
			   $message .
			   "\n";
	}

	private static function checkIndexValidatedNumeric($index) {
		if (!is_numeric($index) || $index < 0) {
			return false;
		} else if (isset(self::$contents[$index])) {
			return true;
		}
	}

	public static function add($level, $message) {
		$params = self::getLogProperties();

		array_push(self::$contents, self::formatLog($level, $params, $message));
	}

	public static function remove($index) {
		if (self::checkIndexValidatedNumeric($index)) {
			unset(self::$contents[$index]);
		} else {
			return false;
		}
	}

	public static function update($level, $message, $index, $isRelative = false) {
		$indexToCheck = ($isRelative? count(self::$contents) - 1 - $index : $index);

		if (self::checkIndexValidatedNumeric($index)) {
			$params = self::getLogProperties();

			self::$content[$index] = self::formatLog($level, $params, $message);
		} else {
			return false;
		}
	}

	public static function reset() {
		self::$contents = array();
	}

	public static function save() {
		self::updateConfs();

		if (!file_exists(self::$logsRepo)) {
			mkdir(self::$logsRepo, 0777);
		}

		if ($f = fopen(self::$fileLog, "a+")) {
			foreach (self::$contents as $index => $log) {
				fwrite($f, $log);
			}
			fclose($f);
		}
	}
}
?>