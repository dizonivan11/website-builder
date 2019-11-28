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
            <button onclick="widgetProperties.style.display = 'none';" style="width: 100%">Close</button>
        </div>
        <div class="col-6">
            <button style="width: 100%">Delete</button>
        </div>
    </div>
</div>
<hr />
<div class="container">
    <div class="row">
        <div class="col-12">
            <label class="widget-properties-subtitle">Spacing & Border</label>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
        <table id="spacing-border">
            <tr>
                <td class="radius"><input type="text" id="wpw-default-top-left-border-radius" autocomplete="off"></td>
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="margin"><input type="text" id="wpw-default-margin-top" autocomplete="off"></td>
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="radius"><input type="text" id="wpw-default-top-right-border-radius" autocomplete="off"></td>
            </tr><tr>
                <td class="margin"></td>
                <td class="border"></td>
                <td class="border"></td>
                <td class="border"><input type="text" id="wpw-default-border-top-width" autocomplete="off"></td>
                <td class="border"></td>
                <td class="border"></td>
                <td class="margin"></td>
            </tr><tr>
                <td class="margin"></td>
                <td class="border"></td>
                <td class="padding"></td>
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
            <label class="widget-properties-subtitle">Font Color</label>
            <input id="wpw-default-font-color" value="#ffffff">
        </div>
    </div>
</div>
<div id="wpw-primary-property"></div>
<hr />
<div class="container">
    <div class="row">
        <div class="col-12">
            <button onclick="ApplyChanges(); widgetProperties.style.display = 'none';">Apply Changes</button>
        </div>
    </div>
</div>