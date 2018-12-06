<?php
/**
 * Single entry point for controllers: all ajax actions point to this page with a pair of {action, controller}
 */
require_once("../models/autoload.php");

use jennifer\exception\RequestException;
use jennifer\sys\System;
use jennifer\exception\ConfigException;
use jennifer\http\Response;

try {
    $system = new System([DOC_ROOT . "/config/env.ini"], [DOC_ROOT . "/config/routes.ini"]);
    $system->loadController()->runController();
}
catch (ConfigException $exception) {
    (new Response())->error($exception->getMessage());
}
catch (RequestException $exception) {
    (new Response())->error($exception->getMessage());
}