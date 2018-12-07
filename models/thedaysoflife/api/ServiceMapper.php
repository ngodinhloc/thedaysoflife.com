<?php

namespace thedaysoflife\api;

use jennifer\api\ServiceMap;
use thedaysoflife\service\DayService;

class ServiceMapper extends ServiceMap
{

    public function __construct()
    {
        $this->register(DayService::map());
    }
}