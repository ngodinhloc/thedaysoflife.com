<?php

namespace Front;

use Jennifer\Controller\Controller;
use Jennifer\Sys\Globals;
use thedaysoflife\Com\Com;
use thedaysoflife\Model\User;
use thedaysoflife\Sys\Configs;

class ControllerFront extends Controller
{
    /** @var User */
    private $user;

    public function __construct(User $user = null)
    {
        parent::__construct();
        $this->user = $user ? $user : new User();
    }

    /**
     * User made new day
     * @return array|bool
     */
    public function ajaxMakeADay()
    {
        $day = [];
        $day["day"] = (int)$this->request->post['day'];
        $day["month"] = (int)$this->request->post['month'];
        $day["year"] = (int)$this->request->post['year'];
        $check = checkdate($day["month"], $day["day"], $day["year"]);
        if ($check) {
            $day["title"] = Com::filter($this->request->post['title']);
            $day["content"] = Com::filter($this->request->post['content']);
            $day["username"] = Com::filter($this->request->post['username']);
            $day["email"] = Com::filter($this->request->post['email']);
            $day["location"] = Com::filter($this->request->post['loc']);
            $day["photos"] = Com::filter($this->request->post['photos']);
            $day["slug"] = Com::sanitizeString($day["title"]);
            $day["preview"] = Com::subString(Com::filter($day["content"]), Configs::SUMMARY_LENGTH, 3);
            $day["sanitize"] = str_replace('-', ' ', Com::sanitizeString($day["title"]))
                . ' ' . str_replace('-', ' ', Com::sanitizeString($day["username"]))
                . ' ' . str_replace('-', ' ', Com::sanitizeString($day["location"]))
                . ' ' . str_replace('-', ' ', Com::sanitizeString($day["preview"]));
            $day["like"] = 0;
            $day["notify"] = "no";
            $day["time"] = time();
            $day["date"] = date('Y-m-d h:i:s');
            $day["ipaddress"] = Globals::realIPAddress();
            $day["session_id"] = Globals::sessionID();

            $re = $this->user->addDay($day);
            if ($re) {
                $row = $this->user->getLastInsertDay($day["time"], $day["session_id"]);
                return ["status" => "success",
                    "id" => $row['id'],
                    "slug" => $row['slug'],
                    "day" => $row['day'],
                    "month" => $row['month'],
                    "year" => $row['year']];

            }
        }

        return false;
    }

    /**
     * Show list of days
     * @return string|bool
     */
    public function ajaxShowDay()
    {
        $from = (int)$this->request->post['from'];
        $order = $this->request->post['order'];
        if ($from > 0 && in_array($order, [User::ORDER_BY_ID, User::ORDER_BY_LIKE])) {
            return $this->user->getDays($from, $order);
        }

        return false;
    }

    /**
     * Search day
     * @return string
     */
    public function ajaxSearchDay()
    {
        $search = $this->request->post['search'];
        if ($search != "") {
            return $this->user->getSearch($search);
        }

        return false;
    }

    /**
     * Get more search result
     * @return string
     */
    public function ajaxSearchMore()
    {
        $search = $this->request->post['search'];
        $from = (int)$this->request->post['from'];
        if ($search != "" && $from > 0) {
            return $this->user->getSearchMore($search, $from);
        }

        return false;
    }

    /**
     * show calendar
     * @return string
     */
    public function ajaxShowCalendar()
    {
        $from = (int)$this->request->post['from'];
        if ($from > 0) {
            return $this->user->getCalendar($from);
        }

        return false;
    }

    /**
     * Show picture
     * @return string
     */
    public function ajaxShowPicture()
    {
        $from = (int)$this->request->post['from'];
        if ($from > 0) {
            return $this->user->getPicture($from);
        }

        return false;
    }

    /**
     * User add comment
     * @return array
     */
    public function ajaxMakeAComment()
    {
        $comment = [
            "day_id" => (int)$this->request->post['day_id'],
            "content" => Com::filter($this->request->post['content']),
            "username" => Com::filter($this->request->post['username']),
            "email" => Com::filter($this->request->post['email']),
            "reply_id" => 0,
            "reply_name" => '',
            "like" => 0,
            "time" => time(),
            "date" => date('Y-m-d h:i:s'),
            "ipaddress" => Globals::realIPAddress(),
            "session_id" => Globals::sessionID()
        ];
        if ($comment["day_id"] > 0 && $comment["content"] != "" && $comment["username"] != "" &&
            $comment["email"] != "") {
            $re = $this->user->addComment($comment);
            if ($re) {
                $this->user->updateCommentCount($comment["day_id"]);
                $lastCom = $this->user->getLastInsertComment($comment["time"], $comment["session_id"]);

                return ["result" => true,
                    "day_id" => $comment["day_id"],
                    "content" => $this->user->getOneCommentHTML($lastCom)];
            }
        }

        return ["result" => false, "error" => "Please check inputs"];
    }

    /**
     * User reply to a comment
     * @return array
     */
    public function ajaxMakeAReply()
    {
        $comment = [
            "day_id" => (int)$this->request->post['day_id'],
            "com_id" => (int)$this->request->post['com_id'],
            "content" => Com::filter($this->request->post['content']),
            "username" => Com::filter($this->request->post['username']),
            "email" => Com::filter($this->request->post['email']),
            "reply_id" => (int)$this->request->post['rep_id'],
            "reply_name" => Com::filter($this->request->post['rep_name']),
            "like" => 0,
            "time" => time(),
            "date" => date('Y-m-d h:i:s'),
            "ipaddress" => Globals::realIPAddress(),
            "session_id" => Globals::sessionID(),
        ];
        if ($comment["day_id"] > 0 && $comment["content"] != "" && $comment["username"] != "" &&
            $comment["email"] != "" &&
            $comment["reply_id"] > 0
        ) {
            $re = $this->user->addComment($comment);
            if ($re) {
                $this->user->updateCommentCount($comment["day_id"]);
                $lastCom = $this->user->getLastInsertComment($comment["time"], $comment["session_id"]);
                return ["result" => true,
                    "com_id" => $comment["com_id"],
                    "content" => $this->user->getOneCommentHTML($lastCom)];
            }
        }

        return ["result" => false, "error" => "Please check inputs"];
    }

    /**
     * User like a day
     * @return bool
     */
    public function ajaxLikeADay()
    {
        $id = (int)$this->request->post['id'];
        if ($id > 0) {
            $ipaddress = trim(Globals::todayIPAddress());
            return $this->user->updateLikeDay($id, $ipaddress);
        }

        return false;
    }

    /**
     * User like a comment
     * @return bool
     */
    public function ajaxLikeAComment()
    {
        $id = (int)$this->request->post['id'];
        if ($id > 0) {
            $ipaddress = trim(Globals::todayIPAddress());
            return $this->user->updateLikeComment($id, $ipaddress);
        }

        return false;
    }

    /**
     * User dislike a comment
     * @return bool
     */
    public function ajaxDislikeAComment()
    {
        $id = (int)$this->request->post['id'];
        if ($id > 0) {
            $ipaddress = trim(Globals::todayIPAddress());
            return $this->user->updateDislikeComment($id, $ipaddress);
        }

        return false;
    }
}