var selectedElement = document.createElement("div");
var selectedElementOffset = 15;

function ApplyDropAndOpenEvent() {
	if (selectedElement.innerHTML != "") {
		// If there is selected widget, function as drop zone
		DropElement(this);
	} else {
		// Else, open properties window
		window.top.postMessage({
			header: "open-widget-properties",
			widgetID: this.id,
			widgetPropertiesPath: this.getAttribute("widget-name")
		});
	}
}

window.onload = function() {
	// Create and add selected element controller
	selectedElement.id = "selected-element";
	selectedElement.setAttribute("data-flag", "builder-element");
	document.body.appendChild(selectedElement);

	// Add Drop click events in all widget-wrapper elements
	$(".widget-wrapper").click(function() { ApplyDropAndOpenEvent.call(this); });

	// selected element follows cursor
	document.body.onmousemove = function (e) {
		selectedElement.style.left = (e.clientX + selectedElementOffset) + "px";
		selectedElement.style.top = (e.clientY + selectedElementOffset) + "px";
	};
}

// Process messages coming from builder
window.onmessage = function (e) {
	switch (e.data.header) {
		case "selectWidget":
			selectedElement.innerHTML = e.data.message;
			break;
		case "deleteWidget":
			var parent = $(e.data.selector).parent();
			$(e.data.selector).remove();
			// Maximize drop zone if the deleted widget was the last widget in column
			if (parent.children().length == 1) MaximizeDropZone(parent.children()[0]);
			window.top.postMessage({ header: "deleteWidget", selector: e.data.selector });
			break;
		case "clearCSS":
			var l = e.data.elementSelectors.length;
			for (var i = 0; i < l; i++) $(e.data.elementSelectors[i]).removeAttr("style");
			window.top.postMessage({ header: "clearCSS" });
			break;
		case "applyCSS":
			$(e.data.selector).css(e.data.propertyName, e.data.propertyValue);
			break;
		case "applyHTML":
			$(e.data.selector).html(e.data.propertyValue);
			break;
		case "getCSS":
			var globalCSS  = $(e.data.selector).css(e.data.propertyName);
			var inlineCSS = document.querySelector(e.data.selector).style[e.data.propertyName];
			window.top.postMessage({
				header: "bindCSS",
				inlineValue: inlineCSS, // overriding value
				defaultValue: globalCSS, // default value (placeholder)
				input: e.data.input
			});
			break;
		case "getHTML":
			window.top.postMessage({
				header: "bindHTML",
				innerHtml: $(e.data.selector).html(),
				input: e.data.input
			});
			break;
		case "savePage":
				$.ajax({
					url: '../../../page-saver.php',
					type: 'POST',
					// Pass array of 512 bytes string chunks containing whole HTML to file to server
					// data: { fileContent: document.documentElement.outerHTML.match(/(.|[\r\n]){1,512}/g) }
					data: { fileContent: document.documentElement.outerHTML, filePath: e.data.webPagePath },
					success: function(result) {
						window.top.postMessage({ header: "pageSaved", callback: e.data.successCallback, debug: result });
					}
				});
			break;
	}
}

function DropElement(e) {
	var isEmpty = e.className == "drop-zone";
	var parent = e.parentElement;
	if (selectedElement.innerHTML != "") {
		// Insert the selected element before the drop zone then clear the content of selected element
		// Minimize the drop zone if the selected element is the first widget to be added
		// SelectedElement must only have one container (widget-wrapper) which is auto generated by the builder
		// NOTE:-----
		// Not to be confused with the wrapper inside the widget itself (inner-wrapper) which can be styled -
		// as widget-wrapper only has meta data and a highlighting outline style.
		// Also, inner-wrapper is used to disable pointer events inside it so that we can select the -
		// widget-wrapper for opening menus not the elements of the widget.
		// ----------
		if (isEmpty) MinimizeDropZone(e);
		var widgetWrapper = selectedElement.childNodes[0];
		$(widgetWrapper).click(function() { ApplyDropAndOpenEvent.call(this); });
		parent.insertBefore(widgetWrapper, e);
		selectedElement.innerHTML = "";
		
		// Inform builder to display a message in feedback box
		window.top.postMessage({ header: "feedback", message: "Selected widget dropped" });
	} else {
		// Inform builder to display a message in feedback box
		window.top.postMessage({ header: "feedback", message: "No selected widget" });
	}
}

function MinimizeDropZone(dz) {
	dz.className = "drop-zone-min";
	dz.innerHTML = "+";
}

function MaximizeDropZone(dz) {
	dz.className = "drop-zone";
	dz.innerHTML = "Add Selected Element";
}