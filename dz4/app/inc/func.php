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
 * @param $needles array            1D polje koje sadrˇzi popis kljuceva koji se traze
 * @param $haystack array           polje u kojem se traze predani kljucevi
 * @param $default mixed            vrijednost elementa ako kljuc ne postoji
 * @return array                    novo polje s kljucevima $needles
 */
function elements($needles, $haystack, $default = NULL) {
    $ret = [];
    foreach ($needles as $needle) {
        $ret[$needle] = element($needle, $haystack, $default);
    }
    return $ret;
}

function redirect($url) {
    header("Location: " . $url);
    die();
}

function isLoggedIn() {
    return false;
}