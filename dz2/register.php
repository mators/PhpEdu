<?php session_start();

require_once('../dz1/htmllib.php');
require_once('arraylib.php');
require_once('data.php');
require_once('const.php');

header('Content-Type: text/html; charset=utf-8');

# Ako je korisnik vec ulogiran, preusmjeri.
if (($user = element("user", $_SESSION)) !== NULL) {
    $url = "http://$_SERVER[HTTP_HOST]/dz2";
    header("Location: ".$url);
    die();
}

$err = array();
$newUser = array();

# Ako je POST, validacija.
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newUser = elements($USER_KEYS, $_POST);

    if (!$newUser["firstname"]) {
        $err["firstname"] = "Ime je obavezno.";
    }

    if (!$newUser["lastname"]) {
        $err["lastname"] = "Prezime je obavezno.";
    }

    if (!$newUser["email"]) {
        $err["email"] = "E-mail je obavezan.";
    }

    if (!$newUser["password"]) {
        $err["password"] = "Lozinka je obavezna.";
    } else {
        $newUser["password"] = sha1($newUser["password"]);
    }

    # Ako je sve OK, spremi novog korisnika i preusmjeri ga na login.
    if (empty($err)) {
        $newUser["id"] = increment_id("user_id");
        save_user($newUser);

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

# Link na pocetnu
echo create_element("div", true, [ "contents" => [
    create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2",
        "contents" => "Početna stranica"
    ])
]]);

start_form("", "post");

# Ime
echo create_element("p", true, [ "contents" => [
    "Ime: ",
    create_input(["type" => "text", "name" => "firstname", "value" => element("firstname", $newUser, "")/*, "required" => ""*/]),
    create_element("span", true, [ "style" => "color:red", "contents" => element("firstname", $err, "")])
]]);

# Prezime
echo create_element("p", true, [ "contents" => [
    "Prezime: ",
    create_input(["type" => "text", "name" => "lastname", "value" => element("lastname", $newUser, "")/*, "required" => ""*/]),
    create_element("span", true, [ "style" => "color:red", "contents" => element("lastname", $err, "")])
]]);

# Email
echo create_element("p", true, [ "contents" => [
    "Email: ",
    create_input(["type" => "email", "name" => "email", "value" => element("email", $newUser, "")/*, "required" => ""*/]),
    create_element("span", true, [ "style" => "color:red", "contents" => element("email", $err, "")])
]]);

# Lozinka
echo create_element("p", true, [ "contents" => [
    "Lozinka: ",
    create_input(["type" => "password", "name" => "password"/*, "required" => ""*/]),
    create_element("span", true, [ "style" => "color:red", "contents" => element("password", $err, "")])
]]);

echo create_input(["type" => "submit", "value" => "Registriraj se!"]);

end_form();
end_body();
end_html();
