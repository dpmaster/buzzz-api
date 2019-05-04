<?php

namespace Buzzz\Api;

abstract class Controller{
    private static $di;

    /**
     * @return mixed
     */
    public static function getDi()
    {
        return self::$di;
    }

    /**
     * @param mixed $di
     */
    public static function setDi($di)
    {
        self::$di = $di;
    }

    public function __get($name)
    {
        $di = self::getDi();
        if (isset($di[$name])) {
            return $di[$name];
        }
        return null;
    }

}