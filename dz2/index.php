<?php session_start();

require_once('../dz1/htmllib.php');
require_once('arraylib.php');

header('Content-Type: text/html; charset=utf-8');

create_doctype();
begin_html();
begin_head();
end_head();
begin_body([]);

if (($user = element("user", $_SESSION)) !== NULL) {

    echo "POZDRAV ".$user["firstname"]." ".$user["lastname"];

    echo create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2/logout.php",
        "contents" => "Logout "
    ]);

} else {

    echo create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2/register.php",
        "contents" => "Registracija "
    ]);

    echo create_element("a", true, [
        "href" => "http://$_SERVER[HTTP_HOST]/dz2/login.php",
        "contents" => "Login"
    ]);
}

end_body();
end_html();
