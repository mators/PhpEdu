<?php

namespace app\controllers;

use app\models\UserRepository;
use app\oipa\controller\Controller;
use app\views\CommonView;
use app\views\ErrorView;


class HomeController implements Controller {

    public function index() {



        echo new CommonView([
            "title" => "OIPA Phlickr",
            "body" => "<div class='page'>hehe</div>"
        ]);
    }

    public function error() {
        echo new CommonView([
            "title" => "OIPA Phlickr",
            "body" => new ErrorView([ "message" => "Page not found." ])
        ]);
    }

}