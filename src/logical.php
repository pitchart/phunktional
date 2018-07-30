<?php

namespace Pitchart\Phunktional;

const T = '\Pitchart\Phunktional\T';
const F = '\Pitchart\Phunktional\F';
const not = '\Pitchart\Phunktional\not';
const same = '\Pitchart\Phunktional\same';
const _and = '\Pitchart\Phunktional\_and';
const _or = '\Pitchart\Phunktional\_or';
const all = '\Pitchart\Phunktional\all';
const some = '\Pitchart\Phunktional\some';
const complement = '\Pitchart\Phunktional\complement';

/**
 * @return \Closure
 */
function T()
{
    return function ($value = null) {
        return true;
    };
}

/**
 * @return \Closure
 */
function F()
{
    return function ($value = null) {
        return false;
    };
}

/**
 * @return \Closure
 */
function not()
{
    return function ($x) {
        return !$x;
    };
}

/**
 * @return \Closure
 */
function same()
{
    return function ($value) {
        return $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function _and(...$args)
{
    return function ($value) use ($args) {
        return \array_reduce($args, function ($carry, $arg) {
            return $carry ? $carry && $arg : $carry;
        }, $value);
    };
}

/**
 * @param array ...$args
 *
 * @return \Closure
 */
function _or(...$args)
{
    return function ($value) use ($args) {
        return \array_reduce($args, function ($carry, $arg) {
            return !$carry ? $carry || $arg : $carry;
        }, $value);
    };
}

/**
 * @param \callable[] ...$expressions
 *
 * @return \Closure
 */
function all(callable ...$expressions)
{
    return function ($value) use ($expressions) {
        return \array_reduce($expressions, function ($carry, callable $expression) use ($value) {
            return $carry ? $carry && (boolean) $expression($value) : $carry;
        }, true);
    };
}

/**
 * @param \callable[] ...$expressions
 *
 * @return \Closure
 */
function some(callable ...$expressions)
{
    return function ($value) use ($expressions) {
        return \array_reduce($expressions, function ($carry, callable $expression) use ($value) {
            return !$carry ? $carry || (boolean) $expression($value) : $carry;
        }, false);
    };
}

/**
 * @param callable $function { x -> boolean }
 *
 * @return \Closure
 */
function complement(callable $function)
{
    return function ($value) use ($function) {
        return !$function($value);
    };
}
