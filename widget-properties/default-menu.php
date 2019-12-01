<div class="container">
    <div class="row">
        <div class="col-12">
            <label class="widget-properties-title">Widget Properties</label>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-6">
            <button onclick="widgetProperties.style.display = 'none';">Close</button>
        </div>
        <div class="col-6">
            <button>Delete</button>
        </div>
    </div>
</div>
<hr />
<div class="container">
    <div class="row">
        <div class="col-12">
            <label class="widget-properties-subtitle">Spacing & Border</label>
            <table id="spacing-border">
                <tr>
                    <td class="radius"><input type="text" id="wpw-default-top-left-border-radius" autocomplete="off"></td>
                    <td class="margin"></td>
                    <td class="margin">M</td>
                    <td class="margin"><input type="text" id="wpw-default-margin-top" autocomplete="off"></td>
                    <td class="margin"></td>
                    <td class="margin"></td>
                    <td class="radius"><input type="text" id="wpw-default-top-right-border-radius" autocomplete="off"></td>
                </tr><tr>
                    <td class="margin"></td>
                    <td class="border"></td>
                    <td class="border">B</td>
                    <td class="border"><input type="text" id="wpw-default-border-top-width" autocomplete="off"></td>
                    <td class="border"></td>
                    <td class="border"></td>
                    <td class="margin"></td>
                </tr><tr>
                    <td class="margin"></td>
                    <td class="border"></td>
                    <td class="padding">P</td>
                    <td class="padding"><input type="text" id="wpw-default-padding-top" autocomplete="off"></td>
                    <td class="padding"></td>
                    <td class="border"></td>
                    <td class="margin"></td>
                </tr><tr>
                    <td class="margin"><input type="text" id="wpw-default-margin-left" autocomplete="off"></td>
                    <td class="border"><input type="text" id="wpw-default-border-left-width" autocomplete="off"></td>
                    <td class="padding"><input type="text" id="wpw-default-padding-left" autocomplete="off"></td>
                    <td class="inner"></td>
                    <td class="padding"><input type="text" id="wpw-default-padding-right" autocomplete="off"></td>
                    <td class="border"><input type="text" id="wpw-default-border-right-width" autocomplete="off"></td>
                    <td class="margin"><input type="text" id="wpw-default-margin-right" autocomplete="off"></td>
                </tr><tr>
                    <td class="margin"></td>
                    <td class="border"></td>
                    <td class="padding"></td>
                    <td class="padding"><input type="text" id="wpw-default-padding-bottom" autocomplete="off"></td>
                    <td class="padding"></td>
                    <td class="border"></td>
                    <td class="margin"></td>
                </tr><tr>
                    <td class="margin"></td>
                    <td class="border"></td>
                    <td class="border"></td>
                    <td class="border"><input type="text" id="wpw-default-border-bottom-width" autocomplete="off"></td>
                    <td class="border"></td>
                    <td class="border"></td>
                    <td class="margin"></td>
                </tr><tr>
                    <td class="radius"><input type="text" id="wpw-default-bottom-left-border-radius" autocomplete="off"></td>
                    <td class="margin"></td>
                    <td class="margin"></td>
                    <td class="margin"><input type="text" id="wpw-default-margin-bottom" autocomplete="off"></td>
                    <td class="margin"></td>
                    <td class="margin"></td>
                    <td class="radius"><input type="text" id="wpw-default-bottom-right-border-radius" autocomplete="off"></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<hr />
<div class="container">
    <div class="row">
        <div class="col-12">
            <input type="checkbox" id="wpw-toggle-default-border">
            <label class="widget-properties-subtitle">Border</label><br>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <label class="widget-properties-label">Border Color</label><br>
            <input id="wpw-default-border-color" value="#000000">
        </div>
        <div class="col-6">
            <label class="widget-properties-label">Border Style</label><br>
            <select id="wpw-default-border-style">
                <option value="solid" selected>Solid</option>
                <option value="dotted">Dotted</option>
                <option value="dashed">Dashed</option>
            </select>
        </div>
    </div>
</div>
<hr />
<div class="container">
    <div class="row">
        <div class="col-12">
            <input type="checkbox" id="wpw-toggle-default-background-color">
            <label class="widget-properties-label">Background Color</label>
            <input id="wpw-default-background-color" value="#000000">
        </div>
    </div>
</div>
<hr />
<div class="container">
    <div class="row">
        <div class="col-12">
            <input type="checkbox" id="wpw-toggle-default-foreground-color">
            <label class="widget-properties-label">Foreground Color</label>
            <input id="wpw-default-foreground-color" value="#000000">
        </div>
    </div>
</div>
<div id="wpw-primary-property"></div>
<hr />
<div class="container">
    <div class="row">
        <div class="col-12">
            <button onclick="ApplyChanges();">Apply Changes</button>
        </div>
    </div>
</div>