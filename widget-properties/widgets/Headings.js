primaryApplyParameters.push({
    mode: "html",
    selectorFormat: "#{0} > div.inner-wrapper > *.main-headings",
    input: "wpw-headings-content"
});
primaryApplyParameters.push({
    mode: "css",
    selectorFormat: "#{0}",
    input: "wpw-headings-text-align",
    propertyName: "text-align",
    valueFormat: "{0}"
});
primaryApplyParameters.push({
    mode: "css",
    selectorFormat: "#{0}",
    input: "wpw-headings-text-style-bold",
    propertyName: "font-weight",
    valueFormat: "{0}",
    toggle: "wpw-headings-text-style-bold"
});
primaryApplyParameters.push({
    mode: "css",
    selectorFormat: "#{0}",
    input: "wpw-headings-text-style-italic",
    propertyName: "font-style",
    valueFormat: "{0}",
    toggle: "wpw-headings-text-style-italic"
});
primaryApplyParameters.push({
    mode: "css",
    selectorFormat: "#{0}",
    input: "wpw-headings-text-style-underline",
    propertyName: "text-decoration",
    valueFormat: "{0}",
    toggle: "wpw-headings-text-style-underline"
});