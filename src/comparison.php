<?php

namespace Pitchart\Phunktional\Comparison;

/**
 * Functional comparison functions
 *
 * @package Pitchart\Phunktional\Comparison
 */

const equals = __NAMESPACE__.'\equals';
const different = __NAMESPACE__.'\different';
const lt = __NAMESPACE__.'\lt';
const lte = __NAMESPACE__.'\lte';
const gt = __NAMESPACE__.'\gt';
const gte = __NAMESPACE__.'\gte';
const even = __NAMESPACE__.'\even';
const odd = __NAMESPACE__.'\odd';
const comparator = __NAMESPACE__.'\comparator';

/**
 * Equality
 *
 * @param $value
 *
 * @return \Closure
 */
function equals($value)
{
    return function ($compared) use ($value) {
        return $compared === $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function different($value)
{
    return function ($compared) use ($value) {
        return $compared !== $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function lt($value)
{
    return function ($compared) use ($value) {
        return $compared < $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function lte($value)
{
    return function ($compared) use ($value) {
        return $compared <= $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function gt($value)
{
    return function ($compared) use ($value) {
        return $compared > $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function gte($value)
{
    return function ($compared) use ($value) {
        return $compared >= $value;
    };
}

/**
 * @return \Closure (float $compared): bool
 */
function even()
{
    return function (float $compared) {
        return $compared % 2 == 0;
    };
}

/**
 * @return \Closure
 */
function odd()
{
    return function ($compared) {
        return $compared % 2 != 0;
    };
}

/**
 * Creates a comparison function for a callable criterion
 *
 * The list items are sorted in ascendant order of the $callback function applied to items
 * The created function can be used with usort(), uasot() and uksort()
 *
 * @param callable $callback
 *
 * @return \Closure
 */
function comparator(callable $callback)
{
    return function ($first, $second) use ($callback) {
        $first = ($callback)($first);
        $second = ($callback)($second);
        if ($first == $second)  {
            return 0;
        }
        return $first < $second ? -1 : 1;
    };
}
