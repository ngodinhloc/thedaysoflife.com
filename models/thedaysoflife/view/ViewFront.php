<?php

namespace thedaysoflife\view;

use jennifer\view\Base;
use thedaysoflife\sys\Configs;

class ViewFront extends Base
{
    protected $title = Configs::SITE_TITLE;
    protected $description = Configs::SITE_DESCRIPTION;
    protected $keyword = Configs::SITE_KEYWORDS;
    protected $headerTemplate = "front/_header";
    protected $footerTemplate = "front/_footer";
    protected $contentTemplate = null;
    protected $user;

    public function __construct()
    {
        parent::__construct();
        $this->setTemplates([$this->headerTemplate, $this->contentTemplate, $this->footerTemplate]);
    }
}