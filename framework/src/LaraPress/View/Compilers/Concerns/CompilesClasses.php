<?php

namespace LaraPress\View\Compilers\Concerns;

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

        return "class=\"<?php echo \LaraPress\Support\Arr::toCssClasses{$expression} ?>\"";
    }
}
