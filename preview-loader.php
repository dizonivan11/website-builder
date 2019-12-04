<?php include_once("core.php");
    $sid = $_POST["sid"];
    $pp = "previews/" . $_POST["sid"];
    if (file_exists($pp)) {
        // Deletes already created preview site for cleaner result
        deleteFiles($pp);
    }
    // TODO: Copy directory and Element manipulation processes here
    copyFiles("sites/$sid", "previews/$sid");
    RemoveBuilderOnlyElements("previews/$sid");

    // Give preview link to the builder
    echo("previews/$sid");
?>