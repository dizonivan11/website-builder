<?php
    include_once("core.php");
    $sid = $_GET["sid"];
    $template = $_GET["template"];

    $dir = "sites/$sid";
    if(file_exists($dir)) {
        echo("Site already exists!");
        die();
    }

    mkdir($dir);
    copyFiles("templates/$template", "sites/$sid");
    copyFiles("engine", "sites/$sid");
    header("location: index.php?sid=$sid");
?>