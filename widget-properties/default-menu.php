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
                <td class="radius"><input type="text" name="top-left-border-radius" autocomplete="off"></td>
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="margin"><input type="text" name="margin-top" autocomplete="off"></td>
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="radius"><input type="text" name="top-right-border-radius" autocomplete="off"></td>
            </tr><tr>
                <td class="margin"></td>
                <td class="border"></td>
                <td class="border"></td>
                <td class="border"><input type="text" name="border-top" autocomplete="off"></td>
                <td class="border"></td>
                <td class="border"></td>
                <td class="margin"></td>
            </tr><tr>
                <td class="margin"></td>
                <td class="border"></td>
                <td class="padding"></td>
                <td class="padding"><input type="text" name="padding-top" autocomplete="off"></td>
                <td class="padding"></td>
                <td class="border"></td>
                <td class="margin"></td>
            </tr><tr>
                <td class="margin"><input type="text" name="margin-left" autocomplete="off"></td>
                <td class="border"><input type="text" name="border-left" autocomplete="off"></td>
                <td class="padding"><input type="text" name="padding-left" autocomplete="off"></td>
                <td class="inner"></td>
                <td class="padding"><input type="text" name="padding-right" autocomplete="off"></td>
                <td class="border"><input type="text" name="border-right" autocomplete="off"></td>
                <td class="margin"><input type="text" name="margin-right" autocomplete="off"></td>
            </tr><tr>
                <td class="margin"></td>
                <td class="border"></td>
                <td class="padding"></td>
                <td class="padding"><input type="text" name="padding-bottom" autocomplete="off"></td>
                <td class="padding"></td>
                <td class="border"></td>
                <td class="margin"></td>
            </tr><tr>
                <td class="margin"></td>
                <td class="border"></td>
                <td class="border"></td>
                <td class="border"><input type="text" name="border-bottom" autocomplete="off"></td>
                <td class="border"></td>
                <td class="border"></td>
                <td class="margin"></td>
            </tr><tr>
                <td class="radius"><input type="text" name="bottom-left-border-radius" autocomplete="off"></td>
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="margin"><input type="text" name="margin-bottom" autocomplete="off"></td>
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="radius"><input type="text" name="bottom-right-border-radius" autocomplete="off"></td>
            </tr>
        </table>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <label class="widget-properties-subtitle">Font Color</label>
            <input name="font-color" class="jscolor" value="ffffff">
        </div>
    </div>
</div>
<?php
    include_once('../core.php');
    $wid = $_POST['wid'];
    $wpp = $_POST['wpp'];

    if (file_exists($wpp)) {
?>
<hr />
<div class="container">
    <div class="row">
        <div class="col-12">
            <label class="widget-properties-subtitle">Primary Properties</label>
        </div>
    </div>
</div>
<?php
        include_once($wpp);
    }
?>
<hr />
<div class="container">
    <div class="row">
        <div class="col-12">
            <?php echo("<button onclick='$wid'>Apply Changes</button>"); ?>
        </div>
    </div>
</div>