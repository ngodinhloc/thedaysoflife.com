<?php

namespace Back;

use Jennifer\Sys\Config;
use Jennifer\View\ViewInterface;
use thedaysoflife\Model\Admin;
use thedaysoflife\View\ViewBack;

class About extends ViewBack implements ViewInterface
{
    protected $title = "Dashboard :: About";
    protected $contentTemplate = "back/about";

    public function __construct(Admin $admin = null)
    {
        parent::__construct();
        $this->admin = $admin ? $admin : new Admin();
    }

    public function prepare()
    {
        $tag = "about";
        $info = $this->admin->getInfoByTag($tag);
        $this->setData(["tag" => $tag, "info" => $info]);
        $this->addMetaFiles([Config::getConfig("SITE_URL") . "/plugins/ckeditor/ckeditor.js"]);
        return $this;
    }
}