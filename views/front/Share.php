<?php

namespace front;

use jennifer\html\jobject\PhotoUploader;
use jennifer\view\ViewInterface;
use thedaysoflife\com\Com;
use thedaysoflife\sys\Configs;
use thedaysoflife\view\ViewFront;

class Share extends ViewFront implements ViewInterface {
    protected $title = "Share Your Day";
    protected $contentTemplate = "front/share";
    protected $cache = true;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function prepare() {
        $photoUploader = new PhotoUploader([], ["text" => "Have some photos to upload?"]);
        $this->data    = ["daySelect"     => Com::getDayOptions(),
                          "monthSelect"   => Com::getMonthOptions(),
                          "yearSelect"    => Com::getYearOptions(),
                          "photoUploader" => $photoUploader->render()];
        $this->addMetaFile(getenv("SITE_URL") . "/plugins/jquery/jquery.autosize.min.js");
    }
}