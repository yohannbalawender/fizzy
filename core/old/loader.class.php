<?php

/* {{{ Abstract */

class Store {
	public $package;
	public $name;
	public $requirements;

	public function __construct($_package, $_name, $_requirements) {
		$this->package = $_package;
		$this->name = $_name;
		$this->requirements = $_requirements;
	}
}

class Loader {
	public $store;
	public $conf;
	/* shared by all instances */
	public static $libs = null;
	private static $path;

	public function __construct($conf) {
		$this->conf = $conf;

		$this->store = array();

		if (is_null(self::$libs)) {
			echo $this->getPath();

			$libsFile = fopen('/git/ontheroadtrip/ext/lionsea/libs.json', 'r');

			self::$libs = json_decode($libsFile);
		}
	}

	public function load($lib) {
		if (!is_string($lib)) {
			throw new Exception("Error while loading library : expect a string for lib argument.");
		}

		list($package, $name) = explode('.', $lib);

		if (!$this->isLoaded($package, $name)) {
		}
	}

	private function isLoaded($package, $name) {

	}

	private function getPath() {
		$script = $_SERVER['SCRIPT_FILENAME'];
		$file = str_replace('\\', '/', __FILE__);

		/*$script = $this->removeLastIndex($script, '/');*/
		$file = $this->removeLastIndex($file, '/');

		/*echo $file;*/

	}

	private function removeLastIndex($str, $delimiter) {
		$arr = explode($delimiter, $str);

		array_pop($arr);

		return implode($delimiter, $arr);
	}

	public function put() {

	}

	public function remove() {

	}

	public function clear() {

	}

	public function getErrors() {

	}
}

/* }}} */

/* {{{ Instances */
	
/*class LibLoader extends Loader {

	public function load($package, name) {
		$start = count($this->loaded);

		if (!is_string($files)) {
			throw new Exception("Error while loading library : array expected.");
		}

		foreach ($files as $file) {
			if ($file === '__ALL_DEFAULT_LIBS__') {
				$this->loadDefaultLibs();
				continue;
			}

			$content = $this->availableLibs[$file];
			
			if (is_array($content)) {
				if (isset($content['require']) && !empty($content['require'])) {
					foreach ($content['require'] as $subFile) {
						if (!in_array($subFile, $this->loaded)) {
							if (in_array($subFile, $this->availableLibs)) {
								throw new Exception($subFile . ' is not available.');
							}

							if (!$this->load(array($subFile => $this->availableLibs[$subFile]))) {
								throw new Exception('Failed to include "' . $subFile . '"');
								return false;
							}
						}
					}
				}

				$fileName = isset($content['builder']) ? $content['builder'] . '.php' : $file . '.class.php';

				if (require_once($content['path'] . $fileName)) {
					$this->loaded[] = $file;
				} else {
					throw new Exception('Failed to include "'. $content["path"] . $file .'"');
					return false;
				}
			}
		}

		return count($this->loaded) - $start;
	}
}*/

/* }}} */

?>