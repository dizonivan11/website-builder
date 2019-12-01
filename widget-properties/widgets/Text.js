primaryApplyParameters.push({
    mode: "html",
    input: "wpw-text-content",
    selectorFormat: "#{0} > div.inner-wrapper > p.text-content",
    selectorParameters: [ widgetPropertiesSelectedId ]
});
primaryApplyParameters.push({
    mode: "css",
    input: "wpw-text-bold",
    toggle: "wpw-text-bold",
    propertyName: "font-weight",
    format: "{0}"
});
primaryApplyParameters.push({
    mode: "css",
    input: "wpw-text-italic",
    toggle: "wpw-text-italic",
    propertyName: "font-style",
    format: "{0}"
});
primaryApplyParameters.push({
    mode: "css",
    input: "wpw-text-underline",
    toggle: "wpw-text-underline",
    propertyName: "text-decoration",
    format: "{0}"
});