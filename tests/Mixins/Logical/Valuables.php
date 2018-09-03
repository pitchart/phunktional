<?php

namespace Pitchart\Phunktional\Tests\Mixins\Logical;

use Pitchart\Phunktional as p;
use Pitchart\Phunktional\Logical as l;


trait Valuables
{
    /**
     * @param $value
     * @dataProvider valuesProvider
     */
    public function test_T_is_always_true($value)
    {
        self::assertTrue(l\T()($value));
    }

    /**
     * @param $value
     * @dataProvider valuesProvider
     */
    public function test_F_is_always_false($value)
    {
        self::assertFalse(l\F()($value));
    }

    /**
     * @param $value
     * @dataProvider valuesProvider
     */
    public function test_same_returns_same_value($value)
    {
        self::assertEquals($value, l\same()($value));
    }

    /**
     * @param $value
     * @dataProvider valuesProvider
     */
    public function test_not_returns_logical_complement_of_a_value($value)
    {
        if ($value) {
            self::assertFalse(l\not()($value));
        }
        else {
            self::assertTrue(l\not()($value));
        }
    }

    /**
     * @param boolean $a
     * @param boolean $b
     * @param boolean $and
     * @param boolean $or
     * @dataProvider logicalLawsProvider
     */
    public function test_respects_logical_laws_for_conjonction($a, $b, $and, $or)
    {
        self::assertEquals($and, l\_and($b)($a));
    }

    /**
     * @param boolean $a
     * @param boolean $b
     * @param boolean $and
     * @param boolean $or
     * @dataProvider logicalLawsProvider
     */
    public function test_respects_logical_laws_for_disjonction($a, $b, $and, $or)
    {
        self::assertEquals($or, l\_or($b)($a));
    }

    /**
     * @param boolean $a
     * @param boolean $b
     * @param boolean $and
     * @param boolean $or
     * @dataProvider logicalLawsProvider
     */
    public function test_respects_associativity($a, $b, $and, $or)
    {
        self::assertEquals(l\not()(l\_and($b)($a)), l\_or(l\not()($b))(l\not()($a)));
        self::assertEquals(l\not()(l\_or($b)($a)), l\_and(l\not()($b))(l\not()($a)));
    }

    /**
     * @param $operation
     * @param $expected
     * @dataProvider booleanLawsValuesProvider
     */
    public function test_respects_boolean_laws_for_values($operation, $expected)
    {
        self::assertEquals($expected, $operation);
    }

    public function booleanLawsValuesProvider()
    {
        foreach ([l\T(), l\F()] as $a) {
            foreach ([l\T(), l\F()] as $b) {
                foreach ([l\T(), l\F()] as $c) {
                    list($x, $y, $z) = [$a(), $b(), $c()];
                    yield from [sprintf('Associativity of OR with %s %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false', $z ? 'true' : 'false') => [l\_or(l\_or($z)($y))($x), l\_or(l\_or($x)($y))($z)]];
                    yield from [sprintf('Associativity of AND with %s %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false', $z ? 'true' : 'false') => [l\_and(l\_and($z)($y))($x), l\_and(l\_and($x)($y))($z)]];
                    yield from [sprintf('Distributivity of AND over OR with %s %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false', $z ? 'true' : 'false') => [l\_and(l\_or($z)($y))($x), l\_or(l\_and($x)($y))(l\_and($x)($z))]];
                    yield from [sprintf('Distributivity of OR over AND with %s %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false', $z ? 'true' : 'false') => [l\_or(l\_and($z)($y))($x), l\_and(l\_or($x)($y))(l\_or($x)($z))]];
                }
                list($x, $y) = [$a(), $b()];
                yield from [sprintf('Commutativity of OR with %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false') => [l\_or($y)($x), l\_or($x)($y)]];
                yield from [sprintf('Commutativity of AND with %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false') => [l\_and($y)($x), l\_and($x)($y)]];
                yield from [sprintf('Absorption 1 with %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false') => [l\_and(l\_or($y)($x))($x), $x]];
                yield from [sprintf('Absorption 2 with %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false') => [l\_or(l\_and($y)($x))($x), $x]];
            }
            $x = $a();
            yield from [sprintf('Identity for OR with %s', $x ? 'true' : 'false') => [l\_or(false)($x), $x]];
            yield from [sprintf('Identity for AND with %s', $x ? 'true' : 'false') => [l\_and(true)($x), $x]];
            yield from [sprintf('Annihilator for OR with %s', $x ? 'true' : 'false') => [l\_or(true)($x), true]];
            yield from [sprintf('Annihilator for AND with %s', $x ? 'true' : 'false') => [l\_and(false)($x), false]];
            yield from [sprintf('Idempotence of OR with %s', $x ? 'true' : 'false') => [l\_or($x)($x), $x]];
            yield from [sprintf('Idempotence of AND with %s', $x ? 'true' : 'false') => [l\_and($x)($x), $x]];
        }
    }

    public function valuesProvider()
    {
        yield from ['true' => [true]];
        yield from ['false' => [false]];
        yield from ['zero' => [0]];
        yield from ['non zero number' => [2]];
        yield from ['empty string' => ['']];
        yield from ['string' => ['string']];
        yield from ['null' => [null]];
    }

    public function logicalLawsProvider()
    {
        yield from ['true && true' => ['$a' => true, '$b' => true, '$and' => true, '$or' => true]];
        yield from ['false && true' => ['$a' => false, '$b' => true, '$and' => false, '$or' => true]];
        yield from ['true && false' => ['$a' => true, '$b' => false, '$and' => false, '$or' => true]];
        yield from ['false && false' => ['$a' => false, '$b' => false, '$and' => false, '$or' => false]];
    }
}
