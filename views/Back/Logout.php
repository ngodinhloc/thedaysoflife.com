<?php

namespace Back;

use Jennifer\View\ViewInterface;
use thedaysoflife\View\ViewBack;

class Logout extends ViewBack implements ViewInterface
{
    protected $requiredPermission = false;

    public function __construct()
    {
        parent::__construct();
    }

    public function prepare()
    {
        $this->authentication->userLogout();
        return $this;
    }
}