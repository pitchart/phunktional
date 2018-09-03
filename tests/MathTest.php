<?php

namespace Pitchart\Phunktional\Tests;

use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional\Math as m;

class MathTest extends TestCase
{

    /**
     * @param $function
     * @dataProvider mathBuildersProvider
     */
    public function test_has_superior_order_function_builder_for($function)
    {
        self::assertTrue(is_callable($function));
    }

    public function test_can_calculate_additions()
    {
        self::assertEquals(5, m\add(3)(2));
    }

    public function test_can_calculate_substractions()
    {
        self::assertEquals(5, m\substract(3)(8));
    }

    public function test_can_calculate_products()
    {
        self::assertEquals(6, m\multiply(3)(2));
    }

    public function test_can_calculate_divisions()
    {
        self::assertEquals(5, m\divide(2)(10));
    }

    public function test_can_compute_modulos()
    {
        self::assertEquals(2, m\modulo(3)(17));
    }

    public function test_supports_sum_computation_for_a_list_of_values()
    {
        self::assertEquals(12, m\sum()(3, 4, 5));
    }

    public function test_supports_sum_computation_for_an_empty_list()
    {
        self::assertEquals(0, m\sum()());
    }

    public function test_supports_product_computation_for_a_list_of_values()
    {
        self::assertEquals(60, m\product()(3, 4, 5));
    }

    public function test_supports_product_computation_for_an_empty_list()
    {
        self::assertEquals(1, m\product()());
    }

    public function test_supports_average_computation()
    {
        self::assertEquals(4, m\average()(3, 4, 5));
    }

    public function test_supports_average_computation_for_an_empty_list()
    {
        self::assertEquals(0, m\average()());
    }

    /**
     * @param array $list
     * @dataProvider medianListProvider
     */
    public function test_supports_median_computation_for(array $list, $expected)
    {
        self::assertEquals($expected, m\median()(...$list));
    }

    public function mathBuildersProvider()
    {
        yield from ['addition' => [m\add(3)]];
        yield from ['addition constant' => [(m\add)(3)]];
        yield from ['subsctraction' => [m\substract(3)]];
        yield from ['subsctraction constant' => [(m\substract)(3)]];
        yield from ['multiplication' => [m\multiply(3)]];
        yield from ['multiplication constant' => [(m\multiply)(3)]];
        yield from ['division' => [m\divide(3)]];
        yield from ['division constant' => [(m\divide)(3)]];
        yield from ['incrementation' => [m\inc()]];
        yield from ['incrementation constant' => [(m\inc)]];
        yield from ['decrementation' => [m\dec()]];
        yield from ['decrementation constant' => [(m\dec)()]];
        yield from ['modulo' => [m\modulo(3)]];
        yield from ['modulo constant' => [(m\modulo)(3)]];
        yield from ['modulo remainder' => [m\f_mod(3)]];
        yield from ['modulo remainder constant' => [(m\f_mod)(3)]];
        yield from ['sum' => [m\sum()]];
        yield from ['sum constant' => [(m\sum)()]];
        yield from ['product' => [m\product()]];
        yield from ['product constant' => [(m\product)()]];
        yield from ['average' => [m\average()]];
        yield from ['average constant' => [(m\average)()]];
        yield from ['median' => [m\median()]];
        yield from ['median constant' => [(m\median)()]];
        yield from ['max' => [m\max()]];
        yield from ['max constant' => [(m\max)()]];
        yield from ['min' => [m\min()]];
        yield from ['min constant' => [(m\min)()]];
    }

    public function medianListProvider()
    {
        yield from ['an empty list of values' => [[], 0]];
        yield from ['an odd number of values' => [[5, 2, 1, 3, 4], 3]];
        yield from ['an even number of values' => [[5, 2, 1, 3, 4, 6], 3.5]];
    }
}
