<?php

namespace app\router;


interface Route {

    public function match($request);

    public function generate(array $params = []);
}