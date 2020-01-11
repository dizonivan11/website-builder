<?php
    echo "<div>";
    echo "  <button data-parent='$inputName-$inputProperty' class='richTextButton fa fa-bold' onclick='document.execCommand(\"bold\")'></button>";
    echo "  <button data-parent='$inputName-$inputProperty' class='richTextButton fa fa-italic' onclick='document.execCommand(\"italic\")'></button>";
    echo "  <button data-parent='$inputName-$inputProperty' class='richTextButton fa fa-underline' onclick='document.execCommand(\"underline\")'></button>";
    echo "  <button data-parent='$inputName-$inputProperty' class='richTextButton fa fa-link' onclick='ShowAddLinkDialog(this)'></button>";
    echo "</div>";
    echo "<div id='$inputName-$inputProperty' contenteditable='true' class='richTextEditor'></div>";
?>