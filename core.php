<?php
	// Load Medoo
	require_once('Medoo.php');

	// Using Medoo namespace
	use Medoo\Medoo;

	// Create and connect database object to source
	function db() {
		return new Medoo([
			'database_type' => 'mysql',
			'database_name' => 'website_builder',
			'server' => 'localhost',
			'username' => 'root',
			'password' => '',
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

	function createDropZone() {
		echo('<button class="drop-zone" onclick="DropElement(this);">Add Selected Element</button>');
	}

	function deleteFiles($target) {
		if(is_dir($target)){
			// GLOB_MARK adds a slash to directories returned
			$files = glob($target . '*', GLOB_MARK);
			foreach($files as $file) deleteFiles($file);
			rmdir($target);
		} else if (is_file($target)) unlink($target);
	}
?>