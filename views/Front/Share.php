<?php

namespace Front;

use Jennifer\Html\JObject\PhotoUploader;
use Jennifer\Sys\Config;
use Jennifer\View\ViewInterface;
use thedaysoflife\Com\Com;
use thedaysoflife\View\ViewFront;

class Share extends ViewFront implements ViewInterface
{
    protected $title = "Share Your Day";
    protected $contentTemplate = "front/share";
    protected $cache = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function prepare()
    {
        $photoUploader = new PhotoUploader([], ["text" => "Have some photos to upload?"]);
        $this->setData(["daySelect" => Com::getDayOptions(),
            "monthSelect" => Com::getMonthOptions(),
            "yearSelect" => Com::getYearOptions(),
            "photoUploader" => $photoUploader->render()]);
        $this->addMetaFiles([Config::getConfig("SITE_URL") . "/plugins/jquery/jquery.autosize.min.js"]);
        return $this;
    }
}