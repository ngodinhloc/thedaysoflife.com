<?php

namespace back;

use jennifer\view\ViewInterface;
use thedaysoflife\model\Admin;
use thedaysoflife\sys\Configs;
use thedaysoflife\view\ViewBack;

class Privacy extends ViewBack implements ViewInterface {
    protected $title = "Dashboard :: Privacy";
    protected $contentTemplate = "back/privacy";
    
    public function __construct(Admin $admin = null) {
        parent::__construct();
        $this->admin = $admin ? $admin : new Admin();
    }
    
    public function prepare() {
        $tag        = "privacy";
        $info       = $this->admin->getInfoByTag($tag);
        $this->data = ["tag" => $tag, "info" => $info];
        $this->addMetaFile(getenv("SITE_URL") . "/plugins/ckeditor/ckeditor.js");
    }
}