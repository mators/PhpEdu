<?php

/**
 * Funkcija pokusava u polju predanom putem drugog parametra pronaci
 * kljuc naziva $key. Ako takav element postoji, vratit ce njegovu
 * vrijednost, a ako ne postoji, vratit ce vrijednost definiranu
 * trecim parametrom, koji nije nuzno poslan funkciji.
 *
 * @param $needle string            naziv kljuca koji se trazi u polju
 * @param $haystack array           polje u kojem se trazi kljuc
 * @param $default mixed            vrijednost koja ce biti vracena ako kljuc nije pronadjen
 * @return mixed                    vrijednost elementa pod kljucem $needle ako kljuc postoji, inace $default
 */
function element($needle, $haystack, $default = NULL) {
    return array_key_exists($needle, $haystack) ? $haystack[$needle] : $default;
}

/**
 * Funkcija provjerava postoje li u polju $haystack kljucevi koji su navedeni
 * u polju $needles. Stvara se novo polje ciji su kljucevi jednaki predanim
 * kljucevima, a vrijednosti koje ti kljucevi indeksiraju u novom polju jednake
 * su vrijednostima iz polja $haystack. Ako u polju $haystack nije postojao neki
 * kljuc, onda on svejedno postoji u novom polju, ali vrijednost koju indeksira
 * jednaka je $default.
 *
 * @param $needles array
 * @param $haystack array
 * @param null $default mixed
 * @return array
 */
function elements($needles, $haystack, $default = NULL) {
    $ret = [];
    foreach ($needles as $needle) {
        $ret[$needle] = element($needle, $haystack, $default);
    }
    return $ret;
}

function __($s) {
    return htmlentities($s, ENT_QUOTES, "utf-8");
}

function redirect($url) {
    header("Location: " . $url);
    die();
}

function isLoggedIn() {
    return array_key_exists("user", $_SESSION);
}

function isCurrentUser($username) {
    return user()["username"] == $username;
}

function isPost() {
    return count($_POST) > 0;
}

/**
 * @param $key
 * @param string $d
 * @return mixed
 */
function post($key, $d = "") {
    return element($key, $_POST, $d);
}

function get($key, $d = null) {
    return element($key, $_GET, $d);
}

function user() {
    return element("user", $_SESSION, [
        "username" => "",
        "id" => "",
        "email" => ""
    ]);
}

function stringFromImageInfo($file) {
    if (empty($file["tmp_name"])) {
        return "";
    }
    $dim = getimagesize($file['tmp_name']);

    switch(strtolower($dim['mime']))
    {
        case 'image/png':
            $image = imagecreatefrompng($file['tmp_name']);
            break;
        case 'image/jpeg':
            $image = imagecreatefromjpeg($file['tmp_name']);
            break;
        case 'image/gif':
            $image = imagecreatefromgif($file['tmp_name']);
            break;
        default: die();
    }

    ob_start();
    imagepng($image);
    $contents =  ob_get_contents();
    ob_end_clean();
    return base64_encode($contents);
}