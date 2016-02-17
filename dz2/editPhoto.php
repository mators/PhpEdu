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

echo create_element("img", false, ["src" => "getPhoto.php?" .
    http_build_query([
        "id" => $image["id"],
        "size" => "original"
    ])
]);

end_body();
end_html();
