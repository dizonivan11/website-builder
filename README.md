# BWB: Website Builder
**Languages/Technologies/Plugins Used: PHP, MYSQL, jQuery, AJAX, Medoo, HTMLKelly Color Picker, jQuery Custom Context Menu (https://swisnl.github.io/jQuery-contextMenu/)**

### FIRST TIME SETUP
<ol>
<li>Make sure PHP is installed on your device. (manually or automatically via XAMPP)</li>
<li>If sqlite extension is not yet activated on "php.ini" file, uncomment sqlite extension to activate the extension.</li>
</ol>
  
### RUNNING THE SERVER
To run the server, open up terminal or command prompt, type the command `php -S localhost:8000`

### CREATING NEW SITE
To create new site, use this URL: `localhost:8000/create.php?sid=<SITE ID>&template=<TEMPLATE NAME>`
<ol>
<li>Replace <code>&lt;SITE ID&gt;</code> with your desired site ID</li>
<li>Replace <code>&lt;TEMPLATE NAME&gt;</code> with your desired template</li>
</ol>

#### Current Templates Available:
<ol>
<li>blank</li>
</ol>
  
### OPENING SITES
To open sites, use this URL: `localhost:8000/?sid=<SITE ID>`
<ol>
<li>Replace <code>&lt;SITE ID&gt;</code> with your desired site ID</li>
</ol>

## Current TODO:
<ol>
<li>Revise how CSS is injected to the element. Avoid Inline CSS and make all the CSS append to some file that links to the web page (ex. DUDA's Dev Mode)</li>
</ol>

### TODO List:
<ol>
<li>Fix bug when the selected text becomes 'undefined' after using Add Link Dialog</li>
<li>Add Row and Column Properties Window</li>
<li>Convert all hard-coded input html and let the predefined html (widget-properties/inputs/) generate the html</li>
<li>Add More Buttons in WYSIWYG Text Editor</li>
<li>Bind Link and New Tab option when opening Add Link Dialog</li>
<li>Save Changes upon value change in Widget Properties Window (no Apply Changes button anymore)</li>
<li>[Realtime Saving] Save to webpage file upon value change in Widget Properties Window</li>
<li>[Realtime Saving] Save to webpage file upon dropping new widget to column</li>
<li>[Realtime Saving] Save to webpage file upon deleting widget</li>
<li>Clean [document.getElementById] functions and use jQuery selectors instead for selector consistency</li>
<li>Clean AJAX requests functions and use jQuery ajax instead for cleaner code and consistency</li>
<li>Move content editing outside properties window and allow editing content of widget directly when clicked</li>
<li>Color Pallete</li>
<li>Widget/Row/Column Background Image property</li>
<li>Inner Rows</li>
<li>Site Map</li>
<li>Adding Pages</li>
<li>Sorting Pages</li>
<li>Deleting Pages</li>
<li>Uploading Images</li>
<li>Publishing</li>
<li>Capability of moving the widgets to either top or bottom of selected element, not always inserting at top</li>
<li>Revise attribute [widget-name], remove "widget/" directory to display only the widget actual name in labels</li>
</ol>

### Done TODO
<ol>
<li>Revise request-current-eid.php, dont rely on one DB to get ID. Give sites their own meta data db to read to support multiple request across sites.</li>
<li>Revise meta value column to hold string data</li>
<li>Add site creator that duplicates selected template and adding engine files</li>
<li>Add Row Move Feature</li>
<li>Copy/Paste Feature for Rows, Columns, and Widgets</li>
<li>Event Inject Only Once</li>
<li>Fix Bug swapping columns (column resizers are also swapping)</li>
<li>Allow dragging to resize columns</li>
<li>Fix bug when breaking lines in text widget, this bug occurs because &lt;p> tag cannot contain &lt;div> tags</li>
<li>Make all context menu options functional (Adding/Deleting Rows, Adding/Deleting Columns, Shift Widgets/Rows, etc.)</li>
<li>Add Access to Columns</li>
<li>Fix selected-element and auto generated context menu at the end of the html file being saved which causes duplicated content</li>
<li>Add Context Menu</li>
<li>Revise/Simplify Primary Properties input requests using predefined html with automatic assigning of its id</li>
<li>Add selected widget/row labels</li>
<li>Make buttons in WYSIWYG Text Editor check first if the selected range is inside its parent editor to continue the operation to prevent editing any element outside its parent editor</li>
<li>Adding WYSIWYG Text Editors</li>
<li>Deleting Widgets</li>
<li>Saving website progress (Hard Save first, not Realtime yet) when clicking either publish or preview</li>
<li>Previewing Site</li>
<li>Site ID GET parameter</li>
<li>Binding of CSS in widget property fields</li>
<li>Load current widget property values on input fields before opening widget properties window</li>
<li>Revise code for applying css and html changes</li>
<li>Applying Widget Property changes</li>
<li>Widget Background Color</li>
</ol>

### Dropped TODO
<ol>
<li>Create Modules for Widget Properties Window</li>
</ol>
