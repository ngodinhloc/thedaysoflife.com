<?php

namespace Front;

use Jennifer\View\ViewInterface;
use thedaysoflife\Model\User;
use thedaysoflife\View\ViewFront;

class Search extends ViewFront implements ViewInterface
{
    protected $title = "Search";
    protected $contentTemplate = "front/search";

    public function __construct(User $user = null)
    {
        parent::__construct();
        $this->user = $user ? $user : new User();
    }

    public function prepare()
    {
        $search = $this->request->hasGet("q");
        if ($search) {
            $searchResult = $this->user->getSearch($search);
            $this->setData(["searchTerm" => $search, "searchResult" => $searchResult]);
        }
        return $this;
    }
}