<?php
namespace app\helpers;

class Request
{
    public static function get():string
    {
        //This returns the method used in request
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}