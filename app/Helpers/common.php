<?php

if (!function_exists('checkActiveRoutes')) {

    /**
     * Active menu side bar when routes menu are current route
     *
     * @param Array  $routes routes action
     * @param string $output active or ''
     *
     * @return string
     */
    function checkActiveRoutes(array $routes, $output = "active")
    {
        if (in_array(Route::currentRouteName(), $routes, true)) {
            return $output;
        }
    }
}
