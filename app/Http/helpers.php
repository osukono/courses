<?php

if (! function_exists('active_menu')) {
    function active_menu($active, $menu) {
        return isset($active) && $active == $menu ? 'active' : '';
    }
}

if (! function_exists('can')) {
    function can($permission, $string) {
        return Auth::getUser()->can($permission) ? $string : '';
    }
}
