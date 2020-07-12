<?php
    // Automatically creates wrapper then place the widget's content inside it
    // Wrappers can define each element's controller with id and widget-name
    include_once('core.php');
    $filename = $_POST['fp'];
    $filename_noext = substr($filename, 0, strpos($filename, "."));
    $eid = getEID();
    echo("<div id='$eid' class='widget-wrapper' widget-name='$filename_noext'>\n");
    echo(file_get_contents(dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . $filename));
    echo("</div>\n");
?>