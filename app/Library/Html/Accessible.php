<?php


namespace App\Library\Html;


trait Accessible
{
    private $accessible = true;

    /**
     * Set if user has access to the element.
     *
     * @param bool $accessible
     * @return $this
     */
    public function accessible(bool $accessible)
    {
        $this->accessible = $accessible;

        return $this;
    }

    /**
     * Determine if user has access to the element.
     *
     * @return bool
     */
    public function isAccessible()
    {
        return $this->accessible;
    }
}
