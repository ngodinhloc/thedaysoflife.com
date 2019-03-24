<?php

namespace thedaysoflife\Service;

use Jennifer\Api\Service;
use Jennifer\Api\ServiceInterface;
use Jennifer\Http\Exception\RequestException;
use thedaysoflife\Model\User;

class DayService extends Service implements ServiceInterface
{
    protected static $serviceName = "service_day";
    /** @var User */
    protected $user;
    protected $requiredPermission = ["day"];

    /**
     * DayService constructor.
     * @param array $userData
     * @param array $para
     * @throws RequestException
     */
    public function __construct($userData, $para)
    {
        parent::__construct($userData, $para);
        $this->user = new User();
    }

    /**
     * Return the map of this service and actions
     * Each public function is an action [public_name => functionName]
     * @return array
     */
    public static function map()
    {
        $map = ["service" => self::$serviceName,
            "class" => __CLASS__,
            "actions" => ["get_day" => "getDay"],
        ];

        return $map;
    }

    /**
     * Get Day
     * @return array|bool
     */
    public function getDay()
    {
        $this->requirePermission("day");
        $id = $this->hasPara("id");
        if ($id) {
            $day = $this->user->getDayById($id);

            return $day;
        }

        return false;
    }
}