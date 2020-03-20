<?php


namespace App\Library\Html;


interface Renderable
{
    /**
     * Get the content of the object.
     *
     * @return string
     */
    public function render();
}
