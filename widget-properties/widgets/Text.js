primaryApplyParameters.push({
    mode: "html",
    selectorFormat: "#{0} > div.inner-wrapper > p.text-content",
    input: "wpw-text-content"
});
primaryApplyParameters.push({
    mode: "css",
    selectorFormat: "#{0}",
    input: "wpw-text-bold",
    propertyName: "font-weight",
    valueFormat: "{0}",
    toggle: "wpw-text-bold"
});
primaryApplyParameters.push({
    mode: "css",
    selectorFormat: "#{0}",
    input: "wpw-text-italic",
    propertyName: "font-style",
    valueFormat: "{0}",
    toggle: "wpw-text-italic"
});
primaryApplyParameters.push({
    mode: "css",
    selectorFormat: "#{0}",
    input: "wpw-text-underline",
    propertyName: "text-decoration",
    valueFormat: "{0}",
    toggle: "wpw-text-underline"
});