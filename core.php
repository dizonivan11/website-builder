<?php
	// initialize element id with random seed number
	$eid = srand();

	function createDropZone() {
		echo '<button class="drop-zone" onclick="DropElement(this);">Add Selected Element</button>';
	}
?>