<?php session_start();

require_once('../dz1/htmllib.php');
require_once('arraylib.php');
require_once('data.php');
require_once('const.php');
require_once('commonHTML.php');

header('Content-Type: text/html; charset=utf-8');

# Ako korisnik nije ulogiran, preusmjeri.
if (($user = element("user", $_SESSION)) === NULL) {
    $url = "http://$_SERVER[HTTP_HOST]/dz2";
    header("Location: ".$url);
    die();
}

$err = array();
$newGallery = array();

# Ako je POST, validacija.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newGallery = elements($GALLERY_KEYS, $_POST);

    if (!$newGallery["title"]) {
        $err["title"] = "Ime galerije je obavezno.";
    } else if (strlen($newGallery["title"]) > 100) {
        $err["title"] = "Ime galerije ne smije imati preko 100 znakova.";
    }

    if ($newGallery["description"] && strlen($newGallery["description"]) > 500) {
        $err["description"] = "Opis galerije smije imati najviše 500 znakova.";
    }

    # Ako je sve OK, spremi novu galeriju i preusmjeri.
    if (empty($err)) {
        $newGallery["id"] = increment_id("gallery_id");
        $newGallery["userId"] = $user["id"];
        file_put_contents("data/galerije.txt", my_serialize($newGallery, $GALLERY_KEYS), FILE_APPEND | LOCK_EX);

        $url = "http://$_SERVER[HTTP_HOST]/dz2";
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
echo create_element("div", true, [ "contents" => [
    $user["firstname"]." ".$user["lastname"]." ",

    create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2/logout.php",
        "contents" => "Logout"
    ])
]]);

# Navigacija
echo create_navigation($user["id"]);

start_form("", "post");

# Ime
echo create_element("p", true, [ "contents" => [
    "Ime galerije: ",
    create_input(["type" => "text", "name" => "title", "maxlength" => "100", "value" => $formData["title"]]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["title"]])
]]);

# Opis
echo create_element("p", true, [ "contents" => [
    "Opis: ",
    create_element("textarea", true, [ "name" => "description", "maxlength" => "500", "value" => $formData["description"]]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["description"]])
]]);

echo create_input(["type" => "submit", "value" => "Stvori galeriju"]);

end_form();
end_body();
end_html();
