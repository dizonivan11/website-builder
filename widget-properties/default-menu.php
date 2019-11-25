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
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="margin"><input type="text" name="margin-top"></td>
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="margin"></td>
            </tr><tr>
                <td class="margin"></td>
                <td class="border"></td>
                <td class="border"></td>
                <td class="border"><input type="text" name="border-top"></td>
                <td class="border"></td>
                <td class="border"></td>
                <td class="margin"></td>
            </tr><tr>
                <td class="margin"></td>
                <td class="border"></td>
                <td class="padding"></td>
                <td class="padding"><input type="text" name="padding-top"></td>
                <td class="padding"></td>
                <td class="border"></td>
                <td class="margin"></td>
            </tr><tr>
                <td class="margin"><input type="text" name="margin-left"></td>
                <td class="border"><input type="text" name="border-left"></td>
                <td class="padding"><input type="text" name="padding-left"></td>
                <td class="inner"></td>
                <td class="padding"><input type="text" name="padding-right"></td>
                <td class="border"><input type="text" name="border-right"></td>
                <td class="margin"><input type="text" name="margin-right"></td>
            </tr><tr>
                <td class="margin"></td>
                <td class="border"></td>
                <td class="padding"></td>
                <td class="padding"><input type="text" name="padding-bottom"></td>
                <td class="padding"></td>
                <td class="border"></td>
                <td class="margin"></td>
            </tr><tr>
                <td class="margin"></td>
                <td class="border"></td>
                <td class="border"></td>
                <td class="border"><input type="text" name="border-bottom"></td>
                <td class="border"></td>
                <td class="border"></td>
                <td class="margin"></td>
            </tr><tr>
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="margin"><input type="text" name="margin-bottom"></td>
                <td class="margin"></td>
                <td class="margin"></td>
                <td class="margin"></td>
            </tr>
        </table>
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
            <label class="widget-properties-subtitle">Other Properties</label>
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