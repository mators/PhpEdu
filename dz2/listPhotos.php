<?php session_start();

require_once('../dz1/htmllib.php');
require_once('arraylib.php');
require_once('data.php');

header('Content-Type: text/html; charset=utf-8');

function create_photo_elements() {
    global $user;

    $elements = [];
    foreach (get_users_images($user["id"]) as $image) {
        array_push($elements, create_element("div", true, [ "contents" => [
            create_element("img", false, ["src" => "getPhoto.php?" . http_build_query([
                    "id" => $image["id"],
                    "size" => "small"
                ])
            ]),
            create_element("span", true, ["contents" => "NASLOV"])
        ]]));
    }
    return $elements;
}

# Ako korisnik nije ulogiran ili nije vlasnik ovih slika, preusmjeri.
$user = element("user", $_SESSION);
$userId = element("id", $_GET);
if ($user === NULL || $userId === NULL || $user["id"] !== $userId) {
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
echo create_element("div", true, [ "contents" => [
    create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2",
        "contents" => "Početna stranica"
    ]),
    " ",
    create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2/createGallery.php",
        "contents" => "Dodaj galeriju"
    ]),
    " ",
    create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2/photoUpload.php",
        "contents" => "Prijenos slika"
    ]),
    " ",
    create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2/listPhotos.php?id=".$user["id"],
        "contents" => "Pregled slika"
    ])
]]);

# Popis svih slika
echo create_element("div", true, [ "contents" => create_photo_elements()]);

end_body();
end_html();
