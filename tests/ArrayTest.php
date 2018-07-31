<?php

namespace Pitchart\Phunktional\Tests;


use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional as p;

class ArrayTest extends TestCase
{
    private $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

    public function test_supports_mapping()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $mapping = p\map(function (int $item) { return $item + 1; });

        self::assertEquals([2, 4, 6, 10, 7, 5, 3, 4, 6, 7, 3], $mapping($array));
    }

    public function test_supports_filtering()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $filter = p\filter(function (int $item) { return $item %2 == 0; });

        self::assertEquals([6, 4, 2, 6, 2], array_values($filter($array)));
    }

    public function test_supports_rejection()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $rejection = p\reject(function (int $item) { return $item %2 == 0; });

        self::assertEquals([1, 3, 5, 9, 3, 5], array_values($rejection($array)));
    }

    public function test_supports_taking_the_firsts_elements()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $firsts = p\take(5);

        self::assertEquals([1, 3, 5, 9, 6], $firsts($array));
    }

    public function test_supports_tailing()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([3, 5, 9, 6, 4, 2, 3, 5, 6, 2], p\tail()($array));
    }

    public function test_supports_slicing()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $slicing = p\slice(2, 4);

        self::assertEquals([5, 9, 6, 4], $slicing($array));
    }

    public function test_supports_dropping()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $dropping = p\drop(3);

        self::assertEquals([9, 6, 4, 2, 3, 5, 6, 2], $dropping($array));
    }

    public function test_supports_concatenation()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $concatenation = p\concat([1, 2], [3, 4, 5, 6]);

        self::assertEquals([1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2, 1, 2, 3, 4, 5, 6], $concatenation($array));

    }

    public function test_supports_mapping_and_flattening_the_result()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $flatmap = p\flatmap(function (int $item) { return [$item, $item + 1];});

        self::assertEquals([1, 2, 3, 4, 5, 6, 9, 10, 6, 7, 4, 5, 2, 3, 3, 4, 5, 6, 6, 7, 2, 3], $flatmap($array));
    }

    public function test_supports_distinct()
    {
        $array = [1, 3, 5, 3, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([1, 3, 5, 9, 6, 4, 2], p\distinct()($array));
    }

    public function test_supports_flatten()
    {
        $array = [1, [2, [3, 4], 5], [[6, 7], 8], [9]];

        self::assertEquals([1, 2, 3, 4, 5, 6, 7, 8, 9], p\flatten()($array));
    }

    public function test_supports_reducing()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $sum = p\reduce(function (int $total, int $number) { return $total + $number; }, 0);

        self::assertEquals(46, $sum($array));
    }

    public function test_supports_intersections()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([1, 5, 9, 5], p\intersect([1, 7, 9, 5])($array));
    }

    public function test_supports_differences()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([3, 6, 4, 2, 3, 6, 2], p\diff([1, 7, 9, 5])($array));
    }

    public function test_supports_union()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        self::assertEquals([1, 3, 5, 9, 6, 4, 2, 7], p\union([1, 7, 9, 5])($array));
    }

    public function test_supports_sorting()
    {
        $array = [1, 3, 5, 9, 6, 4, 2, 3, 5, 6, 2];

        $sorting = p\sort(function (int $first, int $second) {
            if ($first != $second) {
                return $first < $second ? -1 : 1;
            }
            return 0;
        });

        self::assertEquals([1, 2, 2, 3, 3, 4, 5, 5, 6, 6, 9], $sorting($array));
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

        yield from ['filter' => [p\filter($filtering)]];
        yield from ['filter constant' => [(p\filter)($filtering)]];
        yield from ['head' => [p\head()]];
        yield from ['head constant' => [(p\head)()]];
        yield from ['take' => [p\take(2)]];
        yield from ['take constant' => [(p\take)(2)]];
        yield from ['tail' => [p\tail()]];
        yield from ['tail constant' => [(p\tail)()]];
        yield from ['slice' => [p\slice(2, 5)]];
        yield from ['slice constant' => [(p\slice)(2, 5)]];
        yield from ['drop' => [p\drop(3)]];
        yield from ['drop constant' => [(p\drop)(3)]];
        yield from ['concat' => [p\concat([1, 2, 3])]];
        yield from ['concat constant' => [(p\concat)([1, 2, 3])]];
        yield from ['flatmap' => [p\flatmap($mapping)]];
        yield from ['flatmap constant' => [(p\flatmap)($mapping)]];
        yield from ['distinct' => [p\distinct()]];
        yield from ['distinct constant' => [(p\distinct)()]];
        yield from ['flatten' => [p\flatten()]];
        yield from ['flatten constant' => [(p\flatten)()]];
        yield from ['reduce' => [p\reduce(function ($carry, $item) { return $carry + $item; }, 0)]];
        yield from ['reduce constant' => [(p\reduce)(function ($carry, $item) { return $carry + $item; }, 0)]];
        yield from ['intersect' => [p\intersect([1, 2, 3])]];
        yield from ['intersect constant' => [(p\intersect)([1, 2, 3])]];
        yield from ['diff' => [p\diff([1, 2, 3])]];
        yield from ['diff constant' => [(p\diff)([1, 2, 3])]];
        yield from ['union' => [p\union([1, 2, 3])]];
        yield from ['union constant' => [(p\union)([1, 2, 3])]];
        yield from ['map' => [p\map($mapping)]];
        yield from ['map constant' => [(p\map)($mapping)]];
        yield from ['reject' => [p\filter($filtering)]];
        yield from ['reject constant' => [(p\filter)($filtering)]];
        yield from ['sort' => [p\sort(function (int $a, int $b) { return $a > $b ? 1 : ($b > $a ? -1 : 0); })]];
        yield from ['sort constant' => [(p\sort)(function (int $a, int $b) { return $a > $b ? 1 : ($b > $a ? -1 : 0); })]];
    }
}
