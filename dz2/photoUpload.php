<?php session_start();

require_once('../dz1/htmllib.php');
require_once('arraylib.php');
require_once('data.php');

header('Content-Type: text/html; charset=utf-8');

/**
 * Stvara <option value='id galerije'>ime galerije</option>
 * elemente za svaku galeriju ternutno ulogiranog korisnika i vraca ih.
 *
 * @return array Lista galerija trenutnog korisnika u html tagu option.
 */
function create_dropdown_options() {
    global $user;

    $options = [];
    foreach (get_users_galleries($user["id"]) as $gallery) {
        array_push($options, create_element("option", true, [
            "value" => $gallery["id"],
            "contents" => $gallery["title"]
        ]));
    }
    return $options;
}

/**
 * Mijenja velicinu slike $imageSource na $newWidth x $newHeight i takvu ju sprema pod imenom $imageName.
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

    if ($file["error"] > 0) {
        $err["file"] = "Pogreška pri učitavanju slike.";
    } else {

        if ($file["size"] > 512000) {
            $err["file"] = "Slika ne smije biti veća od 500kB.";
        }

        if (!in_array($file["type"], $ALLOWED_FILE_TYPES)) {
            $err["file"] = "Nedopušteni format.";
        }

        list($width, $height) = getimagesize($file['tmp_name']);

        if ($width < $MEDIUM || $height < $MEDIUM) {
            $err["file"] = "Slika ne smije biti manja od 128x128.";
        }
    }

    # Ako je sve OK, spremi sliku i preusmjeri.
    if (empty($err)) {
        $photoId = increment_id("photo_id");
        $extension = end(explode(".", $file["name"]));
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
        save_resized_image_copy($SMALL, $SMALL, $dim[0], $dim[1], $imageSource, "images/".$photoId."_small.".$extension);

        # Medium
        if ($dim[0] > $MEDIUM || $dim[1] > $MEDIUM) {
            save_resized_image_copy($MEDIUM, $MEDIUM, $dim[0], $dim[1], $imageSource, "images/".$photoId."_medium.".$extension);
        }

        # Large
        if ($dim[0] > $LARGE || $dim[1] > $LARGE) {
            save_resized_image_copy($LARGE, $LARGE, $dim[0], $dim[1], $imageSource, "images/".$photoId."_large.".$extension);
        }

        # Original
        move_uploaded_file($file['tmp_name'], "images/".$photoId."_original.".$extension);

        # Dodaj zapis u slike.txt
        $formData["id"] = $photoId;
        $formData["userId"] = $user["id"];
        file_put_contents("data/slike.txt", my_serialize($formData, $PHOTO_KEYS), FILE_APPEND | LOCK_EX);

        # Redirect
        $url = "http://$_SERVER[HTTP_HOST]/dz2/login.php";
        header("Location: ".$url);
        die();
    }
}

create_doctype();
begin_html();
begin_head();
end_head();
begin_body([]);
start_form("", "post", true);

# Trenutni korisnik
echo create_element("div", true, [ "contents" => [
    $user["firstname"]." ".$user["lastname"]." ",

    create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2/logout.php",
        "contents" => "Logout"
    ])
]]);

# Link na pocetnu
echo create_element("div", true, [ "contents" => [
    create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2",
        "contents" => "Početna stranica"
    ]),
    " ",
    create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2/photoUpload.php",
        "contents" => "Prijenos slika"
    ])
]]);

# Naslov
echo create_element("p", true, [ "contents" => [
    "Naslov: ",
    create_input(["type" => "text", "name" => "title", "maxlength" => "100", "value" => $formData["title"]]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["title"]])
]]);

# Opis
echo create_element("p", true, [ "contents" => [
    "Opis: ",
    create_element("textarea", true, [ "name" => "description", "maxlength" => "500", "value" => $formData["description"]]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["description"]])
]]);

# Galerija
echo create_element("p", true, [ "contents" => [
    "Galerija: ",
    create_select([ "name" => "galleryId", "contents" => create_dropdown_options()]),
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
