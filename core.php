<?php
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