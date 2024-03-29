<?php

namespace LaraWP\Wordpress\View;

class ClosureComponent extends Component
{
    protected $closure;

    public function __construct(\Closure $closure)
    {
        $this->closure = $closure;
    }

    public function render()
    {
        $closure = $this->closure;
        return $closure($this->data);
    }
}