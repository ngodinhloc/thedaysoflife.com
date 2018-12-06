<?php

namespace front;

use jennifer\view\ViewInterface;
use thedaysoflife\model\User;
use thedaysoflife\view\ViewFront;

class Index extends ViewFront implements ViewInterface {
    protected $contentTemplate = "front/index";
    
    public function __construct(User $user = null) {
        parent::__construct();
        $this->user = $user ? $user : new User();
    }
    
    public function prepare() {
        $days       = $this->user->getDays(0, User::ORDER_BY_ID);
        $this->data = ["days" => $days, "order" => User::ORDER_BY_ID];
    }
}