<?php

//husky, medvjedi, ptica, riba, vjeverica
if (isset($_GET["name"])) {
    header("Content-type: image/jpg");
    $path = "./images/" . $_GET["name"] . ".jpg";
    header("Content-length: " . filesize($path));
    readfile($path);
    exit;
}

