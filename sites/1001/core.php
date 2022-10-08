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
				"TEXT",
				"NOT NULL"
			]
		]);

		// Add meta data "current_eid" with random seed 4700 to 7400
		db()->insert("meta_data",[
			"meta_id" => "current_eid",
			"meta_value" => rand(4700, 7400)
		]);

		// Add default global meta title
		db()->insert("meta_data",[
			"meta_id" => "global_seo_title",
			"meta_value" => ""
		]);

		// Add default global meta description
		db()->insert("meta_data",[
			"meta_id" => "global_seo_description",
			"meta_value" => ""
		]);

		// Add default global meta keywords
		db()->insert("meta_data",[
			"meta_id" => "global_seo_keywords",
			"meta_value" => ""
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
		$current_eid = intval(db()->get("meta_data", "meta_value", [ "meta_id" => "current_eid" ]));
        if ($autoincrement) incrementEID($current_eid + 1);
		return $current_eid;
	}

	function incrementEID($incremented_eid) {
		db()->update("meta_data", [ "meta_value" => "$incremented_eid" ], [ "meta_id" => "current_eid" ]);
	}
?>