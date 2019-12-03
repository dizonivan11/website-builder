<?php include_once("core.php");
    $sid = $_POST["sid"];
    $pp = "previews/" . $_POST["sid"];
    $pages = glob($pp . "*", GLOB_ONLYDIR);
    if (file_exists($pp)) {
        // Deletes already created preview site for cleaner result
        deleteFiles($pp);
    }
    // TODO: Copy directory and Element manipulation processes here

    print_r($pp);
?>