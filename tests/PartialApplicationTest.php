<?php

namespace Pitchart\Phunktional\Tests;


use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional as p;
use function Pitchart\Phunktional\Tests\Fixtures\sum;

class PartialApplicationTest extends TestCase
{
    public function test_applies_with_no_argument()
    {
        $sum = p\partial('Pitchart\Phunktional\Tests\Fixtures\sum');
        self::assertEquals(6, $sum(2, 4));
    }

    public function test_applies_with_one_argument()
    {
        $plusTwo = p\partial('Pitchart\Phunktional\Tests\Fixtures\sum', 2);
        self::assertEquals(6, $plusTwo(4));
    }

    public function test_applies_with_all_arguments()
    {
        $complete = p\partial('Pitchart\Phunktional\Tests\Fixtures\sum', 2, 4);
        self::assertEquals(6, $complete());
    }

    public function test_applies_with_placeholder()
    {
        $partial = p\partial('Pitchart\Phunktional\Tests\Fixtures\sum', 2, p\_());
        self::assertEquals(6, $partial(4));
    }

    public function test_preserves_placeholders_position()
    {
        $partial = p\partial('implode', p\_(), ['a', 'b', 'c']);
        self::assertEquals('a-b-c', $partial('-'));

        $partial = p\partial('implode', ',', p\_());
        self::assertEquals('a,b,c', $partial(['a', 'b', 'c']));
    }

    public function test_preserves_functions_arguments_integrity()
    {
        $partial = p\partial('Pitchart\Phunktional\Tests\Fixtures\sum', 2, p\_());

        self::expectException(p\Partial\ArgumentCountError::class);
        $partial();
    }

}
