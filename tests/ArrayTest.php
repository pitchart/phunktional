<?php

namespace Pitchart\Phunktional\Tests;


use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional as p;
use Pitchart\Phunktional\Arrays as a;
use Pitchart\Phunktional\Comparison as comp;

class ArrayTest extends TestCase
{
    private $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

    public function test_supports_mapping()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $mapping = a\map(function (int $item) { return $item + 1; });

        self::assertEquals([2, 4, 6, 10, 7, 5, 3, 4, 6, 7, 3], $mapping($array));
    }

    public function test_supports_filtering()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $filter = a\filter(function (int $item) { return $item %2 == 0; });

        self::assertEquals([6, 4, 2, 6, 2], array_values($filter($array)));
    }

    public function test_supports_rejection()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $rejection = a\reject(function (int $item) { return $item %2 == 0; });

        self::assertEquals([1, 3, 5, 9, 3, 5], array_values($rejection($array)));
    }

    public function test_supports_taking_the_firsts_elements()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $firsts = a\take(5);

        self::assertEquals([1, 3, 5, 9, 6], $firsts($array));
    }

    public function test_supports_taking_the_firsts_elements_while_a_callback_is_true()
    {
        $array = [1, 2, 3, 4 ,5 , 6];

        $firsts = a\take_while(comp\lt(4));

        self::assertEquals([1, 2, 3], $firsts($array));
    }

    public function test_supports_taking_the_nth_elements()
    {
        $array = [1, 2, 3, 4 ,5 , 6, 7, 8, 9];

        $nth = a\take_nth(3);

        self::assertEquals([3, 6, 9], $nth($array));

        $nth = a\take_nth(2);

        self::assertEquals([2, 4, 6, 8], $nth($array));

        $nth = a\take_nth(2, 1);

        self::assertEquals([1, 3, 5, 7, 9], $nth($array));
    }

    public function test_supports_taking_the_lasts_elements()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $lasts = a\lasts(5);

        self::assertEquals([2, 3, 5, 6, 2], $lasts($array));
    }

    public function test_supports_removing_last_element()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([1, 3, 5, 9, 6, 4, 2, 3, 5, 6], a\pop()($array));
    }

    public function test_heads_first_value()
    {
        self::assertEquals(2, a\head()([2, 4, 6, 8]));
    }

    public function test_supports_tailing()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([3, 5, 9, 6, 4, 2, 3, 5, 6, 2], a\tail()($array));
    }

    public function test_supports_slicing()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $slicing = a\slice(2, 4);

        self::assertEquals([5, 9, 6, 4], $slicing($array));
    }

    public function test_supports_dropping()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $dropping = a\drop(3);

        self::assertEquals([9, 6, 4, 2, 3, 5, 6, 2], $dropping($array));
    }

    public function test_supports_dropping_first_elements_with_a_callback()
    {
        $array = [1, 2, 3, 9, 6, 4, 2, 3, 5, 6, 2];

        $dropping = a\drop_while(comp\lt(8));

        self::assertEquals([9, 6, 4, 2, 3, 5, 6, 2], $dropping($array));
    }

    public function test_supports_concatenation()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $concatenation = a\concat([1, 2], [3, 4, 5, 6]);

        self::assertEquals([1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2, 1, 2, 3, 4, 5, 6], $concatenation($array));

    }

    public function test_supports_mapping_and_flattening_the_result()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $flatmap = a\flatmap(function (int $item) { return [$item, $item + 1];});

        self::assertEquals([1, 2, 3, 4, 5, 6, 9, 10, 6, 7, 4, 5, 2, 3, 3, 4, 5, 6, 6, 7, 2, 3], $flatmap($array));
    }

    public function test_supports_distinct()
    {
        $array = [1, 3, 5, 3, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([1, 3, 5, 9, 6, 4, 2], a\distinct()($array));
    }

    public function test_supports_flatten()
    {
        $array = [1, [2, [3, 4], 5], [[6, 7], 8], [9]];

        self::assertEquals([1, 2, 3, 4, 5, 6, 7, 8, 9], a\flatten()($array));
    }

    public function test_supports_reducing()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $sum = a\reduce(function (int $total, int $number) { return $total + $number; }, 0);

        self::assertEquals(46, $sum($array));
    }

    public function test_supports_intersections()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([1, 5, 9, 5], a\intersect([1, 7, 9, 5])($array));
    }

    public function test_supports_intersections_with_comparison_function()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([1, 5, 9, 5], a\intersect([1, 7, 9, 5], comp\comparator(function ($item) { return $item + 1; }))($array));
    }

    public function test_supports_differences()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([3, 6, 4, 2, 3, 6, 2], a\diff([1, 7, 9, 5], comp\comparator(function ($item) { return $item + 1; }))($array));
    }

    public function test_supports_differences_with_comparison_function()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([3, 6, 4, 2, 3, 6, 2], a\diff([1, 7, 9, 5])($array));
    }

    public function test_supports_union()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([1, 3, 5, 9, 6, 4, 2, 7], a\union([1, 7, 9, 5])($array));
    }

    public function test_supports_sorting()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $sorting = a\sort(function (int $first, int $second) {
            if ($first != $second) {
                return $first < $second ? -1 : 1;
            }
            return 0;
        });

        self::assertEquals([1, 2, 2, 3, 3, 4, 5, 5, 6, 6, 9], $sorting($array));
    }

    public function test_supports_partitioning()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([[1, 3, 5], [9, 6, 4], [2, 3, 5], [6, 2]], a\partition(3)($array));
    }

    public function test_supports_reversing()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([2, 6, 5, 3, 2, 4, 6, 9, 5, 3, 1], a\reverse()($array));
    }

    public function test_supports_padding()
    {
        $array = [1, 2, 3];

        self::assertEquals([1, 2, 3, 4, 4, 4, 4, 4, 4, 4], a\pad(10, 4)($array));
    }

    public function test_supports_grouping()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([[3, 9, 6, 3, 6], [1, 4], [5, 2, 5, 2]], a\group_by(p\Math\modulo(3))($array));
    }

    /**
     * @param $function
     * @dataProvider arrayFunctionsBuildersProvider
     */
    public function test_has_superior_order_function_builder_for($function)
    {
        self::assertTrue(is_callable($function));
    }

    /**
     * @param $function
     * @dataProvider arrayFunctionsBuildersProvider
     */
    public function test_transformation_is_immutable_for($function)
    {
        $copy = $this->array;

        $transformed = $function($this->array);

        self::assertEquals($copy, $this->array);
    }

    public function arrayFunctionsBuildersProvider()
    {
        $mapping = function ($item) { return $item + 1; };
        $filtering = function ($item) { return $item > 0; };

        yield from ['filter' => [a\filter($filtering)]];
        yield from ['filter constant' => [(a\filter)($filtering)]];
        yield from ['head' => [a\head()]];
        yield from ['head constant' => [(a\head)()]];
        yield from ['slice' => [a\slice(2, 5)]];
        yield from ['slice constant' => [(a\slice)(2, 5)]];
        yield from ['take' => [a\take(2)]];
        yield from ['take constant' => [(a\take)(2)]];
        yield from ['lasts' => [a\lasts(2)]];
        yield from ['lasts constant' => [(a\lasts)(2)]];
        yield from ['tail' => [a\tail()]];
        yield from ['tail constant' => [(a\tail)()]];
        yield from ['drop' => [a\drop(3)]];
        yield from ['drop constant' => [(a\drop)(3)]];
        yield from ['concat' => [a\concat([1, 2, 3])]];
        yield from ['concat constant' => [(a\concat)([1, 2, 3])]];
        yield from ['flatmap' => [a\flatmap($mapping)]];
        yield from ['flatmap constant' => [(a\flatmap)($mapping)]];
        yield from ['distinct' => [a\distinct()]];
        yield from ['distinct constant' => [(a\distinct)()]];
        yield from ['flatten' => [a\flatten()]];
        yield from ['flatten constant' => [(a\flatten)()]];
        yield from ['reduce' => [a\reduce(function ($carry, $item) { return $carry + $item; }, 0)]];
        yield from ['reduce constant' => [(a\reduce)(function ($carry, $item) { return $carry + $item; }, 0)]];
        yield from ['intersect' => [a\intersect([1, 2, 3])]];
        yield from ['intersect constant' => [(a\intersect)([1, 2, 3])]];
        yield from ['diff' => [a\diff([1, 2, 3])]];
        yield from ['diff constant' => [(a\diff)([1, 2, 3])]];
        yield from ['union' => [a\union([1, 2, 3])]];
        yield from ['union constant' => [(a\union)([1, 2, 3])]];
        yield from ['map' => [a\map($mapping)]];
        yield from ['map constant' => [(a\map)($mapping)]];
        yield from ['reject' => [a\filter($filtering)]];
        yield from ['reject constant' => [(a\filter)($filtering)]];
        yield from ['sort' => [a\sort(function (int $a, int $b) { return $a > $b ? 1 : ($b > $a ? -1 : 0); })]];
        yield from ['sort constant' => [(a\sort)(function (int $a, int $b) { return $a > $b ? 1 : ($b > $a ? -1 : 0); })]];
        yield from ['reverse' => [a\reverse()]];
        yield from ['reverse constant' => [(a\reverse)()]];
        yield from ['pad' => [a\pad(10, 0)]];
        yield from ['pad constant' => [(a\pad)(10, 0)]];
    }
}
