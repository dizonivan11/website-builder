primaryApplyParameters.push({ mode: "html", input: "wpw-text-content", format: "<div class='inner-wrapper'><p class='text-content'>{0}</p></div>" });

// Request to bind innerHTML of widget inside workspace to the input
workspace.contentWindow.postMessage({
    header: "getInnerHTML",
    selector: "#" + widgetPropertiesSelectedId + " > div.inner-wrapper > p.text-content",
    input: "#wpw-text-content"
});