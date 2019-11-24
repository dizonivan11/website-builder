var selectedElement = document.createElement('div');
var selectedElementOffset = 15;
var selectedElementYOffset = 0;

window.onload = function() {
	// Create and add selected element controller
	selectedElement.id = "selected-element";
	document.body.appendChild(selectedElement);

	// selected element follows cursor
	document.body.onmousemove = function (e) {
		selectedElement.style.left = (e.clientX + selectedElementOffset) + "px";
		selectedElement.style.top = (selectedElementYOffset + e.clientY + selectedElementOffset) + "px";
	};
}

// Process messages coming from builder
window.onmessage = function (e) {
	var header = e.data.header;
	var message = e.data.message;

	switch (header) {
		case "selectWidget":
			selectedElement.innerHTML = message;
			break;
		case "workspace-scrolled":
			selectedElementYOffset = message;
			break;
	}
}

function DropElement(dz) {
	var parent = dz.parentElement;
	if (selectedElement.innerHTML != "") {
		// Remove the drop zone then append the selected element
		// Appending automatically moving the elements inside 'selected-element' to destination
		parent.removeChild(dz);
		for (var i = 0; i < selectedElement.childNodes.length; i++) {
			parent.appendChild(selectedElement.childNodes[i]);
		}
		window.top.postMessage({ header: "feedback", message: "Selected element dropped." });
	} else {
		// Inform builder via HTTPRequest to display a message in feedback box
		window.top.postMessage({ header: "feedback", message: "No selected element." });
	}
}