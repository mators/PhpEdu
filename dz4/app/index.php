<?php

require_once "inc/global.php";

use app\dispatcher\DefaultDispatcher;
use app\router\Router;
use app\oipa\model\NotFoundException;


try {
    DefaultDispatcher::getInstance()->dispatch();
} catch (NotFoundException $e) {
    redirect(Router::getRoute("error")->generate());
}
