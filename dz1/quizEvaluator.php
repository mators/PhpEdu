<?php

require_once('./htmllib.php');
require_once ('./common.php');

header('Content-Type: text/html; charset=utf-8');

create_doctype();
begin_html();
begin_head();
end_head();
begin_body([]);
echo create_element("h2", true, ["contents" => "Rezultati kviza"]);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    create_table(["border" => "1"]);

    echo create_table_row(["contents" => [
        create_element("th", true, ["contents" => "Pitanje"]),
        create_element("th", true, ["contents" => "Točan odgovor"]),
        create_element("th", true, ["contents" => "Vaš odgovor"])
    ]]);

    $good = 0;
    $questions = parse_questions("./questions.txt");

    foreach ($questions as $question) {
        $correct = implode("<br>", $question["correct"]);
        $answered = implode("<br>", $_POST[$question["id"]]);
        if ($question["type"] === "text") {
            $answered = htmlentities($answered);
        }

        echo create_table_row(["contents" => [
            create_table_cell(["contents" => $question["id"]]),
            create_table_cell(["contents" => $correct]),
            create_table_cell(["contents" => $answered])
        ]]);

        if (strcasecmp($correct, $answered) == 0) {
            $good++;
        }
    }

    end_table();

    $n = count($questions);
    $percentage = round($good / $n * 100, 2);
    echo create_element("p", true, ["contents" => "Odgovorili ste točno na ".$good."/".$n." pitanja (".$percentage."%)."]);
}

echo create_element("p", true,
    ["contents" => create_element("a", true, ["href" => "./quizGenerator.php", "contents" => "Natrag na kviz"])]
);


end_body();
end_html();
