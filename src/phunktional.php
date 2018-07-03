<?php

namespace Pitchart\Phunktional;

/**
 * Creates a composition of functions
 *
 * @param \callable[] ...$callbacks
 *
 * @return Composition
 */
function compose(callable ...$callbacks)
{
    return new Composition(...$callbacks);
}

/**
 * @param mixed ...$value
 *
 * @return array|mixed
 */
function identity(...$value)
{
    if (count($value) === 1) {
        return array_shift($value);
    }
    return $value;
}

/**
 * Transforms a function into a pure function
 *
 * @param callable $function
 * @param array ...$arguments
 *
 * @return mixed
 */
function curry(callable $function, ...$arguments)
{
    return (new Curry($function))(...$arguments);
}

/**
 * Transforms a value into a function that always returns the same value
 *
 * @param $always
 *
 * @return \Closure
 */
function always($always) {
    return function ($value) use ($always) {
        return $always;
    };
}
