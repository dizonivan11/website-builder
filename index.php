<!DOCTYPE html>
<html>
<head>
	<title>Website Builder</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<style type="text/css">
		* {
			--primary-color: #8dca23;
			--secondary-color: #282828;
			--tertiary-color: #282828e6;
			--fourth-color: #efefefe6;
			--menu-height: 50px;
			--toolbox-width: 100px;
			--toolbox-widgets-width: 200px;
			--widget-properties-width: 250px;
		}
		.f-right {
			float: right;
		}
		.v-full {
			height: 100%;
		}
		.v-center {
			position: relative;
			top: 50%;
			transform: translateY(-50%);
		}
		#menu {
			background-color: var(--secondary-color);
			color: white;
			height: var(--menu-height);
		}
		#toolbox {
			background-color: var(--primary-color);
			float: left;
			width: var(--toolbox-width);
			height: calc(100vh - var(--menu-height));
			padding: 8px;
		}
		.tool {
			font-size: 12px;
			font-weight: bold;
			width: 100%;
			background-color: #efefef;
			border: 2px solid #ccc;
			min-height: 32px;
			margin-bottom: 8px;
		}
		#toolbox-widgets {
			background-color: var(--tertiary-color);
			float: left;
			width: var(--toolbox-widgets-width);
			height: calc(100vh - var(--menu-height));
			margin-left: var(--toolbox-width);
			padding: 15px;
			position: absolute;
			box-shadow: 4px 0px 8px var(--secondary-color);
		}
		#widget-properties {
			background-color: var(--fourth-color);
			float: right;
			width: var(--widget-properties-width);
			height: calc(100vh - var(--menu-height));
			padding: 15px 0px 15px 0px;
			position: absolute;
			right: 0;
			box-shadow: -4px 0px 8px var(--secondary-color);
		}
		#workspace-container {
			margin-left: var(--toolbox-width);
			width: calc(100vw - var(--toolbox-width));
			height: calc(100vh - var(--menu-height));
		}
		#workspace {
			width: 100%;
			height: 100%;
			border: none;
		}
		#message-box {
			padding: 4px;
			border: 1px solid #ccc;
			width: 100%;
			text-align: center;
			background-color: #efefef;
			color: black;
			box-shadow: 0px 0px 8px #aaa inset;
		}
		.widget-properties-title {
			font-size: 18px;
			font-weight: bold;
		}
		.widget-properties-subtitle {
			font-size: 16px;
			font-weight: bold;
		}
		.widget-properties-label {
			font-size: 12px;
			font-weight: bold;
		}
		#spacing-border {
			width: 100%;
			text-align: center;
			border: 1px solid #ccc;
		}
		#spacing-border tr td {
			border: none !important;
			padding: 4px;
		}
		#spacing-border tr td input {
			width: 100%;
			border: 1px solid #ccc;
		}
		#spacing-border tr td.margin {
			background-color: var(--primary-color);
		}
		#spacing-border tr td.border {
			background-color: var(--secondary-color);
		}
		#spacing-border tr td.padding {
			background-color: var(--tertiary-color);
		}
		#spacing-border tr td.inner {
			background-color: var(--tertiary-color);
		}
	</style>
</head>
<body>
	<div id="menu" class="container-fluid">
		<div class="row v-full">
			<div class="col-1">
				<h3 class="v-center">WB</h3>
			</div>
			<div class="col-6">
				<div id="message-box" class="v-center">Feedbacks here....</div>
			</div>
			<div class="col-5">
				<button class="f-right v-center">Publish</button>
				<button class="f-right v-center">Preview</button>
			</div>
		</div>
	</div>
	<div id="toolbox">
		<button class="tool" onclick="DisplayMessage('Under construction');">Global Settings</button>
		<button class="tool" onclick="DisplayMessage('Under construction');">Site Map</button>
		<button class="tool" onclick="ToggleWidgetsMenu();">Widgets</button>
	</div>

	<!-- Floating Windows -->
	<!-- 'display: none;' style applied inline to fix first event not firing -->
	<div id="toolbox-widgets" style="display: none;"></div>
	<div id="widget-properties" style="display: none;"></div>

	<div id="workspace-container">
		<iframe id="workspace" src="templates/blank"></iframe>
	</div>
	<script type="text/javascript">
		var toolboxWidgets = document.getElementById('toolbox-widgets');
		var widgetProperties = document.getElementById('widget-properties');
		var messageBox = document.getElementById('message-box');
		var workspace = document.getElementById('workspace');

		window.onload = function() {
<?php
			// Load all widgets
			$dir = "widgets/";
			$files = scandir($dir);

			// Select all widget filepaths
			// Offsets to two (2)
			// First element refers to the directory itself (./)
			// Second element refers to the parent directory (../)
			echo("var widgetFiles = [");
			for ($i = 2; $i < count($files); $i++) {
				if ($i > 2) echo ", ";
				echo('"' . $files[$i] . '"');
			}
			echo("];\n");
?>
			// Create widget deselector first
			var widgetTool = document.createElement('button');
			widgetTool.className = "tool";
			widgetTool.innerHTML = "None";
			widgetTool.onclick = function() {
				// Inform workspace to clear selected-element's innerHTML
				workspace.contentWindow.postMessage({ header: "selectWidget", message: "" });
				ToggleWidgetsMenu();
				DisplayMessage("Widget deselected");
			};
			toolboxWidgets.appendChild(widgetTool);

			for (var i = 0; i < widgetFiles.length; i++) {
				// Create widget tool with filepath value
				var widgetTool = document.createElement('button');
				widgetTool.className = "tool";
				widgetTool.innerHTML = widgetFiles[i].split('.')[0];
				widgetTool.value = "widgets/" + widgetFiles[i];
				widgetTool.onclick = function() {
					// Send the widget content to workspace's selected-element innerHTML
					// Using the tool's filepath value
					var filepath = this.value;
					var widgetRequester = new XMLHttpRequest();
					widgetRequester.open("POST", "widget-loader.php", true);
					widgetRequester.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					widgetRequester.onreadystatechange = function() {
            			if (this.readyState == 4 && this.status == 200) {
							workspace.contentWindow.postMessage({
								header: "selectWidget", message: this.responseText
							});
            			}
        			};
					widgetRequester.send("fp=" + filepath);
					ToggleWidgetsMenu();
					DisplayMessage(this.value.split('.')[0] + " selected");
				};
				toolboxWidgets.appendChild(widgetTool);
			}
		}

		function DisplayMessage(message) { messageBox.innerHTML = message; }

		// Process messages coming from workspace
		window.onmessage = function (e) {
			var header = e.data.header;
			
			switch (header) {
				case "feedback":
					DisplayMessage(e.data.message);
					break;
				case "open-widget-properties":
					var wid = e.data.widgetID;
					var wpp = e.data.widgetPropertiesPath + ".php";

					// Clear window first to populate new widget property fields
					widgetProperties.innerHTML = "";
					var widgetRequester = new XMLHttpRequest();
					widgetRequester.open("POST", "widget-properties/default-menu.php", true);
					widgetRequester.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					widgetRequester.onreadystatechange = function() {
            			if (this.readyState == 4 && this.status == 200) {
							widgetProperties.innerHTML = this.responseText;
							widgetProperties.style.display = "block";
            			}
        			};
					widgetRequester.send("wid=" + wid + "&wpp=" + wpp);
					break;
			}
		}

		function ToggleWidgetsMenu() {
			if (toolboxWidgets.style.display == "none")
				toolboxWidgets.style.display = "block";
			else toolboxWidgets.style.display = "none";
		}
	</script>
</body>
</html>