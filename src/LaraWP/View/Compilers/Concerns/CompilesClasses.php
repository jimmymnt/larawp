<?php

namespace LaraWP\View\Compilers\Concerns;

trait CompilesClasses
{
    /**
     * Compile the conditional class statement into valid PHP.
     *
     * @param string $expression
     * @return string
     */
    protected function compileClass($expression)
    {
        $expression = is_null($expression) ? '([])' : $expression;

        return "class=\"<?php echo \LaraWP\Support\Arr::toCssClasses{$expression} ?>\"";
    }
}
