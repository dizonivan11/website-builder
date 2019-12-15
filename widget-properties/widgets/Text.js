primaryApplyParameters.push({
    mode: "html",
    selectorFormat: "#{0} > div.inner-wrapper > p.text-content",
    input: "wpw-text-content"
});
PreventHTMLPaste("#wpw-text-content");
primaryApplyParameters.push({
    mode: "css",
    selectorFormat: "#{0}",
    input: "wpw-text-text-align",
    propertyName: "text-align",
    valueFormat: "{0}"
});
primaryApplyParameters.push({
    mode: "css",
    selectorFormat: "#{0}",
    input: "wpw-text-text-style-bold",
    propertyName: "font-weight",
    valueFormat: "{0}",
    toggle: "wpw-text-text-style-bold"
});
primaryApplyParameters.push({
    mode: "css",
    selectorFormat: "#{0}",
    input: "wpw-text-text-style-italic",
    propertyName: "font-style",
    valueFormat: "{0}",
    toggle: "wpw-text-text-style-italic"
});
primaryApplyParameters.push({
    mode: "css",
    selectorFormat: "#{0}",
    input: "wpw-text-text-style-underline",
    propertyName: "text-decoration-line",
    valueFormat: "{0}",
    toggle: "wpw-text-text-style-underline"
});