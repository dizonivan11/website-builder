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