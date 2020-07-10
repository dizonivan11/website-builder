<?php
	// Load Medoo
	require_once('Medoo.php');

	// Using Medoo namespace
	use Medoo\Medoo;

	// Check if db does not exists, then create new one with no content yet
	if (!file_exists("core.db")) {
		file_put_contents("core.db", "");

		// Create meta_data table
		db()->create("meta_data", [
			"meta_id" => [
				"VARCHAR(32)",
				"NOT NULL",
				"PRIMARY KEY"
			],
			"meta_value" => [
				"INT",
				"NOT NULL"
			]
		]);

		// Add meta data "current_eid" with seed 4700
		db()->insert("meta_data",[
			"meta_id" => "current_eid",
			"meta_value" => 4700
		]);
	}

	// Create and connect database object to source
	function db() {
		return new Medoo([
			'database_type' => 'sqlite',
			'database_file' => 'core.db'
		]);
	}

	function getEID($autoincrement = true) {
		$current_eid = db()->get("meta_data", "meta_value", [ "meta_id" => "current_eid" ]);
        if ($autoincrement) incrementEID($current_eid + 1);
		return $current_eid;
	}

	function incrementEID($incremented_eid) {
		db()->update("meta_data", [ "meta_value" => "$incremented_eid" ], [ "meta_id" => "current_eid" ]);
	}

	function copyFiles($src, $dst) {
		$dir = opendir($src);
		mkdir($dst);
		while (false !== ($file = readdir($dir))) {
			if (($file != '.' ) && ( $file != '..')) {
				if (is_dir($src . '/' . $file)) copyFiles($src . '/' . $file, $dst . '/' . $file);
				else copy($src . '/' . $file, $dst . '/' . $file);
			}
		}
		closedir($dir);
	}

	function RemoveBuilderOnlyElements($dir) {
		$files = glob("$dir*", GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				RemoveBuilderOnlyElements($file);
			} else if (is_file($file)) {
				if (pathinfo($file, PATHINFO_EXTENSION) == "php") {
					$doc = new DomDocument;
					$doc->loadHTMLFile($file, LIBXML_NOERROR);
					$xpath = new DOMXpath($doc);
					$elements = $xpath->query("//*[contains(@data-flag, 'builder-element')]");
					if (!is_null($elements)) {
						foreach ($elements as $element) {
							$element->parentNode->removeChild($element);
						}
					}
					$doc->saveHTMLFile($file);
				}
			}
		}
	}
	
	function deleteFiles($target) {
		if (is_dir($target)){
			// GLOB_MARK adds a slash to directories returned
			$files = glob("$target*", GLOB_MARK);
			foreach ($files as $file) deleteFiles($file);
			rmdir($target);
		} else if (is_file($target)) unlink($target);
	}
?>