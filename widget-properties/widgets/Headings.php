<div class="container">
    <div class="row">
        <div class="col-12">
            <label class="widget-properties-label">Content</label>
            <div>
                <button class="richTextButton fa fa-bold" onclick="document.execCommand('bold')"></button>
                <button class="richTextButton fa fa-italic" onclick="document.execCommand('italic')"></button>
                <button class="richTextButton fa fa-underline" onclick="document.execCommand('underline')"></button>
                <button class="richTextButton fa fa-link" onclick="ShowAddLinkDialog(this)"></button>
            </div>
            <div id="wpw-headings-content" contenteditable="true" class="richTextEditor"></div>
        </div>
    </div>
</div>
<hr />
<div class="container">
    <div class="row">
        <div class="col-4">
            <label class="widget-properties-label">Text Align</label><br>
            <select id="wpw-headings-text-align">
                <option value="" selected>Left</option>
                <option value="center">Center</option>
                <option value="right">Right</option>
                <option value="justify">Justify</option>
            </select>
        </div>
        <div class="col-8">
            <label class="widget-properties-label">Text Style</label><br>
            <input type="checkbox" id="wpw-headings-text-style-bold" value="700">
            <label for="wpw-headings-text-style-bold"><b>Bold</b></label>
            <input type="checkbox" id="wpw-headings-text-style-italic" value="italic">
            <label for="wpw-headings-text-style-italic"><i>Italic</i></label>
            <input type="checkbox" id="wpw-headings-text-style-underline" value="underline">
            <label for="wpw-headings-text-style-underline"><u>Underline</u></label>
        </div>
    </div>
</div>