<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('routeContains')) {
    function routeContains($keyword)
    {
        return str_contains(Route::currentRouteName(), $keyword);
    }
}

if (!function_exists('routeContainsAny')) {
    function routeContainsAny(array $keywords)
    {
        $routeName = Route::currentRouteName();
        foreach ($keywords as $keyword) {
            if (str_contains($routeName, $keyword)) {
                return true;
            }
        }
        return false;
    }
}
