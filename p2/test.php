<?php
require_once('../dz1/htmllib.php');

echo "hello world!<br/>";

// Ja sam komentar u jednoj liniji
# Ja sam također komentar u jednoj liniji
/* Ja se mogu
protezati kroz više
linija */

//for($i = 0; $i < 10; $i++) {
//    echo $i;
//}
//var_dump(substr("3}:=odgovor", 3));

var_export(explode(";", html_entity_decode("5;&lt;h1&gt;opasni&lt;/h1&gt;;&lt;h1&gt;korisnik&lt;/h1&gt;;e@mail;d6f5df8bf0347b185908397be91c44fd006c2b07")));

//session_start();
//if (!empty($_GET)) {
//    $_SESSION = array_merge($_SESSION, $_GET);
//}
//var_dump($_SESSION);
