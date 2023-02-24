<?php

namespace LaraWP\Validation;

use LaraWP\Contracts\Support\Arrayable;
use LaraWP\Support\Traits\Macroable;
use LaraWP\Validation\Rules\Dimensions;
use LaraWP\Validation\Rules\Exists;
use LaraWP\Validation\Rules\In;
use LaraWP\Validation\Rules\NotIn;
use LaraWP\Validation\Rules\RequiredIf;
use LaraWP\Validation\Rules\Unique;

class Rule
{
    use Macroable;

    /**
     * Create a new conditional rule set.
     *
     * @param callable|bool $condition
     * @param array|string $rules
     * @param array|string $defaultRules
     * @return \LaraWP\Validation\ConditionalRules
     */
    public static function when($condition, $rules, $defaultRules = [])
    {
        return new ConditionalRules($condition, $rules, $defaultRules);
    }

    /**
     * Get a dimensions constraint builder instance.
     *
     * @param array $constraints
     * @return \LaraWP\Validation\Rules\Dimensions
     */
    public static function dimensions(array $constraints = [])
    {
        return new Dimensions($constraints);
    }

    /**
     * Get an exists constraint builder instance.
     *
     * @param string $table
     * @param string $column
     * @return \LaraWP\Validation\Rules\Exists
     */
    public static function exists($table, $column = 'NULL')
    {
        return new Exists($table, $column);
    }

    /**
     * Get an in constraint builder instance.
     *
     * @param \LaraWP\Contracts\Support\Arrayable|array|string $values
     * @return \LaraWP\Validation\Rules\In
     */
    public static function in($values)
    {
        if ($values instanceof Arrayable) {
            $values = $values->toArray();
        }

        return new In(is_array($values) ? $values : func_get_args());
    }

    /**
     * Get a not_in constraint builder instance.
     *
     * @param \LaraWP\Contracts\Support\Arrayable|array|string $values
     * @return \LaraWP\Validation\Rules\NotIn
     */
    public static function notIn($values)
    {
        if ($values instanceof Arrayable) {
            $values = $values->toArray();
        }

        return new NotIn(is_array($values) ? $values : func_get_args());
    }

    /**
     * Get a required_if constraint builder instance.
     *
     * @param callable|bool $callback
     * @return \LaraWP\Validation\Rules\RequiredIf
     */
    public static function requiredIf($callback)
    {
        return new RequiredIf($callback);
    }

    /**
     * Get a unique constraint builder instance.
     *
     * @param string $table
     * @param string $column
     * @return \LaraWP\Validation\Rules\Unique
     */
    public static function unique($table, $column = 'NULL')
    {
        return new Unique($table, $column);
    }
}
