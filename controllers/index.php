<?php
/**
 * Single entry point for controllers: all ajax actions point to this page with a pair of {action, controller}
 */
require_once("../models/autoload.php");

use jennifer\exception\ConfigException;
use jennifer\exception\RequestException;
use jennifer\http\Response;
use jennifer\http\Router;
use jennifer\sys\System;

try {
    $system = new System([DOC_ROOT . "/config/env.ini"]);
    $system->setRouter(new Router([DOC_ROOT . "/config/routes.ini"]))->loadController()->runController();
} catch (ConfigException $exception) {
    (new Response())->error($exception->getMessage());
} catch (RequestException $exception) {
    (new Response())->error($exception->getMessage());
}