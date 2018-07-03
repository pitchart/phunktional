<?php

namespace Pitchart\Phunktional\Tests\Mixins\Logical;

use Pitchart\Phunktional as p;

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
        self::assertEquals($and, p\all($a, $b)(true));
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
        self::assertEquals($or, p\some($b, $a)(true));
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
        self::assertEquals(p\complement(p\all($b, $a))(true), p\some(p\complement($b), p\complement($a))(true));
        self::assertEquals(p\complement(p\some($b, $a))(true), p\all(p\complement($b), p\complement($a))(true));
    }

    public function test_complement_returns_logical_complement_of_a_function()
    {
        self::assertEquals(p\T()(true), p\complement(p\F())(true));
        self::assertEquals(p\F()(true), p\complement(p\T())(true));
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
        foreach ([p\T(), p\F()] as $a) {
            foreach ([p\T(), p\F()] as $b) {
                foreach ([p\T(), p\F()] as $c) {
                    list($x, $y, $z) = [$a, $b, $c];
                    yield from [sprintf('Associativity of OR with [%s, %s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false', $z() ? 'true' : 'false') => [p\some($x, p\some($y, $z)), p\some(p\some($x, $y), $z)]];
                    yield from [sprintf('Associativity of AND with [%s, %s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false', $z() ? 'true' : 'false') => [p\all($x, p\all($y, $z)), p\all(p\all($x, $y), $z)]];
                    yield from [sprintf('Distributivity of AND over OR with [%s, %s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false', $z() ? 'true' : 'false') => [p\all($x, p\some($y, $z)), p\some(p\all($x, $y), p\all($x, $z))]];
                    yield from [sprintf('Distributivity of OR over AND with [%s, %s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false', $z() ? 'true' : 'false') => [p\some($x, p\all($y, $z)), p\all(p\some($x, $y), p\some($x, $z))]];
                }
                list($x, $y) = [$a, $b];
                yield from [sprintf('Commutativity of OR with [%s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false') => [p\some($x, $y), p\some($y, $x)]];
                yield from [sprintf('Commutativity of AND with [%s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false') => [p\all($y, $x), p\all($x, $y)]];
                yield from [sprintf('Absorption 1 with [%s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false') => [p\all($x, p\some($x, $y)), $x]];
                yield from [sprintf('Absorption 2 with [%s, %s]', $x() ? 'true' : 'false', $y() ? 'true' : 'false') => [p\some($x, p\all($x, $y)), $x]];
            }
            $x = $a;
            yield from [sprintf('Identity for OR with %s', $x() ? 'true' : 'false') => [p\some($x, p\F()), $x]];
            yield from [sprintf('Identity for AND with %s', $x() ? 'true' : 'false') => [p\all($x, p\T()), $x]];
            yield from [sprintf('Annihilator for OR with %s', $x() ? 'true' : 'false') => [p\some($x, p\T()), p\T()]];
            yield from [sprintf('Annihilator for AND with %s', $x() ? 'true' : 'false') => [p\all($x, p\F()), p\F()]];
            yield from [sprintf('Idempotence of OR with %s', $x() ? 'true' : 'false') => [p\some($x, $x), $x]];
            yield from [sprintf('Idempotence of AND with %s', $x() ? 'true' : 'false') => [p\all($x, $x), $x]];
        }
    }

    public function logicalLawsForFunctionProvider()
    {
        yield from ['[true, true]' => ['$a' => p\T(), '$b' => p\T(), '$and' => true, '$or' => true]];
        yield from ['[false, true]' => ['$a' => p\F(), '$b' => p\T(), '$and' => false, '$or' => true]];
        yield from ['[true, false]' => ['$a' => p\T(), '$b' => p\F(), '$and' => false, '$or' => true]];
        yield from ['[false, false]' => ['$a' => p\F(), '$b' => p\F(), '$and' => false, '$or' => false]];
    }
}
