var selectedElement = null;
var rowContextMenu = null;
var colContextMenu = null;
var widgetContextMenu = null;
var selectedElementOffset = 15;
var selectedColResizer = null;
const colResizeDistance = 80; // The target distance (in pixel) of dragging to successfully resize a column
var colResizeAnchor = 0;
var colCurrentResizeDistance = 0;
var maxColSize = 12;
var maxColInARow = 4;
var possibleColSizes = [
	"col-lg-12", "col-lg-11", "col-lg-10", "col-lg-9",
	"col-lg-8", "col-lg-7", "col-lg-6", "col-lg-5",
	"col-lg-4", "col-lg-3", "col-lg-2", "col-lg-1",

	"col-md-12", "col-md-11", "col-md-10", "col-md-9",
	"col-md-8", "col-md-7", "col-md-6", "col-md-5",
	"col-md-4", "col-md-3", "col-md-2", "col-md-1",

	"col-sm-12", "col-sm-11", "col-sm-10", "col-sm-9",
	"col-sm-8", "col-sm-7", "col-sm-6", "col-sm-5",
	"col-sm-4", "col-sm-3", "col-sm-2", "col-sm-1"
];
var copiedElement = null;
var copiedElementWrapper = "";

function ApplyDropAndOpenEvent(e, ev) {
	if (selectedElement.innerHTML != "") {
		// If there is selected widget, function as drop zone
		DropElement(e, ev);
	}
	// Avoid firing events to elements under this element (eg. parent of this element)
	ev.stopPropagation();
}

function InsertColumnResizerBefore(colWrapper) {
	var newColResizer = $("<div class='col-resizer-wrapper' data-flag='builder-element'><div class='col-resizer'><span>‖</span></div></div>");
	newColResizer.insertBefore(colWrapper);
	newColResizer.find(".col-resizer").mousedown(function() {
		selectedColResizer = $(this);
		colResizeAnchor = selectedColResizer.offset().left;
		event.stopPropagation();
	});
	newColResizer.find(".col-resizer").mouseup(function() {
		selectedColResizer = null;
		colResizeAnchor = 0;
		event.stopPropagation();
	});
}

function DeleteColumnResizerBefore(colWrapper) {
	var colResizerToDelete = null;
	if (colWrapper.index() == 0) {
		// If the column to delete is the first column in its row
		colResizerToDelete = colWrapper.next();
	} else {
		// If the column to delete is not the first column in its row
		colResizerToDelete = colWrapper.prev();
	}
	if (colResizerToDelete != null && colResizerToDelete.hasClass("col-resizer-wrapper"))
		colResizerToDelete.remove();
}

function ResizeColumnEvent(ev) {
	if (selectedColResizer != null) {
		if (selectedColResizer.css("opacity") < 1) {
			selectedColResizer = null;
			colResizeAnchor = 0;
			return;
		}
		colCurrentResizeDistance = ev.pageX - colResizeAnchor;
		var left = selectedColResizer.parent().prev();
		var right = selectedColResizer.parent().next();

		if (left != null && right != null) {
			if (colCurrentResizeDistance <= -colResizeDistance)
				ExpandColumn(right, left);
			else if (colCurrentResizeDistance >= colResizeDistance)
				ExpandColumn(left, right);
		}
	}
}

function ExpandColumn(expandingColumn, contractingColumn) {
	var canChange = false;
	for (let s = 0; s < possibleColSizes.length; s++) {
		const currentColSize = possibleColSizes[s];
		if (currentColSize != "col-lg-1" &&
			!currentColSize.includes("col-md-") &&
			!currentColSize.includes("col-sm-") &&
			contractingColumn.hasClass(currentColSize)) {
				contractingColumn.removeClass(currentColSize);
				contractingColumn.addClass(possibleColSizes[s + 1]);
				canChange = true;
				break;
		}
	}
	if (!canChange) return;
	for (let s = 0; s < possibleColSizes.length; s++) {
		const currentColSize = possibleColSizes[s];
		if (currentColSize != "col-lg-12" &&
			!currentColSize.includes("col-md-") &&
			!currentColSize.includes("col-sm-") &&
			expandingColumn.hasClass(currentColSize)) {
				expandingColumn.removeClass(currentColSize);
				expandingColumn.addClass(possibleColSizes[s - 1]);
				break;
		}
	}
	colResizeAnchor += colCurrentResizeDistance;
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

function GetEID() {
	var id = -1;
	$.ajax({
		url: "../../../request-current-eid.php",
		method: "POST",
		// Async request turned off to avoid requesting the same id at the same time
		async: false,
		success: function(result) { id = result; }
	});
	return id;
}

// For requesting new ID to all child element of copied element (deep scan)
function RequestNewIDForChildren(newElement) {
	var selector = "#" + newElement.attr("id") + " .widget-wrapper, #" + newElement.attr("id") +  " .col-wrapper, #" + newElement.attr("id") +  " .row-wrapper";
	$(selector).each(function(index) {
		$(this).attr("id", GetEID());
	});
}

window.onload = function() {
	selectedElement = ValidateOrCreateBuilderElement("selected-element");
	rowContextMenu = ValidateOrCreateBuilderElement("row-context-wrapper");
	colContextMenu = ValidateOrCreateBuilderElement("col-context-wrapper");
	widgetContextMenu = ValidateOrCreateBuilderElement("widget-context-wrapper");
	
	// Validate if all row and column wrappers have id, add id to rows and columns without id
	// Row and Column Properties Window to be added later
	var ws = $(".row-wrapper, .col-wrapper");
	for (var r = 0; r < ws.length; r++) {
		var w = ws[r];
		if (w.id == "") {
			w.id = GetEID();
		}
	}

	// Validate if all column wrappers have resizers in between them, add resizers if none
	var rws = $(".row-wrapper");
	for (var r = 0; r < rws.length; r++) {
		var rcols = $(rws[r]).find(".col-wrapper");
		for (var c = 1; c < rcols.length; c++) {
			var colWrapper = $(rcols[c]);
			var colResizerWrapper = colWrapper.prev();
			if (!colResizerWrapper.hasClass("col-resizer-wrapper")) {
				InsertColumnResizerBefore(colWrapper);
			} else {
				colResizerWrapper.find(".col-resizer").mousedown(function() {
					selectedColResizer = $(this);
					colResizeAnchor = selectedColResizer.offset().left;
					console.log(selectedColResizer.offset().left);
					event.stopPropagation();
				});
				colResizerWrapper.find(".col-resizer").mouseup(function() {
					selectedColResizer = null;
					colResizeAnchor = 0;
					event.stopPropagation();
				});
			}
		}
	}

	// Add drop click events in all widget-wrapper elements
	$(document).on("click", ".widget-wrapper", function() { ApplyDropAndOpenEvent(this, event); });

	// Add necessary column resizer event
	$(document).mousemove(function(event) { ResizeColumnEvent(event) });

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
				case "copy":
					copiedElement = opt.$trigger;
					copiedElementWrapper = "row-wrapper";
					window.top.postMessage({ header: "feedback", message: "Copied row #" + opt.$trigger.attr("id") });
					break;
				case "paste":
					if (copiedElement == null) {
						window.top.postMessage({ header: "feedback", message: "No copied element" });
						break;
					}
					// Ensure that you are pasting to the same type of element
					if (!opt.$trigger.hasClass(copiedElementWrapper)) {
						window.top.postMessage({ header: "feedback", message: "Cannot paste to non-row element" });
						break;
					}
					var newElement = copiedElement.clone(true, true);
					newElement.attr("id", GetEID());

					// Ensure context-menu-active class is deleted as this prevents opening context menu when right-clicked
					newElement.removeClass("context-menu-active");

					// Paste the new row to the top of the selected row
					$(newElement).insertBefore(opt.$trigger);

					// Process all element's ID inside the new row
					RequestNewIDForChildren(newElement);

					window.top.postMessage({ header: "feedback", message: "Pasted row" });
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
			"copy": {name: "Copy Row", icon: "fa-copy"},
			"paste": {name: "Paste Here", icon: "fa-paste"},
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
				case "copy":
					copiedElement = opt.$trigger;
					copiedElementWrapper = "col-wrapper";
					window.top.postMessage({ header: "feedback", message: "Copied column #" + opt.$trigger.attr("id") });
					break;
				case "paste":
					if (copiedElement == null) {
						window.top.postMessage({ header: "feedback", message: "No copied element" });
						break;
					}
					// Ensure that you are pasting to the same type of element
					if (!opt.$trigger.hasClass(copiedElementWrapper)) {

						// EXCEPTION: If the copied element is a widget, we can insert it to the bottom of the column
						if (copiedElementWrapper == "widget-wrapper") {
							var newElement = copiedElement.clone(true, true);
							newElement.attr("id", GetEID());

							// Ensure context-menu-active class is deleted as this prevents opening context menu when right-clicked
							newElement.removeClass("context-menu-active");

							// Paste the new widget to the top of the selected widget
							$(newElement).insertAfter(opt.$trigger.children().last());

							// Process all element's ID inside the new widget
							RequestNewIDForChildren(newElement);

							window.top.postMessage({ header: "feedback", message: "Appended widget to the column #" + opt.$trigger.attr("id") });
							break;
						}

						window.top.postMessage({ header: "feedback", message: "Cannot paste to non-column element" });
						break;
					}
					var newElement = copiedElement.clone(true, true);
					newElement.attr("id", GetEID());

					// Ensure context-menu-active class is deleted as this prevents opening context menu when right-clicked
					newElement.removeClass("context-menu-active");

					// Paste the new column to the left of the selected column
					$(newElement).insertBefore(opt.$trigger);
					RecalculateColumnSizes(opt.$trigger.parent());
					InsertColumnResizerBefore(opt.$trigger);

					// Process all element's ID inside the new column
					RequestNewIDForChildren(newElement);

					window.top.postMessage({ header: "feedback", message: "Pasted column" });
					break;
				case "addleft":
					$.ajax({
						url: '../../../col-creator.php',
						type: 'POST',
						success: function(result) {
							var cols = opt.$trigger.parent().find(".col");
							if (cols.length >= maxColInARow) {
								window.top.postMessage({ header: "feedback", message: "Reached maximum number of columns in a row" });
							} else {
								$(result).insertBefore(opt.$trigger);
								RecalculateColumnSizes(opt.$trigger.parent());
								InsertColumnResizerBefore(opt.$trigger);
								window.top.postMessage({ header: "feedback", message: "New column added" });
							}
						}
					});
					break;
				case "addright":
					$.ajax({
						url: '../../../col-creator.php',
						type: 'POST',
						success: function(result) {
							var cols = opt.$trigger.parent().find(".col");
							if (cols.length >= maxColInARow) {
								window.top.postMessage({ header: "feedback", message: "Reached maximum number of columns in a row" });
							} else {
								var newColumn = $(result);
								newColumn.insertAfter(opt.$trigger);
								RecalculateColumnSizes(opt.$trigger.parent());
								InsertColumnResizerBefore(newColumn);
								window.top.postMessage({ header: "feedback", message: "New column added" });
							}
						}
					});
					break;
				case "moveleft":
					// Invalid move
					if (opt.$trigger.prev().length < 1) {
						window.top.postMessage({ header: "feedback", message: "Cannot move further" });
						break;
					}
					var firstColumnNeighbor = opt.$trigger.prev();
					var secondColumn = firstColumnNeighbor;

					// Iterate all previous element to find the nearest column skipping any element in between them
					while (!secondColumn.hasClass("col-wrapper"))
						secondColumn = secondColumn.prev();

					// Invalid move
					if (!secondColumn.hasClass("col-wrapper")) {
						window.top.postMessage({ header: "feedback", message: "Cannot move further" });
						break;
					}

					// Do the swapping
					opt.$trigger.insertBefore(secondColumn);
					secondColumn.insertAfter(firstColumnNeighbor);

					window.top.postMessage({ header: "feedback", message: "Column #" + opt.$trigger.attr("id") + " successfully moved left" });
					break;
				case "moveright":
					// Invalid move
					if (opt.$trigger.next().length < 1) {
						window.top.postMessage({ header: "feedback", message: "Cannot move further" });
						break;
					}
					var firstColumnNeighbor = opt.$trigger.next();
					var secondColumn = firstColumnNeighbor;

					// Iterate all next element to find the nearest column skipping any element in between them
					while (!secondColumn.hasClass("col-wrapper"))
						secondColumn = secondColumn.next();

					// Invalid move
					if (!secondColumn.hasClass("col-wrapper")) {
						window.top.postMessage({ header: "feedback", message: "Cannot move further" });
						break;
					}

					// Do the swapping
					opt.$trigger.insertAfter(secondColumn);
					secondColumn.insertBefore(firstColumnNeighbor);
					
					window.top.postMessage({ header: "feedback", message: "Column #" + opt.$trigger.attr("id") + " successfully moved right" });
					break;
				case "delete":
					// Delete column only if there is at least one sibling remains on its row after the process
					if (opt.$trigger.parent().children().length > 1) {
						var colParent = opt.$trigger.parent();
						DeleteColumnResizerBefore(opt.$trigger);
						opt.$trigger.remove();
						RecalculateColumnSizes(colParent);
						window.top.postMessage({ header: "feedback", message: "Column #" + opt.$trigger.attr("id") + " deleted" });
					} else window.top.postMessage({ header: "feedback", message: "Cannot remove the only column present on its row" });
					break;
			}
        },
        items: {
			"edit": {name: "Edit Column Design", icon: "fa-edit"},
			"copy": {name: "Copy Column", icon: "fa-copy"},
			"paste": {name: "Paste Here", icon: "fa-paste"},
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
				case "copy":
					copiedElement = opt.$trigger;
					copiedElementWrapper = "widget-wrapper";
					window.top.postMessage({ header: "feedback", message: "Copied widget #" + opt.$trigger.attr("id") });
					break;
				case "paste":
					if (copiedElement == null) {
						window.top.postMessage({ header: "feedback", message: "No copied element" });
						break;
					}
					// Ensure that you are pasting to the same type of element
					if (!opt.$trigger.hasClass(copiedElementWrapper)) {
						window.top.postMessage({ header: "feedback", message: "Cannot paste to non-widget element" });
						break;
					}
					var newElement = copiedElement.clone(true, true);
					newElement.attr("id", GetEID());

					// Ensure context-menu-active class is deleted as this prevents opening context menu when right-clicked
					newElement.removeClass("context-menu-active");

					// Paste the new widget to the top of the selected widget
					$(newElement).insertBefore(opt.$trigger);

					// Process all element's ID inside the new widget
					RequestNewIDForChildren(newElement);

					window.top.postMessage({ header: "feedback", message: "Pasted widget" });
					break;
				case "move":
					var parent = opt.$trigger.parent();
					opt.$trigger.removeClass("context-menu-active");
					opt.$trigger.remove();
					// Maximize drop zone if the deleted widget was the last widget in column
					if (parent.find(".widget-wrapper").length == 0) MaximizeDropZone(parent.find(".drop-zone-min")[0]);
					selectedElement.innerHTML = opt.$trigger[0]["outerHTML"];
					break;
				case "delete":
					// Delete selected widget
					var wid = "#" + opt.$trigger.attr("id");
					var parent = opt.$trigger.parent();
					opt.$trigger.remove();
					// Maximize drop zone if the deleted widget was the last widget in column
					if (parent.find(".widget-wrapper").length == 0) MaximizeDropZone(parent.find(".drop-zone-min")[0]);
					window.top.postMessage({ header: "deleteWidget", selector: wid });
					break;
			}
        },
        items: {
			"edit": {name: "Edit Widget Design", icon: "fa-edit"},
			"copy": {name: "Copy Widget", icon: "fa-copy"},
			"paste": {name: "Paste Here", icon: "fa-paste"},
			"sep1": "----------",
            "move": {name: "Move Widget", icon: "fa-arrows"},
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
		parent.insertBefore(selectedElement.childNodes[0], e);
		selectedElement.innerHTML = "";
		
		// Inform builder to display a message in feedback box
		window.top.postMessage({ header: "feedback", message: "Widget added" });
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

function RecalculateColumnSizes(parentRow) {
	var cols = parentRow.find(".col");
	possibleColSizes.forEach(possibleColSize => {
		for (let c = 0; c < cols.length; c++) {
			const col = $(cols[c]);
			if (col.hasClass(possibleColSize))
				col.removeClass(possibleColSize);
		}
	});
	for (let c = 0; c < cols.length; c++) {
		const col = $(cols[c]);
		var newSize = maxColSize / cols.length;
		col.addClass("col-lg-" + newSize);
		col.addClass("col-md-" + newSize);
		col.addClass("col-sm-12");
	}
}