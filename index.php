<?php
/**
 * Single point entry
 * <pre>mod_rewrite in to redirect all request to this index page (except for the listed directories)
 * process request uri to get view and load view
 * </pre>
 */
require_once("models/autoload.php");

use jennifer\exception\RequestException;
use jennifer\sys\System;
use jennifer\http\Response;
use jennifer\exception\ConfigException;

try {
    $system = new System([DOC_ROOT . "/config/env.ini"], [DOC_ROOT . "/config/routes.ini"]);
    $system->matchRoute()->loadView()->renderView();
}
catch (ConfigException $exception) {
    (new Response())->error($exception->getMessage());
}
catch (RequestException $exception) {
    (new Response())->error($exception->getMessage());
}