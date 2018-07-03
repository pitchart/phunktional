<?php

namespace Pitchart\Phunktional\Tests\Mixins\Comparison;

use Pitchart\Phunktional as p;

trait Superiority
{
    /**
     * @param $compared
     * @param $value
     * @param $expected
     * @param $strictExpected
     * @dataProvider superiorityProvider
     */
    public function test_compares_strict_superiority_for($value, $reference, $expected, $strictExpected)
    {
        self::assertEquals($strictExpected, p\gt($reference)($value));
    }

    /**
     * @param $compared
     * @param $value
     * @param $expected
     * @param $strictExpected
     * @dataProvider superiorityProvider
     */
    public function test_compares_superiority_for($value, $reference, $expected, $strictExpected)
    {
        self::assertEquals($expected, p\gte($reference)($value));
    }

    public function superiorityProvider()
    {
        yield from ['value inferior to reference' => ['$value' => 6, '$reference' => 7, '$expected' => false, '$strictExpected' => false]];
        yield from ['value equal to reference' => ['$value' => 6, '$reference' => 6, '$expected' => true, '$strictExpected' => false]];
        yield from ['value superior to reference' => ['$value' => 6, '$reference' => 5, '$expected' => true, '$strictExpected' => true]];
    }
}
