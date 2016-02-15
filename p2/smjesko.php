<?php

function generateImgTag($src, $alt, $dim = null)
{
    if (null == $src || !filter_var($src, FILTER_VALIDATE_URL)) {
        return "Error: Source URL not valid.\n";
    }

    $tag = "<img src=\"" . $src . "\"alt=\"" . $alt ."\"";

    //if dim null
    if (null == $dim || count($dim) !== 2) {
        return $tag . ">";
    }

    //if set w and h
    if (isset($dim["w"]) && isset($dim["h"])) {
        return $tag . " width=\"" . $dim["w"] ."\"height=\"" . $dim["h"] ."\">";
    }

    return $tag . ">";
}

if ($_POST["text"]) {
    //original string
    //$string = ":) A <B> C :)";

    $string = htmlentities($_POST["text"]);

    //smile icon
    $smileIcon = "http://simpleicon.com/wp-content/uploads/smile-256x256.png";
    $htmlSmileIcon = generateImgTag($smileIcon, "Smiley face", ["w" => 42, "h" => 42]);
    $string = str_replace(":)", $htmlSmileIcon, $string);

    echo $string;
}

?>

<html>
    <body>

        <form action = "<?php $_PHP_SELF ?>" method = "POST">
            Tekst: <input type = "textarea" name = "text" />
            <input type = "submit" />
        </form>

    </body>
</html>

