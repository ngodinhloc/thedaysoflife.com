<?php

namespace thedaysoflife\Com;

use Jennifer\Com\Common;
use Jennifer\Html\HTML;
use Jennifer\Sys\Config;
use thedaysoflife\Sys\Configs;

class Com extends Common
{
    /**
     * @param $search
     * @param bool $encode
     * @return string
     */
    public static function getSearchLink($search, $encode = true)
    {
        $search = $encode ? urlencode($search) : $search;

        return Config::getConfig("SITE_URL") . "/search/?q=" . $search;
    }

    /**
     * @param array $day
     * @return string
     */
    public static function getDayLink($day)
    {
        return $link = Configs::LIST_URL . $day['id'] . '/' . $day['day'] . $day['month'] . $day['year'] . '-' .
            $day['slug'] . Config::getConfig("URL_EXT");
    }

    /**
     * @param array $day
     * @return string
     */
    public static function getDayDescription($day)
    {
        return self::subString(strip_tags($day['content']), Configs::DESC_LENGTH, 3);
    }

    /**
     * @param $day
     * @return string
     */
    public static function getDayPreviewText($day)
    {
        $preview = trim(str_replace('<br>', ' ', $day['preview']));
        if (strlen($preview) > Configs::PREVIEW_LENGTH) {
            $preview = Com::subString($preview, Configs::PREVIEW_LENGTH, 3);
        }

        return $preview;
    }

    /**
     * @param array $day
     * @return string
     */
    public static function getDayTitle($day)
    {
        return $day['day'] . '/' . $day['month'] . '/' . $day['year'] . ': ' . $day['title'];
    }

    /**
     * @param string $route
     * @return string
     */
    public static function getDashboardMenu($route)
    {
        $menus = [
            '/back/home/' => ['title' => 'Home', 'url' => Config::getConfig("SITE_URL") . '/back/home/'],
            '/back/days/' => ['title' => 'Days', 'url' => Config::getConfig("SITE_URL") . '/back/days/'],
            '/back/about/' => ['title' => 'About', 'url' => Config::getConfig("SITE_URL") . '/back/about/'],
            '/back/privacy/' => ['title' => 'Privacy', 'url' => Config::getConfig("SITE_URL") . '/back/privacy/'],
            '/back/tools/' => ['title' => 'Tools', 'url' => Config::getConfig("SITE_URL") . '/back/tools/'],
        ];
        $html = new HTML();
        $output = "";
        foreach ($menus as $url => $menu) {
            if (strtolower($route) == strtolower($url)) {
                $output .= $html->setTag("li")->setClass("active")->open() .
                    $html->setTag("a")->setProp(["href" => $menu["url"]])->setInnerHTML($menu["title"])->create() .
                    $html->setTag("li")->close();
            } else {
                $output .= $html->setTag("li")->open() .
                    $html->setTag("a")->setProp(["href" => $menu["url"]])->setInnerHTML($menu["title"])->create() .
                    $html->setTag("li")->close();
            }
        }

        return $output;
    }

    /**
     * Get menu (HTML)
     * @param string $route
     * @return string
     */
    public static function getMenu($route)
    {
        $menus = [
            '/' => ['title' => 'The Days Of Life', 'url' => Config::getConfig("SITE_URL")],
            '/like/' => ['title' => 'Most Liked Days', 'url' => Config::getConfig("SITE_URL") . '/like/'],
            '/calendar/' => ['title' => 'The Calendar Of Life', 'url' => Config::getConfig("SITE_URL") . '/calendar/'],
            '/picture/' => ['title' => 'The Picture Of Life', 'url' => Config::getConfig("SITE_URL") . '/picture/'],
            '/about/' => ['title' => 'About', 'url' => Config::getConfig("SITE_URL") . '/about/'],
            '/privacy/' => ['title' => 'Privacy', 'url' => Config::getConfig("SITE_URL") . '/privacy/'],
        ];
        $html = new HTML();
        $output = "";
        foreach ($menus as $url => $menu) {
            if (strtolower($url) == strtolower($route)) {
                $output .= $html->setTag("li")->setClass("active")->open() .
                    $html->setTag("a")->setProp(["href" => $menu['url']])->setInnerHTML($menu['title'])->create() .
                    $html->setTag("li")->close();
            } else {
                $output .= $html->setTag("li")->open() .
                    $html->setTag("a")->setProp(["href" => $menu['url']])->setInnerHTML($menu['title'])->create() .
                    $html->setTag("li")->close();
            }
        }

        return $output;
    }

    /**
     * @param $day
     * @param string $type
     * @return string
     */
    public static function getFirstPhotoURL($day, $type = Configs::PHOTO_TITLE_NAME)
    {
        $photoUrl = "";
        $photos = trim($day['photos']);
        if ($photos != "") {
            $photos = explode(',', $photos);
            $fistPhoto = $photos[0];
            $photoUrl = Com::getPhotoURL($fistPhoto, $type);
        }

        return $photoUrl;
    }

    /**
     * @param $name
     * @param $type
     * @return string
     */
    public static function getPhotoURL($name, $type)
    {
        $info = explode('_', $name);
        $ym = $info[0];
        $year = substr($ym, 0, 4);
        $month = substr($ym, 4, 2);
        $name = self::getPhotoName($name, $type);
        $url = Config::getConfig("PHOTO_URL") . $year . "/" . $month . "/" . $name;

        return $url;
    }

    /**
     * @param $name
     * @param $type
     * @return string
     */
    public static function getPhotoName($name, $type)
    {
        switch ($type) {
            case Configs::PHOTO_FULL_NAME:
                $name = $name . Configs::PHOTO_FULL_NAME . Configs::PHOTO_EXT;
                break;
            case Configs::PHOTO_TITLE_NAME:
                $name = $name . Configs::PHOTO_TITLE_NAME . Configs::PHOTO_EXT;
                break;
            case Configs::PHOTO_THUMB_NAME:
                $name = $name . Configs::PHOTO_THUMB_NAME . Configs::PHOTO_EXT;
                break;
        }

        return $name;
    }

    /**
     * @param string $photos
     * @return array
     */
    public static function getPhotoPreviewArray($photos)
    {
        $photos = explode(',', $photos);
        $array = [];
        foreach ($photos as $photo) {
            $thumb_url = self::getPhotoURL($photo, Configs::PHOTO_THUMB_NAME);
            $array [] = ["id" => $photo, "thumb" => $thumb_url];
        }

        return $array;
    }

    /**
     * @param array $photos
     * @param string $type PHOTO_FULL_NAME, PHOTO_THUMB_NAME
     * @return array
     */
    public static function getPhotoArray($photos, $type)
    {
        $array = [];
        foreach ($photos as $i => $name) {
            $array [] = self::getPhotoURL($name, $type);
        }

        return $array;
    }

    /**
     * @param $photos
     * @return string
     */
    public static function getPhotoSlideFull($photos)
    {
        $html = new HTML();
        $output = "";
        foreach ($photos as $i => $name) {
            $url = self::getPhotoURL($name, Configs::PHOTO_FULL_NAME);
            $output .= $html->setTag("li")->open() .
                $html->setTag("img")->setProp(["src" => $url])->create() .
                $html->setTag("li")->close();
        }

        return $output;
    }

    /**
     * @param $photos
     * @return string
     */
    public static function getPhotoSlideThumb($photos)
    {
        $html = new HTML();
        $output = "";
        foreach ($photos as $i => $name) {
            $url = self::getPhotoURL($name, Configs::PHOTO_THUMB_NAME);
            $output .= $html->setTag("li")->open() .
                $html->setTag("img")->setProp(["src" => $url])->create() .
                $html->setTag("span")->create() .
                $html->setTag("li")->close();
        }

        return $output;
    }

    /**
     * @param string $str
     * @param bool $admin
     * @return mixed|string
     */
    public static function filter($str, $admin = false)
    {
        $str = str_replace("&nbsp;", " ", $str);
        $find = ["<p> </p>", "<p></p>"];
        $str = str_replace($find, "", $str);
        $find = ["\\n", "<br/>", "<br />"];
        $str = str_replace($find, "<br>", $str);
        $str = str_replace("'", '"', $str);
        $str = trim(stripcslashes($str));
        $allowTags = "<br>";
        if ($admin) {
            $allowTags = "<p><br><b><i><ol><ul><li><strong>";
        }
        $str = strip_tags($str, $allowTags);

        return $str;
    }
}