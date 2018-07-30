<?php

namespace Pitchart\Phunktional\Tests;

use function GuzzleHttp\Psr7\_caseless_remove;
use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional as p;

class ConditionalsTest extends TestCase
{
    public function test_handles_if_then_else_statement()
    {
        $if = p\iif(p\gt(12), p\T(), p\F());
        self::assertTrue($if(42));
        self::assertFalse($if(6));
    }

    public function test_handles_if_then_statement()
    {
        $max12 = p\when(p\gt(12), p\always(12));
        self::assertEquals(6, $max12(6));
        self::assertEquals(12, $max12(42));
    }

    public function test_handles_if_else_statement()
    {
        $min12 = p\unless(p\gt(12), p\always(12));
        self::assertEquals(12, $min12(6));
        self::assertEquals(42, $min12(42));
    }

    public function test_handles_switch_cases_with_matching_condition()
    {
        $case = p\conds([
           [p\gt(12), p\add(12)]
        ]);

        self::assertEquals(42, $case(30));
    }

    public function test_handles_switch_cases_without_matching_condition()
    {
        $case = p\conds([
            [p\gt(12), p\add(12)]
        ]);

        self::assertEquals(10, $case(10));
    }

    public function test_handles_switch_cases_with_default()
    {
        $case = p\conds([
            [p\gt(12), p\add(12)],
            [p\case_default(), p\add(42)],
        ]);

        self::assertEquals(52, $case(10));
    }

    public function test_matching_condition_breaks_switch_statement()
    {
        $case = p\conds([
            [p\gt(12), p\add(12)],
            [p\gt(5), p\add(5)],
        ]);

        self::assertEquals(54, $case(42));
    }

    public function test_default_breaks_switch_statement()
    {
        $case = p\conds([
            [p\case_default(), p\add(42)],
            [p\gt(12), p\add(12)],
        ]);

        self::assertEquals(52, $case(10));
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
        yield from ['if then else' => [p\iif(p\gt(12), p\T(), p\F())]];
        yield from ['if then else constant' => [(p\iif)(p\gt(12), p\T(), p\F())]];
        yield from ['if then' => [p\when(p\gt(12), p\not())]];
        yield from ['if then constant' => [(p\when)(p\gt(12), p\not())]];
        yield from ['if else' => [p\unless(p\gt(12), p\not())]];
        yield from ['if else constant' => [(p\unless)(p\gt(12), p\not())]];
        yield from ['switch case' => [p\conds([])]];
        yield from ['switch case constant' => [(p\conds)([])]];
    }
}
