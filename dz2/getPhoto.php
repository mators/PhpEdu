<?php session_start();

if (isset($_GET["id"]) && isset($_GET["size"])) {
    header("Content-type: image/jpeg");
    $path = "images/".$_GET["id"]."_".$_GET["size"].".jpg";
    header("Content-length: ".filesize($path));
    readfile($path);
    die();
}
