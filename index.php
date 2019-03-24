<?php
require_once("models/autoload.php");
require_once("vendor/autoload.php");

use Jennifer\Http\Response;
use Jennifer\Http\Router;
use Jennifer\Sys\System;

try {
    $system = new System([DOC_ROOT . "/config/env.ini"]);
    $system->setRouter(new Router([DOC_ROOT . "/config/routes.ini"]))->loadView()->renderView();
} catch (Exception $exception) {
    (new Response())->error($exception->getMessage(), $exception->getCode());
}