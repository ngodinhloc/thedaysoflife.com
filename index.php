<?php
/**
 * Single point entry
 * <pre>mod_rewrite in to redirect all request to this index page (except for the listed directories)
 * process request uri to get view and load view
 * </pre>
 */
require_once("models/autoload.php");

use jennifer\http\Response;
use jennifer\http\Router;
use jennifer\sys\System;

try {
    $system = new System([DOC_ROOT . "/config/env.ini"]);
    $system->setRouter(new Router([DOC_ROOT . "/config/routes.ini"]))->loadView()->renderView();
} catch (Exception $exception) {
    (new Response())->error($exception->getMessage(), $exception->getCode());
}