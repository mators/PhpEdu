<?php

require_once('../dz1/htmllib.php');
require_once('arraylib.php');
require_once('serializator.php');
require_once('const.php');

header('Content-Type: text/html; charset=utf-8');

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
        file_put_contents("data/korisnici.txt", my_serialize($newUser, $USER_KEYS), FILE_APPEND | LOCK_EX);

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
start_form("", "post");

# Ime
echo create_element("p", true, [ "contents" => [
    "Ime: ",
    create_input(["type" => "text", "name" => "firstname", "value" => $newUser["firstname"]/*, "required" => ""*/]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["firstname"]])
]]);

# Prezime
echo create_element("p", true, [ "contents" => [
    "Prezime: ",
    create_input(["type" => "text", "name" => "lastname", "value" => $newUser["lastname"]/*, "required" => ""*/]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["lastname"]])
]]);

# Email
echo create_element("p", true, [ "contents" => [
    "Email: ",
    create_input(["type" => "email", "name" => "email", "value" => $newUser["email"]/*, "required" => ""*/]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["email"]])
]]);

# Lozinka
echo create_element("p", true, [ "contents" => [
    "Lozinka: ",
    create_input(["type" => "password", "name" => "password"/*, "required" => ""*/]),
    create_element("span", true, [ "style" => "color:red", "contents" => $err["password"]])
]]);

echo create_input(["type" => "submit", "value" => "Registriraj se!"]);

end_form();
end_body();
end_html();
