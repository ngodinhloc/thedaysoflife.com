<?php

namespace Back;

use Jennifer\Controller\Controller;
use Jennifer\Db\Exception\DbException;
use thedaysoflife\Com\Com;
use thedaysoflife\Model\Admin;
use thedaysoflife\Sys\Configs;

class ControllerBack extends Controller
{
    protected $requiredPermission = ["admin"];
    /** @var Admin */
    private $admin;

    public function __construct(Admin $admin = null)
    {
        parent::__construct();
        $this->admin = $admin ? $admin : new Admin();
    }

    /**
     * Remove a day
     * @return array|bool
     */
    public function ajaxRemoveADay()
    {
        $id = (int)$this->request->post['id'];
        $re = $this->admin->removeDay($id);
        if ($re) {
            return ["status" => "success", "id" => $id];
        }

        return false;
    }

    /**
     * Print day list
     * @return string
     */
    public function ajaxPrintDay()
    {
        $page = (int)$this->request->post['page'] == 0 ? 1 : (int)$this->request->post['page'];
        return $this->admin->getDayList($page);
    }

    /**
     * Update a day
     * @return array
     */
    public function ajaxUpdateADay()
    {
        $day = [];
        $day["id"] = (int)$this->request->post['id'];
        $day["day"] = (int)$this->request->post['day'];
        $day["month"] = (int)$this->request->post['month'];
        $day["year"] = (int)$this->request->post['year'];
        $check = checkdate($day["month"], $day["day"], $day["year"]);
        if ($check) {
            $day["title"] = Com::filter($this->request->post['title']);
            $day["slug"] = Com::sanitizeString(($day["title"]));
            $day["content"] = Com::filter($this->request->post['content'], true);
            $day["username"] = Com::filter($this->request->post['username']);
            $day["email"] = Com::filter($this->request->post['email']);
            $day["location"] = Com::filter($this->request->post['loc']);
            $day["photos"] = Com::filter($this->request->post['photos']);
            $day["like"] = (int)$this->request->post['like'];
            $day["preview"] = Com::subString(Com::filter($day["content"]), Configs::SUMMARY_LENGTH, 3);
            $day["sanitize"] = str_replace('-', ' ', Com::sanitizeString($day["title"]))
                . ' ' . str_replace('-', ' ', Com::sanitizeString($day["username"]))
                . ' ' . str_replace('-', ' ', Com::sanitizeString($day["location"]))
                . ' ' . str_replace('-', ' ', Com::sanitizeString($day["preview"]));
            $re = $this->admin->updateDay($day);
            if ($re) {
                return ["status" => "success",
                    "id" => $day["id"],
                    "slug" => $day["slug"],
                    "day" => $day["day"],
                    "month" => $day["month"],
                    "year" => $day["year"]];
            }
        }
        return ["status" => "failed", "id" => $day["id"]];
    }

    /**
     * Update site info: about, privacy
     * @return string|bool
     */
    public function ajaxUpdateInfo()
    {
        $tag = Com::filter($this->request->post['tag']);
        $title = Com::filter($this->request->post['title']);
        $content = Com::filter($this->request->post['content'], true);
        if ($tag != "") {
            $result = $this->admin->updateInfo($tag, $title, $content);
            if ($result) {
                return "Info updated.";
            }
        }
        return false;
    }

    /**
     * Remove unused photos
     * @return string
     */
    public function ajaxRemoveUnusedPhoto()
    {
        return $this->admin->removeUnusedPhotos();
    }

    /**
     * Check, analyse, repair database
     * @return string
     * @throws DbException
     */
    public function ajaxCheckDatabase()
    {
        $act = $this->request->post['act'];
        return $this->admin->checkDatabaseTables($act);
    }
}