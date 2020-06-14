var selectedElement = null;
var rowContextMenu = null;
var colContextMenu = null;
var widgetContextMenu = null;
var selectedElementOffset = 15;

function ApplyDropAndOpenEvent(e, ev) {
	if (selectedElement.innerHTML != "") {
		// If there is selected widget, function as drop zone
		DropElement(e, ev);
	}
	// Avoid firing events to elements under this element (eg. parent of this element)
	ev.stopPropagation();
}

function ValidateOrCreateBuilderElement(id) {
	// Check if [id] builder element was already created.
	// If not present, create new [id] builder element.
	var element = document.getElementById(id);
	if (element === null) {
		element = document.createElement("div");
		element.id = id;
		element.setAttribute("data-flag", "builder-element");
		document.body.appendChild(element);
	}
	// Always clear content to prepare for fresh session. Some element must be recreated to apply its custom scripts.
	element.innerHTML = "";
	return element;
}

window.onload = function() {
	selectedElement = ValidateOrCreateBuilderElement("selected-element");
	rowContextMenu = ValidateOrCreateBuilderElement("row-context-wrapper");
	colContextMenu = ValidateOrCreateBuilderElement("col-context-wrapper");
	widgetContextMenu = ValidateOrCreateBuilderElement("widget-context-wrapper");
	
	// Validate if all row wrappers have id, add id to rows without id
	// Async request turned off to avoid requesting the same id at the same time
	// Row Properties Window to be added later
	var rws = $(".row-wrapper");
	for (var r = 0; r < rws.length; r++) {
		var row = rws[r];
		if (row.id == "") {
			$.ajax({
				url: "../../../request-current-eid.php",
				method: "POST",
				async: false,
				success: function(result) {
					row.id = result;
				}
			});
		}
	}

	// Validate if all column wrappers have id, add id to columns without id
	// Async request turned off to avoid requesting the same id at the same time
	// Column Properties Window to be added later
	var cws = $(".col-wrapper");
	for (var r = 0; r < cws.length; r++) {
		var col = cws[r];
		if (col.id == "") {
			$.ajax({
				url: "../../../request-current-eid.php",
				method: "POST",
				async: false,
				success: function(result) {
					col.id = result;
				}
			});
		}
	}

	// Add drop click events in all widget-wrapper elements
	$(".widget-wrapper").click(function() { ApplyDropAndOpenEvent(this, event); });

	// selected element follows cursor
	document.body.onmousemove = function (e) {
		selectedElement.style.left = (e.clientX + selectedElementOffset) + "px";
		selectedElement.style.top = (e.clientY + selectedElementOffset) + "px";
	};
	
	// Add context menu element and its event to all rows
	$.contextMenu({
		selector: '.row-wrapper',
		appendTo: '#row-context-wrapper',
        callback: function(key, opt) {
			switch (key) {
				// Open properties window for selected row
				case "edit":
					window.top.postMessage({ header: "open-row-properties", rid: opt.$trigger.attr("id") });
					break;
				case "addup":
					$.ajax({
						url: '../../../row-creator.php',
						type: 'POST',
						success: function(result) {
							$(result).insertBefore(opt.$trigger);
							window.top.postMessage({ header: "feedback", message: "New row added" });
						}
					});
					break;
				case "addbottom":
					$.ajax({
						url: '../../../row-creator.php',
						type: 'POST',
						success: function(result) {
							$(result).insertAfter(opt.$trigger);
							window.top.postMessage({ header: "feedback", message: "New row added" });
						}
					});
					break;
				case "delete":
					// Delete row only if there is at least one sibling remains on its section after the process
					if (opt.$trigger.parent().children().length > 1) {
						opt.$trigger.remove();
						window.top.postMessage({ header: "feedback", message: "Row #" + opt.$trigger.attr("id") + " deleted" });
					} else window.top.postMessage({ header: "feedback", message: "Cannot remove the only row present on its section" });
					break;
			}
        },
        items: {
			"edit": {name: "Edit Row Design", icon: "fa-edit"},
			"sep1": "----------",
            "addup": {name: "Add Row Above", icon: "fa-plus"},
			"addbottom": {name: "Add Row Below", icon: "fa-plus"},
			"sep2": "----------",
            "delete": {name: "Delete Row", icon: "fa-trash"}
        }
	});
	
	// Add context menu element and its event to all columns
	$.contextMenu({
		selector: '.col-wrapper',
		appendTo: '#col-context-wrapper',
        callback: function(key, opt) {
			switch (key) {
				// Open properties window for selected column
				case "edit":
					window.top.postMessage({ header: "open-col-properties", cid: opt.$trigger.attr("id") });
					break;
				case "addleft":
					$.ajax({
						url: '../../../col-creator.php',
						type: 'POST',
						success: function(result) {
							$(result).insertBefore(opt.$trigger);
							window.top.postMessage({ header: "feedback", message: "New column added" });
						}
					});
					break;
				case "addright":
					$.ajax({
						url: '../../../col-creator.php',
						type: 'POST',
						success: function(result) {
							$(result).insertAfter(opt.$trigger);
							window.top.postMessage({ header: "feedback", message: "New row added" });
						}
					});
					break;
				case "moveleft":
					if (opt.$trigger.prev().length < 1) {
						window.top.postMessage({ header: "feedback", message: "Cannot move further" });
						break;
					}
					$(opt.$trigger).insertBefore(opt.$trigger.prev());
					window.top.postMessage({ header: "feedback", message: "Column #" + opt.$trigger.attr("id") + " successfully moved left" });
					break;
				case "moveright":
					if (opt.$trigger.next().length < 1) {
						window.top.postMessage({ header: "feedback", message: "Cannot move further" });
						break;
					}
					$(opt.$trigger).insertAfter(opt.$trigger.next());
					window.top.postMessage({ header: "feedback", message: "Column #" + opt.$trigger.attr("id") + " successfully moved right" });
					break;
				case "delete":
					// Delete column only if there is at least one sibling remains on its row after the process
					if (opt.$trigger.parent().children().length > 1) {
						opt.$trigger.remove();
						window.top.postMessage({ header: "feedback", message: "Column #" + opt.$trigger.attr("id") + " deleted" });
					} else window.top.postMessage({ header: "feedback", message: "Cannot remove the only column present on its row" });
					break;
			}
        },
        items: {
			"edit": {name: "Edit Column Design", icon: "fa-edit"},
			"sep1": "----------",
            "addleft": {name: "Add New Column To Left", icon: "fa-plus"},
			"addright": {name: "Add New Column To Right", icon: "fa-plus"},
			"sep2": "----------",
            "moveleft": {name: "Move Column To Left", icon: "fa-arrow-left"},
			"moveright": {name: "Move Column To Right", icon: "fa-arrow-right"},
			"sep3": "----------",
            "delete": {name: "Delete Column", icon: "fa-trash"}
        }
	});

	// Add context menu element and its event to all widgets
	$.contextMenu({
		selector: '.widget-wrapper',
		appendTo: '#widget-context-wrapper',
        callback: function(key, opt) {
			switch (key) {
				case "edit":
					// Open properties window for selected widget
					window.top.postMessage({
						header: "open-widget-properties",
						widgetID: opt.$trigger.attr("id"),
						widgetPropertiesPath: opt.$trigger.attr("widget-name")
					});
					break;
				case "moveup":
					if (opt.$trigger.prev().length < 1) {
						window.top.postMessage({ header: "feedback", message: "Cannot move further" });
						break;
					}
					$(opt.$trigger).insertBefore(opt.$trigger.prev());
					window.top.postMessage({ header: "feedback", message: "Widget #" + opt.$trigger.attr("id") + " successfully moved up" });
					break;
				case "movedown":
					if (opt.$trigger.next().hasClass("drop-zone-min")) {
						window.top.postMessage({ header: "feedback", message: "Cannot move further" });
						break;
					}
					$(opt.$trigger).insertAfter(opt.$trigger.next());
					window.top.postMessage({ header: "feedback", message: "Widget #" + opt.$trigger.attr("id") + " successfully moved down" });
					break;
				case "delete":
					// Delete selected widget
					var wid = "#" + opt.$trigger.attr("id");
					var parent = $(wid).parent();
					$(wid).remove();
					// Maximize drop zone if the deleted widget was the last widget in column
					if (parent.children().length == 1) MaximizeDropZone(parent.children()[0]);
					window.top.postMessage({ header: "deleteWidget", selector: wid });
					break;
			}
        },
        items: {
			"edit": {name: "Edit Widget Design", icon: "fa-edit"},
			"sep1": "----------",
            "moveup": {name: "Move Up Widget", icon: "fa-arrow-up"},
			"movedown": {name: "Move Down Widget", icon: "fa-arrow-down"},
			"sep2": "----------",
            "delete": {name: "Delete Widget", icon: "fa-trash"}
        }
    });
}

// Process messages coming from builder
window.onmessage = function (e) {
	switch (e.data.header) {
		case "selectWidget":
			selectedElement.innerHTML = e.data.message;
			break;
		case "clearCSS":
			var l = e.data.elementSelectors.length;
			for (var i = 0; i < l; i++) $(e.data.elementSelectors[i]).removeAttr("style");
			window.top.postMessage({ header: "clearCSS" });
			break;
		case "applyCSS":
			$(e.data.selector).css(e.data.propertyName, e.data.propertyValue);
			break;
		case "applyATTR":
			$(e.data.selector).attr(e.data.attributeName, e.data.attributeValue);
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
		case "getATTR":
			window.top.postMessage({
				header: "bindATTR",
				attributeValue: $(e.data.selector).attr(e.data.attributeName),
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

function DropElement(e, ev) {
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
		$(widgetWrapper).click(function() { ApplyDropAndOpenEvent(this, event); });
		parent.insertBefore(widgetWrapper, e);
		selectedElement.innerHTML = "";
		
		// Inform builder to display a message in feedback box
		window.top.postMessage({ header: "feedback", message: "Selected widget dropped" });
	} else {
		// Inform builder to display a message in feedback box
		window.top.postMessage({ header: "feedback", message: "No selected widget" });
	}
	// Avoid firing events to elements under this element (eg. parent of this element)
	ev.stopPropagation();
}

function MinimizeDropZone(dz) {
	dz.className = "drop-zone-min";
	dz.innerHTML = "+";
}

function MaximizeDropZone(dz) {
	dz.className = "drop-zone";
	dz.innerHTML = "Add Selected Element";
}