<?php

namespace LaraWP\View;

use LaraWP\Container\Container;
use LaraWP\Support\Str;
use LaraWP\View\Compilers\ComponentTagCompiler;

class DynamicComponent extends Component
{
    /**
     * The name of the component.
     *
     * @var string
     */
    public $component;

    /**
     * The component tag compiler instance.
     *
     * @var \LaraWP\View\Compilers\BladeTagCompiler
     */
    protected static $compiler;

    /**
     * The cached component classes.
     *
     * @var array
     */
    protected static $componentClasses = [];

    /**
     * Create a new component instance.
     *
     * @param string $component
     * @return void
     */
    public function __construct(string $component)
    {
        $this->component = $component;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \LaraWP\Contracts\View\View|string
     */
    public function render()
    {
        $template = <<<'EOF'
<?php extract(lp_collect($attributes->getAttributes())->mapWithKeys(function ($value, $key) { return [LaraWP\Support\Str::camel(str_replace([':', '.'], ' ', $key)) => $value]; })->all(), EXTR_SKIP); ?>
{{ props }}
<x-{{ component }} {{ bindings }} {{ attributes }}>
{{ slots }}
{{ defaultSlot }}
</x-{{ component }}>
EOF;

        return function ($data) use ($template) {
            $bindings = $this->bindings($class = $this->classForComponent());

            return str_replace(
                [
                    '{{ component }}',
                    '{{ props }}',
                    '{{ bindings }}',
                    '{{ attributes }}',
                    '{{ slots }}',
                    '{{ defaultSlot }}',
                ],
                [
                    $this->component,
                    $this->compileProps($bindings),
                    $this->compileBindings($bindings),
                    class_exists($class) ? '{{ $attributes }}' : '',
                    $this->compileSlots($data['__laravel_slots']),
                    '{{ $slot ?? "" }}',
                ],
                $template
            );
        };
    }

    /**
     * Compile the @props directive for the component.
     *
     * @param array $bindings
     * @return string
     */
    protected function compileProps(array $bindings)
    {
        if (empty($bindings)) {
            return '';
        }

        return '@props(' . '[\'' . implode('\',\'', lp_collect($bindings)->map(function ($dataKey) {
                return Str::camel($dataKey);
            })->all()) . '\']' . ')';
    }

    /**
     * Compile the bindings for the component.
     *
     * @param array $bindings
     * @return string
     */
    protected function compileBindings(array $bindings)
    {
        return lp_collect($bindings)->map(function ($key) {
            return ':' . $key . '="$' . Str::camel(str_replace([':', '.'], ' ', $key)) . '"';
        })->implode(' ');
    }

    /**
     * Compile the slots for the component.
     *
     * @param array $slots
     * @return string
     */
    protected function compileSlots(array $slots)
    {
        return lp_collect($slots)->map(function ($slot, $name) {
            return $name === '__default' ? null : '<x-slot name="' . $name . '" ' . ((string)$slot->attributes) . '>{{ $' . $name . ' }}</x-slot>';
        })->filter()->implode(PHP_EOL);
    }

    /**
     * Get the class for the current component.
     *
     * @return string
     */
    protected function classForComponent()
    {
        if (isset(static::$componentClasses[$this->component])) {
            return static::$componentClasses[$this->component];
        }

        return static::$componentClasses[$this->component] =
            $this->compiler()->componentClass($this->component);
    }

    /**
     * Get the names of the variables that should be bound to the component.
     *
     * @param string $class
     * @return array
     */
    protected function bindings(string $class)
    {
        [$data, $attributes] = $this->compiler()->partitionDataAndAttributes($class, $this->attributes->getAttributes());

        return array_keys($data->all());
    }

    /**
     * Get an instance of the Blade tag compiler.
     *
     * @return \LaraWP\View\Compilers\ComponentTagCompiler
     */
    protected function compiler()
    {
        if (!static::$compiler) {
            static::$compiler = new ComponentTagCompiler(
                Container::getInstance()->make('blade.compiler')->getClassComponentAliases(),
                Container::getInstance()->make('blade.compiler')->getClassComponentNamespaces(),
                Container::getInstance()->make('blade.compiler')
            );
        }

        return static::$compiler;
    }
}
