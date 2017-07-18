<?php

/**
 * Created by PhpStorm.
 * User: michaelharper
 * Date: 7/18/17
 * Time: 2:46 AM
 */
class Request
{
    public static function uri()
    {
        return trim($_SERVER['REQUEST_URI'], '/');
    }
}