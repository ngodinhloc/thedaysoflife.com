<?php

namespace Back;

use Jennifer\Html\JObject\PhotoUploader;
use Jennifer\Sys\Config;
use Jennifer\View\ViewInterface;
use thedaysoflife\Com\Com;
use thedaysoflife\Model\Admin;
use thedaysoflife\View\ViewBack;

class Day extends ViewBack implements ViewInterface
{
    protected $title = "Dashboard :: Edit";
    protected $contentTemplate = "back/day";

    public function __construct(Admin $admin = null)
    {
        parent::__construct();
        $this->admin = $admin ? $admin : new Admin();
    }

    public function prepare()
    {
        if ($id = $this->hasPara("id")) {
            $row = $this->admin->getDayById($id);
            $photoUploader = new PhotoUploader([], ["text" => "Current photos",
                "currentPhotos" => Com::getPhotoPreviewArray($row["photos"])]);
            $this->setData(["row" => $row,
                "daySelect" => Com::getDayOptions($row["day"]),
                "monthSelect" => Com::getMonthOptions($row["month"]),
                "yearSelect" => Com::getYearOptions($row["year"]),
                "photoUploader" => $photoUploader->render()]);
            $this->addMetaFiles([Config::getConfig("SITE_URL") . "/plugins/jquery/jquery.autosize.min.js"]);
        }
        return $this;
    }
}