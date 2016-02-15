<?php

function parse_question($str, $id) {
    $q = ["id" => $id];
    $splitted = explode("{", $str);

    $q["question"] = $splitted[0];

    $type = $splitted[1][0];
    if ($type === "1") {
        $q["type"] = "radio";
    } else if ($type === "2") {
        $q["type"] = "checkbox";
    } else {
        $q["type"] = "text";
    }

    $splitted = explode("=", substr($splitted[1], 3));

    $q["answers"] = explode(",", $splitted[0]);
    $q["correct"] = explode(",", $splitted[1]);

    return $q;
}

function parse_questions($filename) {
    $ret = [];
    $count = 1;
    $lines = explode("\n", file_get_contents($filename));
    foreach ($lines as $line) {
        if (empty($line) || $line[0] === "#") {
            continue;
        }
        array_push($ret, parse_question($line, $count++));
    }
    return $ret;
}
