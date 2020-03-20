<?php


namespace App\Library\Html\Toolbar;


use App\Library\Html\Accessible;
use App\Library\Html\Form\Form;
use App\Library\Html\Renderable;
use Illuminate\Support\Facades\View;

class Button implements Renderable
{
    use Accessible;

    /** @var string $icon */
    private $icon;
    /** @var string $label */
    private $label;
    /** @var string $tooltip */
    private $tooltip;
    /** @var string $links */
    private $links;
    /** @var Form $submits */
    private $submits;

    public const icon_plus = "plus";
    public const icon_trash_full = 'trash-2';
    public const icon_trash_empty = 'trash';
    public const icon_more_vertical = 'more-vertical';

    /**
     * @param string $label
     * @return $this
     */
    public function label(string $label)
    {
        $this->label = $label;

        return $this;
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
     * @param string $tooltip
     * @return $this
     */
    public function tooltip(string $tooltip)
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    /**
     * @param string $url
     * @return $this
     */
    public function links(string $url)
    {
        $this->links = $url;

        return $this;
    }

    /**
     * @param Form $form
     * @return $this
     */
    public function submits(Form $form)
    {
        $this->submits = $form;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        return View::make('html.toolbar.button', [
            'icon' => $this->icon,
            'label' => $this->label,
            'tooltip' => $this->tooltip,
            'links' => $this->links,
            'submits' => $this->submits
        ]);
    }
}
