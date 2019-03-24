<?php

namespace Front;

use Jennifer\View\ViewInterface;
use thedaysoflife\Model\User;
use thedaysoflife\View\ViewFront;

class Picture extends ViewFront implements ViewInterface
{
    protected $title = "The Picture Of Life";
    protected $contentTemplate = "front/picture";

    public function __construct(User $user = null)
    {
        parent::__construct();
        $this->user = $user ? $user : new User();
    }

    public function prepare()
    {
        $picture = $this->user->getPicture(0);
        $this->setData(["picture" => $picture]);
        return $this;
    }
}