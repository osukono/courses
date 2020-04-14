<?php

if (! function_exists('active_menu')) {
    function active_menu($active, $menu) {
        return isset($active) && $active == $menu ? 'active' : '';
    }
}
