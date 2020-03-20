<?php


namespace App\Library\Html\Toolbar;


use App\Library\Html\Accessible;
use App\Library\Html\Renderable;

class Toolbar implements Renderable
{
    /** @var Renderable[]|Accessible[] $elements */
    private $elements;

    /**
     * Toolbar constructor.
     * @param Renderable[]|Accessible[] $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @return string
     */
    public function render()
    {
        $html = '<!-- Toolbar -->';

        foreach ($this->elements as $element) {
            if ($element->isAccessible())
                $html .= $element->render();
        }

        $html .= '<!-- End Toolbar -->';

        return $html;
    }
}
