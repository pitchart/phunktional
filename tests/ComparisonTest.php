<?php

namespace Pitchart\Phunktional\Tests;

use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional as p;
use Pitchart\Phunktional\Comparison as comp;
use Pitchart\Phunktional\Logical as l;
use Pitchart\Phunktional\Tests\Mixins\Comparison as Features;

class ComparisonTest extends TestCase
{
    use Features\Equality,
        Features\Inferiority,
        Features\Superiority
    ;

    public function test_creates_comparison_function_from_a_callable()
    {
        $comparator = comp\comparator(function (int $item) {
            return $item;
        });

        $array = [5, 2, 4, 3, 1];

        usort($array, $comparator);

        self::assertEquals([1, 2, 3, 4, 5], $array);
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
        yield from ['equal' => [comp\equals(12)]];
        yield from ['equal constant' => [(comp\equals)(12)]];
        yield from ['different' => [comp\different(12)]];
        yield from ['different constant' => [(comp\different)(12)]];
        yield from ['inferior' => [comp\lt(12)]];
        yield from ['inferior constant' => [(comp\lt)(12)]];
        yield from ['inferior or equal' => [comp\lte(12)]];
        yield from ['inferior or equal constant' => [(comp\lte)(12)]];
        yield from ['superior' => [comp\gt(12)]];
        yield from ['superior constant' => [(comp\gt)(12)]];
        yield from ['superior or equal' => [comp\gte(12)]];
        yield from ['superior or equal constant' => [(comp\gte)(12)]];
        yield from ['even' => [comp\even()]];
        yield from ['even constant' => [(comp\even)()]];
        yield from ['odd' => [comp\odd()]];
        yield from ['odd constant' => [(comp\odd)()]];
        yield from ['comparator' => [comp\comparator(l\same())]];
        yield from ['comparator constant' => [(comp\comparator)(l\same())]];
    }
}
