<?php

/**
 * Uvijek ispisuje sadrˇzaj "<!doctype html>" i koristi se kao prva naredba * kod stvaranj dokumenta.
 */
function create_doctype() {
    echo "<!doctype html>";
}

/**
 * Ispisuje otvarajuci tag <html>
 */
function begin_html() {
    echo "<html>";
}

/**
 * Ispisuje zatvarajuci tag </html>
 */
function end_html() {
    echo "</html>";
}

/**
 * Ispisuje otvarajuci tag <head>
 */
function begin_head() {
    echo "<head>";
}

/**
 * Ispisuje zatvarajuci tag </head>
 */
function end_head() {
    echo "</head>";
}

/**
 * Ispisuje otvarajuci tag <body> te mu pridruzuje parove (atribut, vrijednost) na
 * temelju polja predanih parametara. Parove (atribut, vrijednost) potrebno je umetnuti u
 * tag na valjan nacin: nazivAtributa="vrijednostAtributa".
 *
 * @param {array} $params asocijativno polje parova atribut=>vrijednost
 */

function begin_body($params) {
    echo "<body ";
    foreach ($params as $k => $v) {
        echo $k . "=\"" . $v . "\" ";
    }
    echo ">";
}

/**
 * Ispisuje zatvarajuci tag </body>
 */
function end_body() {
    echo "</body>";
}

/**
 * Generira tag <form> i dodjeljuje mu atribute action i method s vrijednostima koje
 * ovise o predanim parametrima
 *
 * @param {String} $action relativna ili apsolutna putanja do skrtipte za obradu obrasca
 * @param {String} $method GET ili POST
 * @param bool $upload ako je forma za upload datoteke, stavi true
 */
function start_form($action, $method, $upload = false) {
    echo "<form action=\"" . $action . "\" method=\"" . $method . "\" ";
    if ($upload) {
        echo 'enctype="multipart/form-data" ';
    }
    echo ">";
}

/**
 * Ispisuje zatvarajuci tag </form>
 */
function end_form() {
    echo "</form>";
}

/**
 * Stvara polje za unos teksta pri cemu su atributi i njihove vrijednosti odredjene predanim 2D
 * poljem parametara.
 * Struktura polja parametara:
 * array(’atribut’ => ’vrijednost1’, ’atribut2’ => ’vrijednost2’, ..., ’atributN’ => ’vrijednostN’).
 *
 * @param {array} $params asocijativno polje parova oblika atribut=>vrijednost
 * @return {String} niz znakova koji predstavlja generirani input tag
 */
function create_input($params) {
    return create_element("input", false, $params);
}

/**
 * Generira padajuci izbornik odredjen elementom select. Predani parametri odredjuju atribute
 * izbornika (npr. name) te opcije koje izbornik treba sadrzavati, a one se predaju u preko
 * kljuca ’contents’.
 * Polje ima sljedeci format:
 * array(
 * ’kljuc1’ => ’vrijednost1’,
 * ...
 * ’kljucN’ => ’vrijednostN’
 * ’contents’ => array(’option1’, ’option2’, ..., ’optionM’)
 *)
 * Parametar contents odredjuje 1D polje i da je svaki element niz znakova. No, elementi
 * nisu vrijednosti koje treba ispisati kao opcije, nego <b>HTML k^od</b> koji definira svaku od
 * opcija, npr. ’<option>1</option>’
 *
 * @param {array} $params polje parametara koje odredjuje padajuci izbornik
 * @return {String} znakova koji predstavlja generirani select tag
 */
function create_select($params) {
    return create_element("select", true, $params);
}

/**
 * Stvara element button pomocu predanih parametara i vraca generirani niz tag. Sadrzaj
 * gumba odredjuje parametar contents. Ako je njegova vrijednost jednaka praznom nizu znakova
 * ili uopce nije poslan, sadrzaj treba biti prazan.
 * @params {array} $params polje parametara koje odredjuje dugme
 * @return niz znakova koji predstavlja generirani tag button
 */
function create_button($params) {
    return create_element("button", true, $params);
}


/**
 * Ispisuje otvarajuci tag <table>. Polje parametara odredjuje atribute tablice i
 * vrijednosti atributa.
 *
 * @param {array} $params polje parametara spremljenih po principu ’atribut’ => ’vrijednost’
 */
function create_table($params) {
    echo "<table ";
    foreach ($params as $k => $v) {
        echo $k . "=\"" . $v . "\" ";
    }
    echo ">";
}

/**
 * Ispisuje zatvarajuci tag </table>
 */
function end_table() {
    echo "</table>";
}

/**
 * Generira HTML potreban za stvaranje jednog retka tablice. U polju parametara koje
 * prima moraju biti definirane i celije tablice i to parametrom ’contents’.
 * Polje ima sljedeci format:
 * array(
 * ’atribut1’ => ’vrijednost1’,
 * ...
 * ’atributN’ => ’vrijednostN’,
 * ’contents’ => array(’cell1’, ’cell2’, ..., ’cellM’)
 *)
 * Parametar contents odredjuje 1D polje i svaki element je niz znakova. No, elementi
 * nisu vrijednosti koje treba ispisati u celijama, nego <b>HTML k^od</b> koji definira
 * svaku od celija, npr. ’<td>celija</td>’. Prazan redak generira se u slucaju da je
 * parametar contents postavljen na prazan niz znakova ili da uopce nije poslan.
 *
 * @param {array} $params polje parametara koje odredjuje jedan redak tablice
 * @return {String} znakova koji predstavlja HTML k^od retka tablice
 */
function create_table_row($params) {
    return create_element("tr", true, $params);
}

/**
 * Na temelju predanih parametara koji odredjuju atribute i vrijednosti generira HTML k^od
 * celije. Polje je oblika:
 * array(’atribut’ => ’vrijednost1’, ’atribut2’ => ’vrijednost2’, ..., ’atributN’ => ’vrijednostN’).
 * Sadrzaj celije odredjen je parametrom ’contents’. Ako tog parametra nema ili je jednak praznom
 * nizu znakova, potrebno je generirati praznu celiju:
 * <td atribut1="vrijednost1" ... atributN="vrijednostN"></td>
 *
 * @param {array} $params polje parametara koje odredjuje celiju
 * @return {String} znakova koji odredjuje HTML k^od celije
 */
function create_table_cell($params) {
    return create_element("td", true, $params);
}

/**
 * Na temelju predanih parametara koji odredjuju atribute, naziva elementa i zastavice koja
 * odredjuje ima li otvarajuci tag pripadajuci zatvarajuci tag generira HTML k^od proizvoljnog
 * elementa. Polje parametara je oblika
 * array(’atribut’ => ’vrijednost1’, ’atribut2’ => ’vrijednost2’, ..., ’atributN’ => ’vrijednostN’).
 * Ako sadrˇzaj elementa treba biti prazan ili element uopce nije definirat tako da treba
 * imati sadrzja, potrebno je ili postaviti parametar ’contents’ na prazan niz znakova ili
 * ga uopce ne poslati.
 *
 * @param {String} $name naziv elementa
 * @param {boolean} true ako ima zatvarajuci tag, false inace
 * @param {array} $params polje parametara koje odredjuje celiju
 * @return {String} znakova jednak HTML k^odu elementa
 */
function create_element($name, $closed = true, $params) {
    $cont = $params["contents"];

    if (is_array($cont)) {
        $cont = implode("", $cont);
    }

    $ret = "<" . $name . " ";

    foreach ($params as $k => $v) {
        if ($k !== "contents") {
            $ret .= $k . "=\"" . $v . "\" ";
        }
    }

    return $ret . ">" . ($cont ?: "") . ($closed ? "</" . $name . ">" : "");
}
