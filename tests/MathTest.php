<?php

namespace Pitchart\Phunktional\Tests;

use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional as p;

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
        self::assertEquals(5, p\add(3)(2));
    }

    public function test_can_calculate_substractions()
    {
        self::assertEquals(5, p\substract(3)(8));
    }

    public function test_can_calculate_products()
    {
        self::assertEquals(6, p\multiply(3)(2));
    }

    public function test_can_calculate_divisions()
    {
        self::assertEquals(5, p\divide(2)(10));
    }

    public function test_can_compute_modulos()
    {
        self::assertEquals(2, p\modulo(3)(17));
    }

    public function test_supports_sum_computation_for_a_list_of_values()
    {
        self::assertEquals(12, p\sum()(3, 4, 5));
    }

    public function test_supports_sum_computation_for_an_empty_list()
    {
        self::assertEquals(0, p\sum()());
    }

    public function test_supports_product_computation_for_a_list_of_values()
    {
        self::assertEquals(60, p\product()(3, 4, 5));
    }

    public function test_supports_product_computation_for_an_empty_list()
    {
        self::assertEquals(1, p\product()());
    }

    public function test_supports_average_computation()
    {
        self::assertEquals(4, p\average()(3, 4, 5));
    }

    public function test_supports_average_computation_for_an_empty_list()
    {
        self::assertEquals(0, p\average()());
    }

    /**
     * @param array $list
     * @dataProvider medianListProvider
     */
    public function test_supports_median_computation_for(array $list, $expected)
    {
        self::assertEquals($expected, p\median()(...$list));
    }

    public function mathBuildersProvider()
    {
        yield from ['addition' => [p\add(3)]];
        yield from ['subsctraction' => [p\substract(3)]];
        yield from ['product' => [p\multiply(3)]];
        yield from ['division' => [p\divide(3)]];
        yield from ['incrementation' => [p\inc()]];
        yield from ['decrementation' => [p\dec()]];
        yield from ['modulo' => [p\modulo(3)]];
        yield from ['modulo remainder' => [p\f_mod(3)]];
        yield from ['sum' => [p\sum()]];
        yield from ['product' => [p\product()]];
        yield from ['average' => [p\average()]];
        yield from ['median' => [p\median()]];
        yield from ['max' => [p\max()]];
        yield from ['min' => [p\min()]];
    }

    public function medianListProvider()
    {
        yield from ['an empty list of values' => [[], 0]];
        yield from ['an odd number of values' => [[5, 2, 1, 3, 4], 3]];
        yield from ['an even number of values' => [[5, 2, 1, 3, 4, 6], 3.5]];
    }
}
