<?php

namespace Pitchart\Phunktional\Tests;

use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional as p;
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
        yield from ['true' => [p\T()]];
        yield from ['false' => [p\F()]];
        yield from ['not' => [p\not()]];
        yield from ['same' => [p\same()]];
        yield from ['and' => [p\_and(true)]];
        yield from ['or' => [p\_or(false)]];
        yield from ['all' => [p\all(p\gt(12))]];
        yield from ['some' => [p\some(p\gt(12))]];
        yield from ['complement' => [p\complement(p\gt(12))]];
    }
}
