<?php


namespace App\Library\Html\Toolbar;


use App\Library\Html\Accessible;
use App\Library\Html\Renderable;
use Illuminate\Support\Facades\View;

class DropdownItem implements Renderable
{
    use Accessible;

    /** @var string $label */
    private $label;
    private $links;

    /**
     * DropdownItem constructor.
     * @param string $label
     */
    public function __construct($label)
    {
        $this->label = $label;
    }

    /**
     * @param $url
     * @return $this
     */
    public function links($url)
    {
        $this->links = $url;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return View::make('html.toolbar.dropdown-item', [
            'label' => $this->label,
            'links' => $this->links
        ]);
    }
}
