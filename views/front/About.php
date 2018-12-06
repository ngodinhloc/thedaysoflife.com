<?php

namespace front;

use jennifer\view\ViewInterface;
use thedaysoflife\model\User;
use thedaysoflife\view\ViewFront;

class About extends ViewFront implements ViewInterface {
    protected $title = "About";
    protected $contentTemplate = "front/about";
    protected $cache = false;
    
    public function __construct(User $user = null) {
        parent::__construct();
        $this->user = $user ? $user : new User();
    }
    
    public function prepare() {
        $info       = $this->user->getInfoByTag("about");
        $this->data = ["info" => $info];
    }
}