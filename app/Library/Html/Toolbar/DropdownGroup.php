<?php


namespace App\Library\Html\Toolbar;


use App\Library\Html\Accessible;
use App\Library\Html\Renderable;

class DropdownGroup implements Renderable
{
    use Accessible;

    /** @var Renderable[]|Accessible[] $elements */
    private $elements;
    private $header;

    /**
     * DropdownGroup constructor.
     * @param Renderable[]|Accessible[] $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    public function isAccessible()
    {
        foreach ($this->elements as $element)
            if ($element->isAccessible())
                return true;

        return false;
    }

    /**
     * @param $title
     * @return $this
     */
    public function header($title)
    {
        $this->header = $title;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $html = '';

        if (isset($this->header))
            $html .= '<h6 class="dropdown-header">' . $this->header . '</h6>';

        foreach ($this->elements as $element)
            if ($element->isAccessible())
                $html .= $element->render();

        $html .= '<div class="dropdown-divider"></div>';

        return $html;
    }
}
