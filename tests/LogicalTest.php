<?php

namespace Pitchart\Phunktional\Tests;

use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional\Logical as l;
use Pitchart\Phunktional\Comparison as comp;
use Pitchart\Phunktional\Tests\Mixins\Logical as Features;


class LogicalTest extends TestCase
{

    use Features\Valuables,
        Features\Functionables
    ;

    /**
     * @param $function
     * @dataProvider logicalBuildersProvider
     */
    public function test_has_superior_order_function_builder_for($function)
    {
        self::assertTrue(is_callable($function));
    }

    public function logicalBuildersProvider()
    {
        yield from ['true' => [l\T()]];
        yield from ['true constant' => [(l\T)()]];
        yield from ['false' => [l\F()]];
        yield from ['false constant' => [(l\F)()]];
        yield from ['not' => [l\not()]];
        yield from ['not constant' => [(l\not)()]];
        yield from ['same' => [l\same()]];
        yield from ['same constant' => [(l\same)()]];
        yield from ['and' => [l\_and(true)]];
        yield from ['and constant' => [(l\_and)(true)]];
        yield from ['or' => [l\_or(false)]];
        yield from ['or constant' => [(l\_or)(false)]];
        yield from ['all' => [l\all(comp\gt(12))]];
        yield from ['all constant' => [(l\all)(comp\gt(12))]];
        yield from ['some' => [l\some(comp\gt(12))]];
        yield from ['some constant' => [(l\some)(comp\gt(12))]];
        yield from ['complement' => [l\complement(comp\gt(12))]];
        yield from ['complement constant' => [(l\complement)(comp\gt(12))]];
    }
}
