<?php

namespace front;

use jennifer\html\jobject\FlexSlider;
use jennifer\sys\Config;
use jennifer\sys\Globals;
use jennifer\view\ViewInterface;
use thedaysoflife\com\Com;
use thedaysoflife\model\User;
use thedaysoflife\sys\Configs;
use thedaysoflife\view\ViewFront;

class Day extends ViewFront implements ViewInterface
{
    protected $contentTemplate = "front/day";

    public function __construct(User $user = null)
    {
        parent::__construct();
        $this->user = $user ? $user : new User();
    }

    public function prepare()
    {
        $topDays = $this->user->getRightTopDays();
        $this->setData(["topDays" => $topDays]);
        if ($id = $this->hasPara("id")) {
            $day = $this->user->getDayById($id);
            if ($day) {
                $this->url = Com::getDayLink($day);
                $this->title = Com::getDayTitle($day);
                $this->description = Com::getDayDescription($day);
                $this->keyword = $day['title'];
                $slider = "";
                if (trim($day['photos']) != "") {
                    $photoArray = explode(',', trim($day['photos']));
                    $fullPhotos = Com::getPhotoArray($photoArray, Configs::PHOTO_FULL_NAME);
                    $thumbPhotos = Com::getPhotoArray($photoArray, Configs::PHOTO_THUMB_NAME);
                    $flexSlider = new FlexSlider([], ["fullPhotos" => $fullPhotos,
                        "thumbPhotos" => $thumbPhotos]);
                    $slider = $flexSlider->render();
                    $this->registerMetaFiles($flexSlider);
                }
                $photoURL = Com::getFirstPhotoURL($day);
                $ipAddress = Globals::todayIPAddress();
                $likeIP = explode('|', $day['like_ip']);

                $data = ["url" => $this->url,
                    "title" => $this->title,
                    "time" => Com::getTimeDiff($day['time']),
                    "photoURL" => $photoURL,
                    "authorLink" => Com::getSearchLink($day['username']),
                    "locationLink" => $day['location'] != '' ? Com::getSearchLink($day['location']) : false,
                    "dateLink" => Com::getSearchLink($day['month'] . '/' . $day['year'], false),
                    "liked" => in_array($ipAddress, $likeIP),
                    "slider" => $slider,
                    "comments" => $this->user->getComments($id)];

                $dayData = array_merge($day, $data);

                $relatedDays = $this->user->getRightRelatedDays(["day" => (int)$day['day'],
                    "month" => (int)$day['month'],
                    "year" => (int)$day['year'],
                    "location" => $day['location']]);

                $this->setData(["day" => $dayData,
                    "topDays" => $topDays,
                    "relatedDays" => $relatedDays != "" ? $relatedDays : "No related days found"]);

                $this->addMetaTags([
                    "<meta property='fb:admins' content='" . Config::getConfig("FB_PAGEID") . "'/>",
                    "<meta property='og:type' content='article'/>",
                    "<meta property='og:url' content='{$this->url}'/>",
                    "<meta property='og:title' content='{$this->title}'/>",
                    "<meta property='og:description' content='{$this->description}'/>",
                    "<meta property='og:image' content='{$photoURL}'/>"]);
                $this->addMetaFiles([Config::getConfig("SITE_URL") . "/plugins/jquery/jquery.autosize.min.js"]);
            }
        }
        return $this;
    }
}