<?php

namespace Pitchart\Phunktional;

use Pitchart\Phunktional\Partial\Placeholder;

/**
 * @return Placeholder
 */
function _()
{
    return Placeholder::get();
}

/**
 * @param callable $function
 * @param mixed ...$arguments
 *
 * @return \Closure
 */
function partial(callable $function, ...$arguments)
{
    return function (...$remaining) use ($function, $arguments)
    {
        Placeholder::resolve($arguments, $remaining);
        return $function(...array_merge($arguments, $remaining));
    };
}

/**
 * @param callable $function
 * @param mixed ...$arguments
 *
 * @return \Closure
 */
function partial_r(callable $function, ...$arguments)
{
    return function (...$remaining) use ($function, $arguments)
    {
        Placeholder::resolve($arguments, $remaining);
        return $function(...array_merge($remaining, $arguments));
    };
}
