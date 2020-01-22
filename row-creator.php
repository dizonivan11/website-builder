<?php include_once("core.php");
    $rid = getEID();
    echo("<div id ='$rid' class='row-wrapper'>");
?>
    <div class="container">
        <div class="row">
            <div class="col-wrapper col">
                <button class="drop-zone" onclick="DropElement(this, event);" data-flag="builder-element">Add Selected Element</button>
            </div>
        </div>
    </div>
</div>