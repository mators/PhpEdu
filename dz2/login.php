<?php session_start();

require_once('../dz1/htmllib.php');
require_once('arraylib.php');
require_once('data.php');
require_once('const.php');

header('Content-Type: text/html; charset=utf-8');

$err = array();
$userInfo = array();

# Ako je korisnik vec ulogiran, preusmjeri.
if (($user = element("user", $_SESSION)) !== NULL) {
    $url = "http://$_SERVER[HTTP_HOST]/dz2";
    header("Location: ".$url);
    die();
}

# Ako je POST, validacija.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userInfo = elements($USER_KEYS, $_POST);

    if (!$userInfo["email"]) {
        $err["email"] = "E-mail je obavezan.";
    }

    if (!$userInfo["password"]) {
        $err["password"] = "Lozinka je obavezna.";
    } else {
        $userInfo["password"] = sha1($userInfo["password"]);
    }

    if (($user = find_user($userInfo)) === NULL) {
        $err["message"] = "Pogrešni e-mail ili lozinka.";
    }

    # Ako je sve OK, spremi u sjednicu i preusmjeri
    if (empty($err)) {

        $_SESSION["user"] = [
            "id" => $user["id"],
            "firstname" => $user["firstname"],
            "lastname" => $user["lastname"],
            "email" => $user["email"]
        ];

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

# Link na pocetnu
echo create_element("div", true, [ "contents" => [
    create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2",
        "contents" => "Početna stranica"
    ])
]]);

start_form("", "post");

# Email
echo create_element("p", true, [ "contents" => [
    "Email: ",
    create_input(["type" => "email", "name" => "email", "value" => element("email", $userInfo, "")/*, "required" => ""*/]),
    create_element("span", true, [ "style" => "color:red", "contents" => element("email", $err, "")])
]]);

# Lozinka
echo create_element("p", true, [ "contents" => [
    "Lozinka: ",
    create_input(["type" => "password", "name" => "password"/*, "required" => ""*/]),
    create_element("span", true, [ "style" => "color:red", "contents" => element("password", $err, "")])
]]);

echo create_input(["type" => "submit", "value" => "Prijava"]);

if (($errorMessage = element("message", $err)) !== NULL) {
    echo create_element("br", true, []);
    echo create_element("span", true, [ "style" => "color:red", "contents" => $errorMessage ]);
}

end_form();
end_body();
end_html();
