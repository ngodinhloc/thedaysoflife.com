<?php

namespace back;

use jennifer\db\driver\MySQL;
use jennifer\html\Element;
use jennifer\view\ViewInterface;
use thedaysoflife\view\ViewBack;

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