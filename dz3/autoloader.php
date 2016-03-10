<?php


spl_autoload_register(function($className) {

    $file = __DIR__ . "/" . implode("/", array_slice(explode("\\", $className), -2, 2)) . ".php";

    if (!is_readable($file)) {
        return false;
    }
    require_once($file);
    return true;
});
