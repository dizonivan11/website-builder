<?php include_once("core.php");
    $cid = getEID();
?>
<?= "<div id='$cid' class='col-wrapper col'>" ?>
    <button class="drop-zone" onclick="DropElement(this, event);" data-flag="builder-element">Add Selected Element</button>
</div>