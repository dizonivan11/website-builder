<?php include_once("core.php");
    $rid = getEID();
    $cid = getEID();
?>
<?= "<div id ='$rid' class='row-wrapper'>" ?>
    <div class="container">
        <div class="row">
<?=         "<div id='$cid' class='col-wrapper col'>" ?>
                <button class="drop-zone" onclick="DropElement(this, event);" data-flag="builder-element">Add Selected Element</button>
            </div>
        </div>
    </div>
</div>