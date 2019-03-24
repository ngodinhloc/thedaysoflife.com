<?php

namespace Front;

use Jennifer\View\ViewInterface;
use thedaysoflife\Model\User;
use thedaysoflife\View\ViewFront;

class Privacy extends ViewFront implements ViewInterface
{
    protected $title = "Privacy";
    protected $contentTemplate = "front/privacy";
    protected $cache = false;

    public function __construct(User $user = null)
    {
        parent::__construct();
        $this->user = $user ? $user : new User();
    }

    public function prepare()
    {
        $info = $this->user->getInfoByTag("privacy");
        $this->setData(["info" => $info]);
        return $this;
    }
}