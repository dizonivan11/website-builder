<!DOCTYPE html>
<html>
<head>
	<title>Website Builder</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="html5kellycolorpicker.min.js"></script>
	<link rel="stylesheet" href="index.css">
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
		var widgetPrimaryProperties; // Load only after initializing default properties in widget properties window
		var widgetPropertiesSelectedId = "-1";
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
			
			// Load Default Properties Layout in Widget Properties Window
			var widgetRequester = new XMLHttpRequest();
			widgetRequester.open("POST", "widget-properties/default-menu.php", true);
			widgetRequester.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			widgetRequester.onreadystatechange = function() {
            	if (this.readyState == 4 && this.status == 200) {
					widgetProperties.innerHTML = this.responseText;
					$.getScript("widget-properties/default-menu.js");

					// Finally manipulate elements of Default Properties Layout after asynchronously loading it
					widgetPrimaryProperties = document.getElementById('wpw-primary-property');
            	}
        	};
			widgetRequester.send();
		}
		
		String.prototype.format = function() {
			a = this;
			for (k in arguments) {
				a = a.replace("{" + k + "}", arguments[k])
			}
			return a;
		}
		function DisplayMessage(message) { messageBox.innerHTML = message; }
		function AddSelectorsTo(parameters, selectors) {
			for (var i = 0; i < parameters.length; i++) {
				var parameter = parameters[i];
				var selector = parameter.selectorFormat.format(widgetPropertiesSelectedId);
				if (parameter.mode === "css" && !selectors.includes(selector)) selectors.push(selector);
			}
		}
		function BindProperties(parameters) {
			for (var i = 0; i < parameters.length; i++) {
				switch(parameters[i].mode) {
					case "css":
						// TODO: Binding CSS

						break;
					case "html":
						// Request to bind innerHTML of widget inside workspace to the input
						workspace.contentWindow.postMessage({
						    header: "getHTML",
						    selector: parameters[i].selectorFormat.format(widgetPropertiesSelectedId),
						    input: "#" + parameters[i].input
						});
						break;
				}
			}
		}
		function SendApplyCommandsToWorkspace(parameters) {
			for (var i = 0; i < parameters.length; i++) {
				var parameter = parameters[i];
				switch(parameter.mode) {
					case "css":
						if (parameter.toggle != undefined && !$("#" + parameter.toggle).is(":checked")) {
							// Property has toggle and its unchecked, fully disregard this property
							break;
						}
						workspace.contentWindow.postMessage({
							header: "applyCSS",
		    			    selector: parameter.selectorFormat.format(widgetPropertiesSelectedId),
		    			    propertyName: parameter.propertyName,
		    			    propertyValue: parameter.valueFormat.format(document.getElementById(parameter.input).value)
						});
						break;
					case "html":
						workspace.contentWindow.postMessage({
							header: "applyHTML",
		    			    selector: parameter.selectorFormat.format(widgetPropertiesSelectedId),
		    			    propertyValue: document.getElementById(parameter.input).value
						});
						break;
				}
			}
		}

		// Process messages coming from workspace
		window.onmessage = function (e) {
			var header = e.data.header;
			
			switch (header) {
				case "feedback":
					DisplayMessage(e.data.message);
					break;
				case "open-widget-properties":
					// Reset Primary Properties Paramaters
					primaryApplyParameters = [];
					widgetPropertiesSelectedId = e.data.widgetID;
					var wpp = e.data.widgetPropertiesPath; // without extension (for loading both layout and script)

					// Clear primary properties section first to populate new widget property fields
					// Server will populate values in the primary properties section using the POST data
					widgetPrimaryProperties.innerHTML = "";
					var widgetRequester = new XMLHttpRequest();
					widgetRequester.open("POST", "widget-properties/primary-properties-loader.php", true);
					widgetRequester.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
					widgetRequester.onreadystatechange = function() {
            			if (this.readyState == 4 && this.status == 200) {
							// File found, load primary property values then open widget properties window
							widgetPrimaryProperties.innerHTML = this.responseText;
							// Load its script (if it exists)
							$.getScript("widget-properties/" + wpp + ".js", function(script, textStatus) {
								// Binds all property inputs currently in primaryApplyParameters after loading its script
								BindProperties(primaryApplyParameters);
							});
							// Binds all property inputs currently in applyParameters
							BindProperties(applyParameters);
							widgetProperties.style.display = "block";
            			}
        			};
					widgetRequester.send("wpp=" + wpp);
					break;
				case "clearCSS":
					// Continue applying properties after clearing any inline css inside the widget
					SendApplyCommandsToWorkspace(applyParameters);
					SendApplyCommandsToWorkspace(primaryApplyParameters);
					widgetProperties.style.display = "none";
					DisplayMessage("Changes were applied to widget #" + widgetPropertiesSelectedId);
					break;
				case "bindHTML":
					// Get the Inner HTML result of selected widget then apply to target input
					$(e.data.input).val(e.data.innerHtml);
					break;
			}
		}

		function ToggleWidgetsMenu() {
			if (toolboxWidgets.style.display == "none")
				toolboxWidgets.style.display = "block";
			else toolboxWidgets.style.display = "none";
		}

		// Stores parameters to be process after clicking Apply Changes button
		var applyParameters = [
		    // Load functions for default properties
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-margin-top", propertyName: "margin-top", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-margin-right", propertyName: "margin-right", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-margin-bottom", propertyName: "margin-bottom", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-margin-left", propertyName: "margin-left", valueFormat: "{0}px" },
			
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-border-top-width", propertyName: "border-top-width", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-border-right-width", propertyName: "border-right-width", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-border-bottom-width", propertyName: "border-bottom-width", valueFormat: "{0}px" },
			{ mode: "css", selectorFormat: "#{0}", input: "wpw-default-border-left-width", propertyName: "border-left-width", valueFormat: "{0}px" },
			
			{ mode: "css", selectorFormat: "#{0}", input: "wpw-default-border-color", propertyName: "border-color", valueFormat: "{0}", toggle: "wpw-toggle-default-border" },
			{ mode: "css", selectorFormat: "#{0}", input: "wpw-default-border-style", propertyName: "border-style", valueFormat: "{0}", toggle: "wpw-toggle-default-border" },
			
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-padding-top", propertyName: "padding-top", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-padding-right", propertyName: "padding-right", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-padding-bottom", propertyName: "padding-bottom", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-padding-left", propertyName: "padding-left", valueFormat: "{0}px" },
			
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-top-left-border-radius", propertyName: "border-top-left-radius", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-top-right-border-radius", propertyName: "border-top-right-radius", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-bottom-right-border-radius", propertyName: "border-bottom-right-radius", valueFormat: "{0}px" },
			{ mode: "css", selectorFormat: "#{0}", input: "wpw-default-bottom-left-border-radius", propertyName: "border-bottom-left-radius", valueFormat: "{0}px" },

			{ mode: "css", selectorFormat: "#{0}", input: "wpw-default-font-color", propertyName: "color", valueFormat: "{0}", toggle: "wpw-toggle-default-font-color" }
		];
		// Primary Properties can add its parameters here
		var primaryApplyParameters = [];
		
		function ApplyChanges() {
			// These changes needs to be imformed inside workspace via postMessage
			// Remove any inline style previously applied inside the widget first before applying css for cleaner result
			var selectors = [];
			AddSelectorsTo(applyParameters, selectors);
			AddSelectorsTo(primaryApplyParameters, selectors);
			workspace.contentWindow.postMessage({ header: "clearCSS", elementSelectors: selectors });
			console.log("Apply Changes Selectors: ");
			console.log(selectors);
		}
	</script>
</body>
</html>