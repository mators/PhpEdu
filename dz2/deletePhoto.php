<?php session_start();

require_once('arraylib.php');
require_once('data.php');

header('Content-Type: text/html; charset=utf-8');

# Ako korisnik nije ulogiran ili slika nije njegova, preusmjeri.
$user = element("user", $_SESSION);
$photoID = element("id", $_GET);
$image = get_image($photoID);
if ($user === NULL || $photoID === NULL || $user["id"] !== $image["userId"]) {
    $url = "http://$_SERVER[HTTP_HOST]/dz2";
    header("Location: ".$url);
    die();
}

# Izbrisi iz slike.txt
edit_image($image, true);

# Izbrisi sa servera
unlink("images/".$photoID."_small.jpg");
unlink("images/".$photoID."_medium.jpg");
unlink("images/".$photoID."_large.jpg");
unlink("images/".$photoID."_original.jpg");

# Preusmjeri
$url = "http://$_SERVER[HTTP_HOST]/dz2/listPhotos.php?id=".$user["id"];
header("Location: ".$url);
die();