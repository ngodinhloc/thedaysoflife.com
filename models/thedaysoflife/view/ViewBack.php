<?php

namespace thedaysoflife\view;

use jennifer\view\Base;
use thedaysoflife\sys\Configs;

class ViewBack extends Base {
    protected $title = Configs::SITE_TITLE;
    protected $description = Configs::SITE_DESCRIPTION;
    protected $keyword = Configs::SITE_KEYWORDS;
    protected $headerTemplate = "back/_header";
    protected $footerTemplate = "back/_footer";
    protected $contentTemplate = null;
    protected $requiredPermission = ["admin"];
    protected $admin;
    
    public function __construct() {
        parent::__construct();
        $this->setTemplates([$this->headerTemplate, $this->contentTemplate, $this->footerTemplate]);
    }
}