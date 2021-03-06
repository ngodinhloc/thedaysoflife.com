<?php
define("DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]);
spl_autoload_register(function ($className) {
    $namespace = str_replace("\\", "/", strtolower(__NAMESPACE__));
    $className = str_replace("\\", "/", $className);
    $class = __DIR__ . "/" . (empty($namespace) ? "" : $namespace . "/") . $className . ".php";
    if (file_exists($class)) {
        require_once($class);
    }
});