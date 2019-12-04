<?php
    $fileContent = $_POST["fileContent"];
    $filePath = $_POST["filePath"];
    file_put_contents($filePath, $fileContent);
?>