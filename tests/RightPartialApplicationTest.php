<?php

namespace Pitchart\Phunktional\Tests;


use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional as p;
use function Pitchart\Phunktional\Tests\Fixtures\sum;

class RightPartialApplicationTest extends TestCase
{
    public function test_applies_with_no_argument()
    {
        $minus = p\partial_r('Pitchart\Phunktional\Tests\Fixtures\diff');
        self::assertEquals(2, $minus(4, 2));
    }

    public function test_applies_with_one_argument()
    {
        $minusTwo = p\partial_r('Pitchart\Phunktional\Tests\Fixtures\diff', 2);
        self::assertEquals(2, $minusTwo(4));
    }

    public function test_applies_with_all_arguments()
    {
        $complete = p\partial_r('Pitchart\Phunktional\Tests\Fixtures\diff', 4, 2);
        self::assertEquals(2, $complete());
    }

    public function test_applies_with_placeholder()
    {
        $partial = p\partial_r('Pitchart\Phunktional\Tests\Fixtures\diff', 4, p\_());
        self::assertEquals(2, $partial(2));
    }

    public function test_preserves_placeholders_position()
    {
        $partial = p\partial_r('implode', ['a', 'b', 'c'], p\_());
        self::assertEquals('a-b-c', $partial('-'));

        $partial = p\partial_r('implode', p\_(), ',');
        self::assertEquals('a,b,c', $partial(['a', 'b', 'c']));
    }

    public function test_preserves_functions_arguments_integrity()
    {
        $partial = p\partial_r('Pitchart\Phunktional\Tests\Fixtures\sum', 2, p\_());

        self::expectException(p\Partial\ArgumentCountError::class);
        $partial();
    }

}
