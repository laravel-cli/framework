<?php

use Illuminate\Container\Container;

if (!function_exists('app')) {
    function app($make = null)
    {
        if (is_null($make)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($make);
    }
}

if (!function_exists('config')) {
    function config($key, $default = null)
    {
        return env($key, $default);
    }
}
