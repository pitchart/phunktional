<?php

namespace Pitchart\Phunktional;

use Pitchart\Phunktional\Conditional\CaseDefault;

const iif = __NAMESPACE__.'\iif';
const when = __NAMESPACE__.'\when';
const unless = __NAMESPACE__.'\unless';
const conds = __NAMESPACE__.'\conds';
const case_default = __NAMESPACE__.'\case_default';

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
 * examples:
 * [
 *     [gt(12), add(10)],
 *     [lt(40), add(20)],
 *     [case_default(), add(30)],
 * ]
 * or
 * [
 *     case_of(gt(12), add(10)),
 *     case_of(lt(40), add(20)),
 *     case_default_to(add(30)),
 * ]
 *
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

            if ($condition($value) instanceof CaseDefault
                || $condition($value)
            ) {
                return $return($carry);
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

/**
 * @param callable $case
 * @param callable $instruction
 * @param bool $break
 *
 * @return array
 */
function case_of(callable $case, callable $instruction, bool $break = true)
{
    return [
        $case,
        function ($value) use ($instruction, $break) {
            return $break ? new Reduced($instruction($value)) : $instruction($value);
        }
    ];
}

/**
 * @param callable $instruction
 *
 * @return array
 */
function case_default_to(callable $instruction) {
    return [
        case_default(),
        function ($value) use ($instruction) {
            return new Reduced($instruction($value));
        }
    ];
}
