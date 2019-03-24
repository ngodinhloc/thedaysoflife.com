<?php

namespace thedaysoflife\Api;

use Jennifer\Api\ServiceMap;
use thedaysoflife\Service\DayService;

class ServiceMapper extends ServiceMap
{

    public function __construct()
    {
        $this->register(DayService::map());
    }
}