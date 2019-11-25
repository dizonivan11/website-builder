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
		$data = db()->select("meta_data", [ "meta_value" ], [ "meta_id" => "current_eid" ]);

		foreach($data as $currentEID) {
			if ($autoincrement) incrementEID();
			return (int)$currentEID["meta_value"];
		}
	}

	function incrementEID() {
		$newEID = (int)getEID(false) + 1;
		db()->update("meta_data", [ "meta_value" => "$newEID" ], [ "meta_id" => "current_eid" ]);
	}

	function createDropZone() {
		echo('<button class="drop-zone" onclick="DropElement(this);">Add Selected Element</button>');
	}
?>