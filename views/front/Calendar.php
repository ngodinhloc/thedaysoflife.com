<?php

namespace front;

use jennifer\view\ViewInterface;
use thedaysoflife\model\User;
use thedaysoflife\view\ViewFront;

class Calendar extends ViewFront implements ViewInterface
{
    protected $title = "Calendar Of Life";
    protected $contentTemplate = "front/calendar";

    public function __construct(User $user = null)
    {
        parent::__construct();
        $this->user = $user ? $user : new User();
    }

    public function prepare()
    {
        $calendar = $this->user->getCalendar(0);
        $this->setData(["calendar" => $calendar]);
        return $this;
    }
}