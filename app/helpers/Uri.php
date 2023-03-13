<?php
namespace app\helpers;

class Uri
{
    public static function get($type):string
    {
        //Get the uri with parse_url($_SERVER['REQUEST_URI']) and path or query depend on $type
        return parse_url($_SERVER['REQUEST_URI'])[$type];
    }
}