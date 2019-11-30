primaryApplyParameters.push({
    mode: "html",
    input: "wpw-text-content",
    selectorFormat: "#{0} > div.inner-wrapper > p.text-content"
});

// Request to bind innerHTML of widget inside workspace to the input
workspace.contentWindow.postMessage({
    header: "getInnerHTML",
    selector: "#" + widgetPropertiesSelectedId + " > div.inner-wrapper > p.text-content",
    input: "#wpw-text-content"
});