<?php

namespace Pitchart\Phunktional\Tests\Mixins\Logical;

use Pitchart\Phunktional as p;
use Pitchart\Phunktional\Logical as l;

trait Functionables
{
    /**
     * @param boolean $a
     * @param boolean $b
     * @param boolean $and
     * @param boolean $or
     * @dataProvider logicalLawsForFunctionProvider
     */
    public function test_respects_logical_laws_for_all($a, $b, $and, $or)
    {
        self::assertEquals($and, l\all($a, $b)(true));
    }

    /**
     * @param boolean $a
     * @param boolean $b
     * @param boolean $and
     * @param boolean $or
     * @dataProvider logicalLawsForFunctionProvider
     */
    public function test_respects_logical_laws_for_some($a, $b, $and, $or)
    {
        self::assertEquals($or, l\some($b, $a)(true));
    }

    /**
     * @param boolean $a
     * @param boolean $b
     * @param boolean $and
     * @param boolean $or
     * @dataProvider logicalLawsForFunctionProvider
     */
    public function test_respects_associativity_for_functions($a, $b, $and, $or)
    {
        self::assertEquals(l\complement(l\all($b, $a))(true), l\some(l\complement($b), l\complement($a))(true));
        self::assertEquals(l\complement(l\some($b, $a))(true), l\all(l\complement($b), l\complement($a))(true));
    }

    public function test_complement_returns_logical_complement_of_a_function()
    {
        self::assertEquals(l\T()(true), l\complement(l\F())(true));
        self::assertEquals(l\F()(true), l\complement(l\T())(true));
    }

    /**
     * @param $operation
     * @param $expected
     * @dataProvider booleanLawsFunctionsProvider
     */
    public function test_respects_boolean_laws_for_functions($operation, $expected)
    {
        self::assertEquals($expected(true), $operation(true));
        self::assertEquals($expected(false), $operation(false));
    }

    public function booleanLawsFunctionsProvider()
    {
        foreach ([l\T(), l\F()] as $a) {
            foreach ([l\T(), l\F()] as $b) {
                foreach ([l\T(), l\F()] as $c) {
                    list($x, $y, $z) = [$a, $b, $c];
                    yield from [sprintf('Associativity of OR with [%s, %s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false', $z() ? 'true' : 'false') => [l\some($x, l\some($y, $z)), l\some(l\some($x, $y), $z)]];
                    yield from [sprintf('Associativity of AND with [%s, %s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false', $z() ? 'true' : 'false') => [l\all($x, l\all($y, $z)), l\all(l\all($x, $y), $z)]];
                    yield from [sprintf('Distributivity of AND over OR with [%s, %s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false', $z() ? 'true' : 'false') => [l\all($x, l\some($y, $z)), l\some(l\all($x, $y), l\all($x, $z))]];
                    yield from [sprintf('Distributivity of OR over AND with [%s, %s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false', $z() ? 'true' : 'false') => [l\some($x, l\all($y, $z)), l\all(l\some($x, $y), l\some($x, $z))]];
                }
                list($x, $y) = [$a, $b];
                yield from [sprintf('Commutativity of OR with [%s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false') => [l\some($x, $y), l\some($y, $x)]];
                yield from [sprintf('Commutativity of AND with [%s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false') => [l\all($y, $x), l\all($x, $y)]];
                yield from [sprintf('Absorption 1 with [%s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false') => [l\all($x, l\some($x, $y)), $x]];
                yield from [sprintf('Absorption 2 with [%s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false') => [l\some($x, l\all($x, $y)), $x]];
            }
            $x = $a;
            yield from [sprintf('Identity for OR with %s', $x() ? 'true' : 'false') => [l\some($x, l\F()), $x]];
            yield from [sprintf('Identity for AND with %s', $x() ? 'true' : 'false') => [l\all($x, l\T()), $x]];
            yield from [sprintf('Annihilator for OR with %s', $x() ? 'true' : 'false') => [l\some($x, l\T()), l\T()]];
            yield from [sprintf('Annihilator for AND with %s', $x() ? 'true' : 'false') => [l\all($x, l\F()), l\F()]];
            yield from [sprintf('Idempotence of OR with %s', $x() ? 'true' : 'false') => [l\some($x, $x), $x]];
            yield from [sprintf('Idempotence of AND with %s', $x() ? 'true' : 'false') => [l\all($x, $x), $x]];
        }
    }

    public function logicalLawsForFunctionProvider()
    {
        yield from ['[true, true]' => ['$a' => l\T(), '$b' => l\T(), '$and' => true, '$or' => true]];
        yield from ['[false, true]' => ['$a' => l\F(), '$b' => l\T(), '$and' => false, '$or' => true]];
        yield from ['[true, false]' => ['$a' => l\T(), '$b' => l\F(), '$and' => false, '$or' => true]];
        yield from ['[false, false]' => ['$a' => l\F(), '$b' => l\F(), '$and' => false, '$or' => false]];
    }
}
