<?php
/**
 * Single entry point for controllers: all ajax actions point to this page with a pair of {action, controller}
 */
require_once("../models/autoload.php");

use jennifer\http\Response;
use jennifer\http\Router;
use jennifer\sys\System;

try {
    $system = new System([DOC_ROOT . "/config/env.ini"]);
    $system->setRouter(new Router([DOC_ROOT . "/config/routes.ini"]))->loadController()->runController();
} catch (Exception $exception) {
    (new Response())->error($exception->getMessage());
}