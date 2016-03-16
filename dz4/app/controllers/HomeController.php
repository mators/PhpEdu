<?php

namespace app\controllers;

use app\oipa\controller\Controller;
use app\views\CommonView;


class HomeController implements Controller {

    public function index() {
        echo new CommonView([
            "title" => "OIPA Phlickr",
            "body" => ""
        ]);
    }

    public function error() {
        echo new CommonView([
            "title" => "OIPA Phlickr",
            "body" => "error"
        ]);
    }

}