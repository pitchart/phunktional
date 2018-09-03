<?php

namespace Pitchart\Phunktional\Math;

const add = __NAMESPACE__.'\add';
const substract = __NAMESPACE__.'\substract';
const multiply = __NAMESPACE__.'\multiply';
const divide = __NAMESPACE__.'\divide';
const inc = __NAMESPACE__.'\inc';
const dec = __NAMESPACE__.'\dec';
const modulo = __NAMESPACE__.'\modulo';
const f_mod = __NAMESPACE__.'\f_mod';
const sum = __NAMESPACE__.'\sum';
const product = __NAMESPACE__.'\product';
const average = __NAMESPACE__.'\average';
const median = __NAMESPACE__.'\median';
const max = __NAMESPACE__.'\max';
const min = __NAMESPACE__.'\min';

/**
 * @param $value
 *
 * @return \Closure
 */
function add($value)
{
    return function ($val) use ($value) {
        return $val + $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function substract($value)
{
    return function ($val) use ($value) {
        return $val - $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function multiply($value)
{
    return function ($val) use ($value) {
        return $val * $value;
    };
}

/**
 * @param $divider
 *
 * @return \Closure
 */
function divide($divider)
{
    if ($divider == 0) {
        throw new \InvalidArgumentException('Can not divide by 0');
    }
    return function ($value) use ($divider) {
        return $value / $divider;
    };
}

/**
 * @return \Closure
 */
function inc()
{
    return add(1);
}

/**
 * @return \Closure
 */
function dec()
{
    return substract(1);
}

/**
 * @param $modulo
 *
 * @return \Closure
 */
function modulo($modulo)
{
    return function ($number) use ($modulo) {
        return $number % $modulo;
    };
}

/**
 * @param $divisor
 *
 * @return \Closure
 */
function f_mod($divisor)
{
    return function ($dividend) use ($divisor) {
        return \fmod($dividend, $divisor);
    };
}

/**
 * @return \Closure
 */
function sum()
{
    return function (... $values) {
        return \array_sum($values);
    };
}

/**
 * @return \Closure
 */
function product()
{
    return function (... $values) {
        return \array_product($values);
    };
}

/**
 * @return \Closure
 */
function average()
{
    return function(... $numbers) {
        return \count($numbers) > 0 ? sum()(...$numbers) / \count($numbers) : 0;
    };
}

/**
 * @return \Closure
 */
function median()
{
    return function (...$values) {
        $count = \count($values);
        if ($count == 0) {
            return 0;
        }
        \sort($values);
        $mid  = (int) \floor(($count - 1) / 2);
        if ($count % 2) {
            return $values[$mid];
        }
        return ($values[$mid] + $values[$mid + 1]) / 2;
    };
}

/**
 * @param null $default
 *
 * @return \Closure
 */
function max($default = null)
{
    return function (...$values) use ($default) {
        $list = $values;
        if ($default !== null) {
            $list = \array_merge($values, [$default]);
        }
        return \max($list);
    };
}

/**
 * @param null $default
 *
 * @return \Closure
 */
function min($default = null)
{
    return function (...$values) use ($default) {
        $list = $values;
        if ($default !== null) {
            $list = \array_merge($values, [$default]);
        }
        return \min($list);
    };
}

