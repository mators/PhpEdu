<?php session_start();

require_once('../dz1/htmllib.php');
require_once('arraylib.php');
require_once('data.php');
require_once('commonHTML.php');

header('Content-Type: text/html; charset=utf-8');

function create_photo_elements() {
    global $user;

    $elements = [];
    foreach (get_users_images($user["id"]) as $image) {
        array_push($elements, create_table_row([ "contents" => [

            create_table_cell(["contents" =>
                create_element("img", false, ["src" => "getPhoto.php?" . http_build_query([
                    "id" => $image["id"],
                    "size" => "small"
                ])
            ])]),

            create_table_cell(["contents" => [

                create_element("b", true, ["contents" => "Ime slike: "]),
                $image["title"],
                create_element("br", false, []),

                create_element("b", true, ["contents" => "Ime galerije: "]),
                get_gallery($image["galleryId"])["title"],
                create_element("br", false, []),

                create_element("a", true, [
                    "href" => "http://$_SERVER[HTTP_HOST]/dz2/editPhoto.php?id=".$image["id"],
                    "contents" => "Uredi sliku"
                ])
            ]])

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
echo create_navigation($user["id"]);

# Popis svih slika
echo create_element("table", true, [ "contents" => create_photo_elements()]);

end_body();
end_html();
