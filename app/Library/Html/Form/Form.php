<?php


namespace App\Library\Html\Form;


use App\Library\Html\Renderable;

class Form implements Renderable
{
    /** @var Renderable[] $elements */
    private $elements;

    private $method = 'get';
    private $visible = true;
    private $autocomplete = false;
    private $submit;
    private $cancel;

    /**
     * Form constructor.
     * @param Renderable[] $elements
     */
    public function __construct(array $elements = null)
    {
        $this->elements = $elements;
    }

    /**
     * @param bool $visible
     * @return Form
     */
    public function visible(bool $visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * @param string $method
     * @return Form
     */
    public function method(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Form shows submit button
     * @param string $label
     * @return Form
     */
    public function submit(string $label)
    {
        $this->submit = $label;

        return $this;
    }

    /**
     * @param string $route
     * @return Form
     */
    public function cancel(string $route)
    {
        $this->cancel = $route;

        return $this;
    }

    /**
     * @param bool $autocomplete
     * @return Form
     */
    public function autocomplete(bool  $autocomplete = true)
    {
        $this->autocomplete = $autocomplete;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        // TODO: Implement render() method.
    }
}
