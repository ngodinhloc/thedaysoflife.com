<?php

namespace Back;

use Jennifer\Db\Driver\MySQL;
use Jennifer\Html\Element;
use Jennifer\View\ViewInterface;
use thedaysoflife\View\ViewBack;

class Tools extends ViewBack implements ViewInterface
{
    protected $title = "Dashboard :: Tools";
    protected $contentTemplate = "back/tools";
    protected $requiredPermission = ["admin"];

    public function __construct()
    {
        parent::__construct();
    }

    public function prepare()
    {
        $databaseTools = Element::radios(MySQL::DB_ACTIONS, "checkdb", null, null, "<br>");
        $photoTools = Element::radios(["REMOVE_UNUSED" => "Remove unused photos"], "photoTools", "REMOVE_UNUSED", null, "");
        $this->setData(["photoTools" => $photoTools,
            "databaseTools" => $databaseTools]);
        return $this;
    }
}