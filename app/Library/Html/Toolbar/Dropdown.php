<?php


namespace App\Library\Html\Toolbar;


use App\Library\Html\Accessible;
use App\Library\Html\Renderable;
use Illuminate\Support\Facades\View;

class Dropdown implements Renderable
{
    use Accessible;

    /** @var Accessible[]|Renderable[]| $elements */
    private $elements;
    /** @var string $icon */
    private $icon;
    /** @var string $label */
    private $label;

    /**
     * Dropdown constructor.
     * @param Renderable[]|Accessible[] $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    /**
     * @param string $icon
     * @return $this
     */
    public function icon(string $icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function label(string $label)
    {
        $this->label = $label;

        return $this;
    }

    public function isAccessible()
    {
        foreach ($this->elements as $element)
            if ($element->isAccessible())
                return true;

        return false;
    }

    private function renderItems()
    {
        $html = '';

        foreach ($this->elements as $element)
            if ($element->isAccessible())
                $html .= $element->render();

        return $html;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return View::make('html.toolbar.dropdown', [
            'icon' => $this->icon,
            'label' => $this->label,
            'items' => $this->renderItems()
        ]);
    }
}
