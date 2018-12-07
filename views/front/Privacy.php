<?php

namespace front;

use jennifer\view\ViewInterface;
use thedaysoflife\model\User;
use thedaysoflife\view\ViewFront;

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
        $this->data = ["info" => $info];
        return $this;
    }
}