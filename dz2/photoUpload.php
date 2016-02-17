<?php session_start();

require_once('../dz1/htmllib.php');
require_once('arraylib.php');
require_once('data.php');
require_once('commonHTML.php');

header('Content-Type: text/html; charset=utf-8');

/**
 * Mijenja velicinu slike $imageSource na $newWidth x $newHeight i takvu ju sprema pod imenom $imageName.
 * Sve slike sprema kao .jpg
 *
 * @param $newWidth
 * @param $newHeight
 * @param $oldWidth
 * @param $oldHeight
 * @param $imageSource
 * @param $imageName
 */
function save_resized_image_copy($newWidth, $newHeight, $oldWidth, $oldHeight, $imageSource, $imageName) {
    $imageDest = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresized($imageDest, $imageSource, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight);
    imagejpeg($imageDest, $imageName);
    imagedestroy($imageDest);
}

# Ako korisnik nije ulogiran, preusmjeri.
if (($user = element("user", $_SESSION)) === NULL) {
    $url = "http://$_SERVER[HTTP_HOST]/dz2";
    header("Location: ".$url);
    die();
}

$err = array();
$formData = array();
$file = array();

# Ako je POST, validacija slike.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $formData = elements($PHOTO_KEYS, $_POST);
    $file = elements($FILE_KEYS, $_FILES["file"]);

    if ($formData["title"]) {
        if (strlen($formData["title"]) > 100) {
            $err["title"] = "Naslov slike smije imati najviše 100 znakova.";
        }
    } else {
        $formData["title"] = $file["name"];
    }

    if ($formData["description"] && strlen($formData["title"]) > 500) {
        $err["description"] = "Opis slike smije imati najviše 500 znakova.";
    }

    if (!$formData["galleryId"]) {
        $err["gallery"] = "Potrebno je odabrati galeriju.";
    }

    if ($file["error"] > 0) {
        $err["file"] = "Pogreška pri učitavanju slike.";
    } else {

        if (!in_array(strtolower($file["type"]), $ALLOWED_FILE_TYPES)) {
            $err["file"] = "Nedopušteni format.";
        } else {

            if ($file["size"] > 512000) {
                $err["file"] = "Slika ne smije biti veća od 500kB.";
            }

            list($width, $height) = getimagesize($file['tmp_name']);

            if ($width < $MEDIUM || $height < $MEDIUM) {
                $err["file"] = "Slika ne smije biti manja od 128x128.";
            }
        }
    }

    # Ako je sve OK, spremi sliku i preusmjeri.
    if (empty($err)) {
        $photoId = increment_id("photo_id");
        $dim = getimagesize($file['tmp_name']);

        switch(strtolower($dim['mime']))
        {
            case 'image/png':
                $imageSource = imagecreatefrompng($file['tmp_name']);
                break;
            case 'image/jpeg':
                $imageSource = imagecreatefromjpeg($file['tmp_name']);
                break;
            case 'image/gif':
                $imageSource = imagecreatefromgif($file['tmp_name']);
                break;
            default: die();
        }

        # Small
        save_resized_image_copy($SMALL, $SMALL, $dim[0], $dim[1], $imageSource, "images/".$photoId."_small.jpg");

        # Medium
        if ($dim[0] > $MEDIUM || $dim[1] > $MEDIUM) {
            save_resized_image_copy($MEDIUM, $MEDIUM, $dim[0], $dim[1], $imageSource, "images/".$photoId."_medium.jpg");
        }

        # Large
        if ($dim[0] > $LARGE || $dim[1] > $LARGE) {
            save_resized_image_copy($LARGE, $LARGE, $dim[0], $dim[1], $imageSource, "images/".$photoId."_large.jpg");
        }

        # Original
        save_resized_image_copy($dim[0], $dim[1], $dim[0], $dim[1], $imageSource, "images/".$photoId."_original.jpg");
        unlink($file['tmp_name']);

        # Dodaj zapis u slike.txt
        $formData["id"] = $photoId;
        $formData["userId"] = $user["id"];
        save_image($formData);

        # Redirect
        $url = "http://$_SERVER[HTTP_HOST]/dz2/listPhotos.php?id=".$user["id"];
        header("Location: ".$url);
        die();
    }
}

create_doctype();
begin_html();
begin_head();
end_head();
begin_body([]);

# Trenutni korisnik
echo create_current_user($user);

# Navigacija
echo create_navigation($user["id"]);

start_form("", "post", true);

# Ime
echo create_element("p", true, [ "contents" => [
    "Ime slike: ",
    create_input(["type" => "text", "name" => "title", "maxlength" => "100", "value" => $formData["title"]]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["title"]])
]]);

# Opis
echo create_element("p", true, [ "contents" => [
    "Opis: ",
    create_element("textarea", true, [ "name" => "description", "maxlength" => "500", "contents" => $formData["description"]]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["description"]])
]]);

# Galerija
echo create_element("p", true, [ "contents" => [
    "Galerija: ",
    create_select([ "name" => "galleryId", "contents" => create_dropdown_options($user["id"])]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["gallery"]])
]]);

# Slika
echo create_element("p", true, [ "contents" => [
    "Slika: ",
    create_input(["type" => "file", "name" => "file"]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["file"]])
]]);

echo create_input(["type" => "submit", "value" => "Pošalji sliku"]);

end_form();
end_body();
end_html();
