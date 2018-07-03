<?php

namespace Pitchart\Phunktional\Tests\Mixins\Comparison;

use Pitchart\Phunktional as p;

trait Inferiority
{
    /**
     * @param $compared
     * @param $value
     * @param $expected
     * @param $strictExpected
     * @dataProvider inferiorityProvider
     */
    public function test_compares_strict_inferiority_for($value, $reference, $expected, $strictExpected)
    {
        self::assertEquals($strictExpected, p\lt($reference)($value));
    }

    /**
     * @param $compared
     * @param $value
     * @param $expected
     * @param $strictExpected
     * @dataProvider inferiorityProvider
     */
    public function test_compares_inferiority_for($value, $reference, $expected, $strictExpected)
    {
        self::assertEquals($expected, p\lte($reference)($value));
    }

    public function inferiorityProvider()
    {
        yield from ['value inferior to reference' => ['$value' => 6, '$reference' => 7, '$expected' => true, '$strictExpected' => true]];
        yield from ['value equal to reference' => ['$value' => 6, '$reference' => 6, '$expected' => true, '$strictExpected' => false]];
        yield from ['value superior to reference' => ['$value' => 6, '$reference' => 5, '$expected' => false, '$strictExpected' => false]];
    }
}
