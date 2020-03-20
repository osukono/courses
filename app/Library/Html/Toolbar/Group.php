<?php


namespace App\Library\Html\Toolbar;


use App\Library\Html\Accessible;
use App\Library\Html\Renderable;

class Group implements Renderable
{
    use Accessible;

    /** @var Renderable[]|Accessible[] $elements */
    private $elements;

    /**
     * @param Renderable[]|Accessible[] $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @return bool
     */
    public function isAccessible()
    {
        foreach ($this->elements as $element)
            if ($element->isAccessible())
                return true;

        return false;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $html = '<div class="btn-group ml-2" role="group">';

        foreach ($this->elements as $element)
            if ($element->isAccessible())
                $html .= $element->render();

        $html .= '</div>';

        return $html;
    }
}
