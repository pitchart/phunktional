<?php

namespace Pitchart\Phunktional;

use Pitchart\Phunktional\Conditional\CaseDefault;

const iif = '\Pitchart\Phunktional\iif';
const when = '\Pitchart\Phunktional\when';
const unless = '\Pitchart\Phunktional\unless';
const conds = '\Pitchart\Phunktional\conds';
const case_default = '\Pitchart\Phunktional\case_default';

/**
 * Functional implementation for the following "if then else" statement :
 *
 * if ($condition($value)) {
 *     $value = $then($value);
 * } else {
 *     $value = $else($value);
 * }
 *
 * @param callable $condition
 * @param callable $then
 * @param callable $else
 *
 * @return \Closure
 */
function iif(callable $condition, callable $then, callable $else)
{
    return function ($value) use ($condition, $then, $else) {
        return $condition($value) ? $then($value) : $else($value);
    };
}

/**
 * Functional implementation for the following "if" statement :
 *
 * if ($condition($value)) {
 *     $value = $then($value);
 * }
 *
 * @param callable $condition
 * @param callable $then
 *
 * @return \Closure
 */
function when(callable $condition, callable $then)
{
    return function ($value) use ($condition, $then) {
        return $condition($value) ? $then($value) : $value;
    };
}

/**
 * Functional implementation for the following "if" statement :
 *
 * if (!$condition($value)) {
 *     $value = $else($value);
 * }
 *
 * @param callable $condition
 * @param callable $else
 *
 * @return \Closure
 */
function unless(callable $condition, callable $else)
{
    return function ($value) use ($condition, $else) {
        return $condition($value) ? $value : $else($value);
    };
}

/**
 * Functional implementataion of switch case statement, with strict steps (all steps break)
 *
 * @param array $cases an array of 2 elements arrays, whose first element is the condition or a default, and the second a callable to be applied to the value
 *
 * example:
 * [
 *     [gt(12), add(10)],
 *     [lt(40), add(20)],
 *     [case_default(), add(30)],
 * ]
 *
 * @return \Closure
 */
function conds(array $cases)
{
    return function ($value) use ($cases) {
        $reduced = \array_reduce($cases, function ($carry, $case) use ($value) {
            list ($condition, $return) = $case;

            if ($carry instanceof Reduced) {
                return $carry;
            }

            if ($condition instanceof CaseDefault
                || $condition($value)
            ) {
                return new Reduced($return($value));
            }

            return $carry;
        }, $value);
        return $reduced instanceof Reduced ? $reduced->value() : $reduced;
    };
}

/**
 * Builds a default statement for switch cases (conds() function)
 *
 * @return CaseDefault
 */
function case_default()
{
    return new CaseDefault();
}
