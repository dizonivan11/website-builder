<?php
    include_once("core.php");

    $filetoExclude = array("core.php", "Medoo.php", "request-current-eid.php", "row-creator.php", "col-creator.php", "widget-loader.php", "phpliteadmin.php", "phpliteadmin.config.php");
    $sid = $_POST["sid"];
    $pp = "previews/$sid/";
    if (file_exists($pp)) {
        // Deletes already created preview site for cleaner result
        deleteFiles($pp);
    }
    // TODO: Copy directory and Element manipulation processes here
    copyFiles("sites/$sid", $pp);
    RemoveBuilderOnlyElements($pp);

    // Remove engine files
    for ($e = 0; $e < count($filetoExclude); $e++) { 
        $engineFile = $filetoExclude[$e];

        if (file_exists("$pp/$engineFile"))
            unlink("$pp/$engineFile");
    }

    // Give preview link to the builder
    echo($pp);
?>