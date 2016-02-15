<?php

require_once('./htmllib.php');
require_once ('./common.php');

header('Content-Type: text/html; charset=utf-8');

function create_li_for($q) {
    $s = create_element("p", true, ["contents" => $q["question"]]);

    foreach ($q["answers"] as $ans) {
        $s .= create_input([
            "type" => $q["type"],
            "name" => $q["id"]."[]",
            "value" => $ans,
            "contents" => $ans
        ]);
        $s .= create_element("br", false, []);
    }
    return create_element("li", true, ["contents" => $s]);
}

function create_list_items() {
    $contents = [];
    foreach (parse_questions("./questions.txt") as $question) {
        array_push($contents, create_li_for($question));
    }
    return $contents;
}

create_doctype();
begin_html();
begin_head();
end_head();
begin_body([]);
start_form("./quizEvaluator.php", "post");

echo create_element("h2", true, ["contents" => "Kviz"]);
echo create_element("ol", true, ["contents" => create_list_items()]);
echo create_input(["type" => "submit", "value" => "Pošalji odgovore!"]);

end_form();
end_body();
end_html();
