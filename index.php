<?php
	if (isset($_GET["sid"])) {
		$siteID = $_GET["sid"];
		// if (substr($siteID, strlen($siteID) - 1, 1) != '/') $siteID .= '/';
	} else {
		$siteID = "empty.php";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Website Builder</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	
	<!-- Default Builder Font and Icons -->
	<link href="https://fonts.googleapis.com/css?family=Changa&display=swap" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

	<!-- HTML5Kelly Color Picker -->
	<script src="html5kellycolorpicker.min.js"></script>
	
	<!-- Main Builder Stylesheet -->
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
				<button class="f-right v-center menu-button" onclick="SaveWebpage('publish');">Publish</button>
				<button class="f-right v-center menu-button" onclick="SaveWebpage('preview');">Preview</button>
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
	<div id="dialog-canceller" style="display: none;" onclick="CloseDialog()"></div>
	<div id="builder-dialog" style="display: none;">
		<div class="dialog-top">
			<div class="dialog-title">Dialog Title</div>
			<div class="f-right"><span class="fa fa-close icon-button" onclick="CloseDialog()"></span></div>
		</div>
		<div class="dialog-content"></div>
	</div>

	<div id="workspace-container">
	<?= "<iframe id='workspace' src='sites/$siteID/home/index.php'></iframe>" ?>
	</div>
	<script type="text/javascript">
		var toolboxWidgets = document.getElementById('toolbox-widgets');
		var widgetProperties = document.getElementById('widget-properties');
		var savedSelectionRange;
		var widgetPrimaryProperties; // Load only after initializing default properties in widget properties window
		var widgetPropertiesSelectedId = "-1";
		var messageBox = document.getElementById('message-box');
		var workspace = document.getElementById('workspace');

		window.onload = function() {
<?php
			// Load all widgets
			$dir = "widgets/";
			$files = glob($dir . "*");

			// Selects all widget filepaths
			echo("var widgetDir = '$dir';\n");
			echo("var widgetFiles = [");
			for ($i = 0; $i < count($files); $i++) {
				if ($i > 0) echo ", ";
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
				widgetTool.innerHTML = widgetFiles[i].substr(widgetFiles[i].indexOf(widgetDir) + widgetDir.length).split('.')[0];
				widgetTool.value = widgetFiles[i];
				widgetTool.onclick = function() {
					// Send the widget content to workspace's selected-element innerHTML
					// Using the tool's filepath value
					var filepath = this.value;
					var widgetRequester = new XMLHttpRequest();
					<?= "widgetRequester.open('POST', 'sites/$siteID/widget-loader.php', true);" ?>
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
				var parameter = parameters[i];
				switch(parameter.mode) {
					case "css":
						// Request to bind inline CSS of widget inside workspace to the input
						// CSS escape needed for function [querySelector]
						workspace.contentWindow.postMessage({
						    header: "getCSS",
							selector: parameter.selectorFormat.format(CSS.escape(widgetPropertiesSelectedId)),
							propertyName: parameter.propertyName,
						    input: "#" + parameter.input
						});
						break;
					case "attr":
						// Request to bind attribute of widget inside workspace to the input
						workspace.contentWindow.postMessage({
						    header: "getATTR",
							selector: parameter.selectorFormat.format(widgetPropertiesSelectedId),
							attributeName: parameter.attributeName,
						    input: "#" + parameter.input
						});
						break;
					case "html":
						// Request to bind innerHTML of widget inside workspace to the input
						workspace.contentWindow.postMessage({
						    header: "getHTML",
						    selector: parameter.selectorFormat.format(widgetPropertiesSelectedId),
						    input: "#" + parameter.input
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
					case "attr":
						workspace.contentWindow.postMessage({
							header: "applyATTR",
		    			    selector: parameter.selectorFormat.format(widgetPropertiesSelectedId),
		    			    attributeName: parameter.attributeName,
		    			    attributeValue: parameter.valueFormat.format(document.getElementById(parameter.input).value)
						});
						break;
					case "html":
						workspace.contentWindow.postMessage({
							header: "applyHTML",
		    			    selector: parameter.selectorFormat.format(widgetPropertiesSelectedId),
		    			    propertyValue: document.getElementById(parameter.input).innerHTML
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
				case "open-row-properties":
					// TODO: Open Row Properties Window
					var rid = e.data.rid;
					console.log(rid);
					break;
				case "open-col-properties":
					// TODO: Open Column Properties Window
					var cid = e.data.cid;
					console.log(cid);
					break;
				case "deleteWidget":
					DisplayMessage("Widget " + e.data.selector + " removed");
					CloseWidgetPropertiesWindow();
					break;
				case "clearCSS":
					// Continue applying properties after clearing any inline css inside the widget
					SendApplyCommandsToWorkspace(applyParameters);
					SendApplyCommandsToWorkspace(primaryApplyParameters);
					widgetProperties.style.display = "none";
					DisplayMessage("Changes were applied to widget #" + widgetPropertiesSelectedId);
					break;
				case "bindCSS":
					// Get the inline CSS result of selected widget then apply to target input
					var inlineValue = e.data.inlineValue;
					var defaultValue = e.data.defaultValue;
					switch ($(e.data.input).prop("tagName")) {
						case "SELECT":
							$(e.data.input).val(e.data.inlineValue);
							$(e.data.input).attr("placeholder", e.data.defaultValue);
							break;
						case "INPUT":
							// Avoid replacing value of checkbox
							if ($(e.data.input).attr("type") == "checkbox") {
								// Make value reflects checkbox
								if (defaultValue == inlineValue) $(e.data.input).attr("checked", "checked");
							} else if ($(e.data.input).attr("type") == "number") {
								var numberRegex = /-?(\d+|\d+\.\d+|\.\d+)([eE][-+]?\d+)?/g;
								$(e.data.input).val(e.data.inlineValue.match(numberRegex));
								$(e.data.input).attr("placeholder", e.data.defaultValue.match(numberRegex));
							} else {
								$(e.data.input).val(e.data.inlineValue);
								$(e.data.input).attr("placeholder", e.data.defaultValue);
							}
							break;
					}
					break;
				case "bindHTML":
					// Get the Inner HTML result of selected widget then apply to target input
					$(e.data.input).html(e.data.innerHtml);
					break;
				case "bindATTR":
					// Get the attribute of selected widget then apply to target input
					$(e.data.input).val(e.data.attributeValue);
					break;
				case "pageSaved":
					DisplayMessage("Webpage saved");
					switch (e.data.callback) {
						case "preview":
							PreviewWebsite();
							break;
						case "publish":
							// TODO: publishing site here
							break;
					}
					// console.log(e.data.debug);
					break;
			}
		}

		function ToggleWidgetsMenu() {
			if (toolboxWidgets.style.display == "none")
				toolboxWidgets.style.display = "block";
			else toolboxWidgets.style.display = "none";
		}

		// Prevent pasting selected html and get only its plain text representation to the editor
		function PreventHTMLPaste(eid) {
			$(eid).on("paste", function(e) {
		    	// cancel paste
		    	e.preventDefault();
		    	// get text representation of clipboard
		    	var text = (e.originalEvent || e).clipboardData.getData('text/plain');
		    	// insert text manually
		    	document.execCommand("inserttext", false, text);
			});
		}

		// Stores parameters to be process after clicking Apply Changes button
		// Simply add the same input again to override something
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
			
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-padding-top", propertyName: "padding-top", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-padding-right", propertyName: "padding-right", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-padding-bottom", propertyName: "padding-bottom", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-padding-left", propertyName: "padding-left", valueFormat: "{0}px" },
			
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-top-left-border-radius", propertyName: "border-top-left-radius", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-top-right-border-radius", propertyName: "border-top-right-radius", valueFormat: "{0}px" },
		    { mode: "css", selectorFormat: "#{0}", input: "wpw-default-bottom-right-border-radius", propertyName: "border-bottom-right-radius", valueFormat: "{0}px" },
			{ mode: "css", selectorFormat: "#{0}", input: "wpw-default-bottom-left-border-radius", propertyName: "border-bottom-left-radius", valueFormat: "{0}px" },

			{ mode: "css", selectorFormat: "#{0}", input: "wpw-default-border-color", propertyName: "border-color", valueFormat: "{0}" },
			{ mode: "css", selectorFormat: "#{0}", input: "wpw-default-border-style", propertyName: "border-style", valueFormat: "{0}" },
			{ mode: "css", selectorFormat: "#{0}", input: "wpw-default-background-color", propertyName: "background-color", valueFormat: "{0}" },
			{ mode: "css", selectorFormat: "#{0}", input: "wpw-default-foreground-color", propertyName: "color", valueFormat: "{0}" }
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
			// console.log("Apply Changes Selectors: ");
			// console.log(selectors);
		}

		function CloseWidgetPropertiesWindow() {
			widgetPropertiesSelectedId = "-1";
			widgetProperties.style.display = "none";
		}

		function DeleteSelectedWidget() {
			workspace.contentWindow.postMessage({ header: "deleteWidget", selector: "#" + widgetPropertiesSelectedId });
		}

		// Open dialog on mouse position and check if this dialog overflows the screen and adjust accordingly
		// This dialog can perform small task that requires input, a message, a confirmation, etc.
		function OpenDialog(e, title, html) {
			var element = $(e);
			var elementX = element.offset().left - $(window).scrollLeft();
			var elementY = element.offset().top - $(window).scrollTop();
			var diagY = elementY + element.height();
			$("#dialog-canceller").css("display", "block");
			$("#builder-dialog").children(".dialog-top").children(".dialog-title").html(title);
			$("#builder-dialog").children(".dialog-content").html(html);
			var diagWidth = $("#builder-dialog").width();
			var diagHeight = $("#builder-dialog").height();
			var overflowX = elementX + diagWidth - $(window).width();
			var overflowY = diagY + diagHeight - $(window).height();
			if (overflowX < 0) overflowX = 0;
			if (overflowY < 0) overflowY = 0;
			$("#builder-dialog").css("left", elementX - overflowX + "px");
			$("#builder-dialog").css("top", diagY - overflowY + "px");
			$("#builder-dialog").css("display", "block");
		}

		function CloseDialog() {
			$("#dialog-canceller").css("display", "none");
			$("#builder-dialog").children(".dialog-top").children(".dialog-title").html("");
			$("#builder-dialog").children(".dialog-content").html("");
			$("#builder-dialog").css("display", "none");

			// All saved selection range
			RestoreSelection();
		}

		function SaveSelection() {
		    if (window.getSelection().type == "Range") {
		        var sel = window.getSelection();
		        if (sel.getRangeAt && sel.rangeCount) {
		            return sel.getRangeAt(0);
		        }
		    } else if (document.selection && document.selection.createRange) {
		        return document.selection.createRange();
		    }
		    return null;
		}

		function RestoreSelection() {
		    if (savedSelectionRange) {
		        if (window.getSelection) {
		            var sel = window.getSelection();
		            sel.removeAllRanges();
		            sel.addRange(savedSelectionRange);
		        } else if (document.selection && savedSelectionRange.select) {
		            savedSelectionRange.select();
		        }
			}
			savedSelectionRange = null;
		}

		// Dialog Inputs
		function ShowAddLinkDialog(e) {
			var element = $(e);
			savedSelectionRange = SaveSelection();
			var parent = savedSelectionRange.startContainer.parentNode;
			// Confirm if the selection is valid by comparing the selection range's rich text editor's id to data-parent of button
			while (parent.id != element.data("parent")) {
				if (parent == null) {
					// If by chance the parent is not found and make its way up to the root's parent (which is nothing)
					// Dont show the add link dialog at all
					savedSelectionRange = null;
					return;
				}
				parent = parent.parentNode;
			}
			$.ajax({
				url: "dialogs/addLink.php",
				success: function(result) {
					if (savedSelectionRange != null) {
						OpenDialog(e, "Add Link", result);
					} else {
						DisplayMessage("Cannot add link, select text first");
					}
				}
			});
		}

		function ApplyLinkToSelection() {
			var url = $("#di-anchor-link").val();
			$("#di-anchor-link").val("");
			if (url == "") {
				document.execCommand("unlink", false, false);
				CloseDialog();
				return;
			}
			RestoreSelection();
			if ($("#di-anchor-new-tab").is(":checked")) {
				var linkText = window.getSelection();
				document.execCommand("inserthtml", false, "<a href='" + url + "' target='_blank'>" + linkText + "</a>");
			} else {
				document.execCommand("inserthtml", false, "<a href='" + url + "'>" + linkText + "</a>");
			}
			CloseDialog();
		}

		function SaveWebpage(callback) {
			workspace.contentWindow.postMessage({
				header: "savePage",
				webPagePath: workspace.getAttribute("src"),
				successCallback: callback
			});
		}

		function PreviewWebsite() {
			var previewRequester = new XMLHttpRequest();
			previewRequester.open("POST", "preview-loader.php", true);
			previewRequester.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			previewRequester.onreadystatechange = function() {
            	if (this.readyState == 4 && this.status == 200) {
					// Open preview link when generating preview completed
					// Preview Link: this.responseText
					window.open(this.responseText + "home/", '_blank');
            	}
        	};
			<?= "previewRequester.send('sid=$siteID');" ?>
		}
	</script>
</body>
</html>