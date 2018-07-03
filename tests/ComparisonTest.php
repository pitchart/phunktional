<?php

namespace Pitchart\Phunktional\Tests;

use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional as p;
use Pitchart\Phunktional\Tests\Mixins\Comparison as Features;

class ComparisonTest extends TestCase
{
    use Features\Equality,
        Features\Inferiority,
        Features\Superiority
    ;

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
        yield from ['equal' => [p\equals(12)]];
        yield from ['not' => [p\not()]];
        yield from ['inferior' => [p\lt(12)]];
        yield from ['inferior or equal' => [p\lte(12)]];
        yield from ['superior' => [p\gt(12)]];
        yield from ['superior or equal' => [p\gte(12)]];
    }
}
