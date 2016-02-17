<?php

require_once('../dz1/htmllib.php');
require_once('data.php');

/**
 * Stvara URL-ove za navigaciju po stranici za korisnika sa id-em $userID.
 *
 * @param $userID string Id korisnika za kojeg se stvara navigacija.
 * @return string HTML kod navigacije.
 */
function create_navigation($userID) {
    return create_element("div", true, [ "contents" => [
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
            "href" => "http://$_SERVER[HTTP_HOST]/dz2/listPhotos.php?id=".$userID,
            "contents" => "Pregled slika"
        ])
    ]]);
}

/**
 * Stvara <option value='id galerije'>ime galerije</option>
 * elemente za svaku galeriju korisnika sa id-em $userID i vraca ih.
 *
 * @param $userID string Id korisnika za cije galerije se stvaraju elementi.
 * @return array Lista galerija trenutnog korisnika u html tagu option.
 */
function create_dropdown_options($userID) {
    $options = [];
    foreach (get_users_galleries($userID) as $gallery) {
        array_push($options, create_element("option", true, [
            "value" => $gallery["id"],
            "contents" => $gallery["title"]
        ]));
    }
    return $options;
}

/**
 * Stvara html element sa imenom i rezimenom korisnika $user i linkom za logout.
 *
 * @param $user array Korisnik.
 * @return string HTML element.
 */
function create_current_user($user) {
    return create_element("div", true, [ "contents" => [
        $user["firstname"]." ".$user["lastname"]." ",

        create_element("a", true, [
            "href" => "http://$_SERVER[HTTP_HOST]/dz2/logout.php",
            "contents" => "Logout"
        ])
    ]]);
}