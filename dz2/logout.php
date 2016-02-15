<?php session_start();

unset($_SESSION["user"]);
$url = "http://$_SERVER[HTTP_HOST]/dz2";
header("Location: ".$url);
die();
