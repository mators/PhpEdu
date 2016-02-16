<?php

require_once('const.php');

/**
 * Funkcija prima asocijativno polje i pretvara ga u string pogodan za
 * spremanje u .txt datoteke. Listom $keys se definira zeljeni redosljed
 * vrijednosti polja u izlaznom stringu. Funkcija ocekuje da svi kljucevi
 * u $keys postoje u polju $data.
 *
 * @param $data array Asocijativno polje koje se priprema za spremanje.
 * @param $keys array Lista kljuceva.
 * @return string String pogodan za spremanje u .txt.
 */
function my_serialize($data, $keys) {
    $ret = "";
    foreach ($keys as $key) {
        $ret .= $data[$key].";";
    }
    return substr($ret, 0, -1)."\n";
}

/**
 * Funkcija prima string u kojemu su atributi odvojeni znakom ; i pretvara ih
 * u asocijativno polje pogodno za rad u programu. Listom $keys se definiraju
 * zeljeni kljucevi. Funkcija ocekuje tocno onoliko kljuceva koliko atributa
 * postoji u stringu.
 *
 * @param $str string String koji se pretvara u polje.
 * @param $keys array Lista kljuceva.
 * @return array Polje pogodno za rad u programu.
 */
function my_deserialize($str, $keys) {
    $ret = [];
    $keyIndex = 0;
    foreach (explode(";", $str) as $item) {
        $ret[$keys[$keyIndex++]] = htmlspecialchars($item, ENT_QUOTES, "UTF-8");
    }
    return $ret;
}

/**
 * Cita id-eve iz datoteke, povecava onaj trazeni i vraca ga.
 *
 * @param $idName string Id name.
 * @return int id.
 */
function increment_id($idName) {
    $ids = [];
    $lines = file_get_contents('data/ids.txt');

    foreach (explode("\n", $lines) as $line) {
        $exploded = explode("=", $line);
        $ids[$exploded[0]] = intval($exploded[1]);
    }
    $retId = ++$ids[$idName];

    # Spremi promjenu u datoteku
    $newIDs = "";
    foreach ($ids as $id_name => $id) {
        $newIDs .= $id_name."=".$id."\n";
    }
    file_put_contents('data/ids.txt', substr($newIDs, 0, -1));

    return $retId;
}

/**
 * Vraca korisnika sa emailom i lozinkom definiranim u $userInfo ili NULL ako takav korisnik ne postoji.
 *
 * @param $userInfo array oblika ['email' => '...', 'password' => '...' ]
 * @return array|null dohvaceni korisnik iz korisnici.txt ili null.
 */
function find_user($userInfo) {
    global $USER_KEYS;

    $lines = file_get_contents('data/korisnici.txt');
    foreach (explode("\n", $lines) as $line) {
        if (!empty($line)) {
            $user = my_deserialize($line, $USER_KEYS);
            if ($user["email"] === $userInfo["email"] &&
                $user["password"] === $userInfo["password"]) {

                return $user;
            }
        }
    }
    return NULL;
}

/**
 * Dohvaca sve galerije korisnika s id-em $userId.
 *
 * @param $userId string id korisnika cije galerije se dohvacaju.
 * @return array Korisnikove galerije.
 */
function get_users_galleries($userId) {
    global $GALLERY_KEYS;

    $galleries = [];
    $lines = file_get_contents('data/galerije.txt');
    foreach (explode("\n", $lines) as $line) {
        if (!empty($line)) {
            $gallery = my_deserialize($line, $GALLERY_KEYS);
            if ($gallery["userId"] == $userId) {
                array_push($galleries, $gallery);
            }
        }
    }
    return $galleries;
}