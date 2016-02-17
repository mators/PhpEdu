<?php session_start();

require_once('../dz1/htmllib.php');
require_once('arraylib.php');
require_once('data.php');
require_once('commonHTML.php');

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

$err = array();

# Ako je POST, validacija slike.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $image = elements($PHOTO_KEYS, $_POST);

    if ($image["title"]) {
        if (strlen($image["title"]) > 100) {
            $err["title"] = "Ime slike smije imati najviše 100 znakova.";
        }
    } else {
        $err["title"] = "Ime slike je obavezno.";
    }

    if ($image["description"] && strlen($image["title"]) > 500) {
        $err["description"] = "Opis slike smije imati najviše 500 znakova.";
    }

    if (!$image["galleryId"]) {
        $err["gallery"] = "Potrebno je odabrati galeriju.";
    }

    # Ako je sve OK, uredi sliku i preusmjeri.
    if (empty($err)) {

        # Uredi zapis u slike.txt
        $image["id"] = $photoID;
        $image["userId"] = $user["id"];
        edit_image($image);

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

start_form("", "post");

# Ime
echo create_element("p", true, [ "contents" => [
    "Ime slike: ",
    create_input(["type" => "text", "name" => "title", "maxlength" => "100", "value" => $image["title"]]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["title"]])
]]);

# Opis
echo create_element("p", true, [ "contents" => [
    "Opis: ",
    create_element("textarea", true, [ "name" => "description", "maxlength" => "500", "contents" => $image["description"]]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["description"]])
]]);

# Galerija
echo create_element("p", true, [ "contents" => [
    "Galerija: ",
    create_select([ "name" => "galleryId", "contents" => create_dropdown_options($user["id"])]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["gallery"]])
]]);

echo create_input(["type" => "submit", "value" => "Uredi sliku"]);

end_form();

echo create_element("img", false, [
    "style" => "float: left",
    "src" => "getPhoto.php?" . http_build_query([
        "id" => $photoID,
        "size" => "original"
    ])
]);

echo create_element("a", true, [
    "style" => "float: left",
    "href" => "http://$_SERVER[HTTP_HOST]/dz2/deletePhoto.php?id=".$photoID,
    "contents" => "Obriši sliku"
]);

end_body();
end_html();
