<?php

namespace app\controllers;

use app\oipa\controller\Controller;
use app\views\CommonView;
use app\views\LoginView;
use app\views\RegisterView;


class AuthController implements Controller {

    public function login() {
        echo new CommonView([
            "title" => "OIPA Phlickr",
            "body" => new LoginView()
        ]);
    }

    public function logout() {

    }

    public function register() {
        echo new CommonView([
            "title" => "OIPA Phlickr",
            "body" => new RegisterView()
        ]);
    }

}