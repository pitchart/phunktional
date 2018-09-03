<?php

namespace Pitchart\Phunktional\Tests;

use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional as p;
use Pitchart\Phunktional\Logical as l;
use Pitchart\Phunktional\Math as m;
use Pitchart\Phunktional\Conditional as cond;
use Pitchart\Phunktional\Comparison as comp;


class ConditionalsTest extends TestCase
{
    public function test_handles_if_then_else_statement()
    {
        $if = cond\iif(comp\gt(12), l\T(), l\F());
        self::assertTrue($if(42));
        self::assertFalse($if(6));
    }

    public function test_handles_if_then_statement()
    {
        $max12 = cond\when(comp\gt(12), p\always(12));
        self::assertEquals(6, $max12(6));
        self::assertEquals(12, $max12(42));
    }

    public function test_handles_if_else_statement()
    {
        $min12 = cond\unless(comp\gt(12), p\always(12));
        self::assertEquals(12, $min12(6));
        self::assertEquals(42, $min12(42));
    }

    public function test_handles_switch_cases_with_matching_condition()
    {
        $case = cond\conds([
           [comp\gt(12), m\add(12)]
        ]);

        self::assertEquals(42, $case(30));
    }

    public function test_handles_switch_cases_without_matching_condition()
    {
        $case = cond\conds([
            [comp\gt(12), m\add(12)]
        ]);

        self::assertEquals(10, $case(10));
    }

    public function test_handles_switch_cases_with_default()
    {
        $case = cond\conds([
            [comp\gt(12), m\add(12)],
            [cond\case_default(), m\add(42)],
        ]);

        self::assertEquals(52, $case(10));
    }

    public function test_matching_condition_doesnt_break_switch_statement()
    {
        $case = cond\conds([
            [comp\gt(12), m\add(12)],
            [comp\gt(5), m\add(5)],
        ]);

        self::assertEquals(59, $case(42));
    }

    public function test_matching_breaking_condition_breaks_switch_statement()
    {
        $case = cond\conds([
            [comp\gt(3), m\add(2)],
            cond\case_of(comp\gt(12), m\add(12)),
            [comp\gt(5), m\add(5)],
        ]);

        self::assertEquals(56, $case(42));
    }

    public function test_default_breaks_switch_statement()
    {
        $case = cond\conds([
            [cond\case_default(), m\add(42)],
            [comp\gt(12), m\add(12)],
        ]);

        self::assertEquals(52, $case(10));
    }

    public function test_case_default_returns_default_case_condition()
    {
        self::assertInstanceOf(cond\CaseDefault::class, cond\case_default());
    }

    /**
     * @param $builder
     *
     * @dataProvider switchConditionBuildersProvider
     */
    public function test_has_valid_swich_condition_builders($builder)
    {
        self::assertInternalType('array', $builder);
        self::assertCount(2, $builder);
        self::assertInternalType('callable', $builder[0]);
        self::assertInternalType('callable', $builder[1]);
    }

    /**
     * @param $function
     * @dataProvider comparisonBuildersProvider
     */
    public function test_has_superior_order_function_builder_for($function)
    {
        self::assertTrue(is_callable($function));
    }

    public function comparisonBuildersProvider()
    {
        yield from ['if then else' => [cond\iif(comp\gt(12), l\T(), l\F())]];
        yield from ['if then else constant' => [(cond\iif)(comp\gt(12), l\T(), l\F())]];
        yield from ['if then' => [cond\when(comp\gt(12), l\not())]];
        yield from ['if then constant' => [(cond\when)(comp\gt(12), l\not())]];
        yield from ['if else' => [cond\unless(comp\gt(12), l\not())]];
        yield from ['if else constant' => [(cond\unless)(comp\gt(12), l\not())]];
        yield from ['switch case' => [cond\conds([])]];
        yield from ['switch case constant' => [(cond\conds)([])]];
        yield from ['default' => [cond\case_default()]];
        yield from ['default constant' => [(cond\case_default)()]];
    }

    public function switchConditionBuildersProvider()
    {
        yield from ['case of' => [cond\case_of(comp\gt(12), m\add(12))]];
        yield from ['case of constant' => [(cond\case_of)(comp\gt(12), m\add(12))]];
        yield from ['default' => [cond\case_default_to(m\add(5))]];
        yield from ['default' => [(cond\case_default_to)(m\add(5))]];
    }
}
