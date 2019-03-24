<?php

namespace Front;

use Jennifer\View\ViewInterface;
use thedaysoflife\Model\User;
use thedaysoflife\View\ViewFront;

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