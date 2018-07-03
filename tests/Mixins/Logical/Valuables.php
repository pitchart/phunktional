<?php

namespace Pitchart\Phunktional\Tests\Mixins\Logical;

use Pitchart\Phunktional as p;

trait Valuables
{
    /**
     * @param $value
     * @dataProvider valuesProvider
     */
    public function test_T_is_always_true($value)
    {
        self::assertTrue(p\T()($value));
    }

    /**
     * @param $value
     * @dataProvider valuesProvider
     */
    public function test_F_is_always_false($value)
    {
        self::assertFalse(p\F()($value));
    }

    /**
     * @param $value
     * @dataProvider valuesProvider
     */
    public function test_same_returns_same_value($value)
    {
        self::assertEquals($value, p\same()($value));
    }

    /**
     * @param $value
     * @dataProvider valuesProvider
     */
    public function test_not_returns_logical_complement_of_a_value($value)
    {
        if ($value) {
            self::assertFalse(p\not()($value));
        }
        else {
            self::assertTrue(p\not()($value));
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
        self::assertEquals($and, p\_and($b)($a));
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
        self::assertEquals($or, p\_or($b)($a));
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
        self::assertEquals(p\not()(p\_and($b)($a)), p\_or(p\not()($b))(p\not()($a)));
        self::assertEquals(p\not()(p\_or($b)($a)), p\_and(p\not()($b))(p\not()($a)));
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
        foreach ([p\T(), p\F()] as $a) {
            foreach ([p\T(), p\F()] as $b) {
                foreach ([p\T(), p\F()] as $c) {
                    list($x, $y, $z) = [$a(), $b(), $c()];
                    yield from [sprintf('Associativity of OR with %s %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false', $z ? 'true' : 'false') => [p\_or(p\_or($z)($y))($x), p\_or(p\_or($x)($y))($z)]];
                    yield from [sprintf('Associativity of AND with %s %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false', $z ? 'true' : 'false') => [p\_and(p\_and($z)($y))($x), p\_and(p\_and($x)($y))($z)]];
                    yield from [sprintf('Distributivity of AND over OR with %s %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false', $z ? 'true' : 'false') => [p\_and(p\_or($z)($y))($x), p\_or(p\_and($x)($y))(p\_and($x)($z))]];
                    yield from [sprintf('Distributivity of OR over AND with %s %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false', $z ? 'true' : 'false') => [p\_or(p\_and($z)($y))($x), p\_and(p\_or($x)($y))(p\_or($x)($z))]];
                }
                list($x, $y) = [$a(), $b()];
                yield from [sprintf('Commutativity of OR with %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false') => [p\_or($y)($x), p\_or($x)($y)]];
                yield from [sprintf('Commutativity of AND with %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false') => [p\_and($y)($x), p\_and($x)($y)]];
                yield from [sprintf('Absorption 1 with %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false') => [p\_and(p\_or($y)($x))($x), $x]];
                yield from [sprintf('Absorption 2 with %s %s', $x ? 'true' : 'false', $y ? 'true' : 'false') => [p\_or(p\_and($y)($x))($x), $x]];
            }
            $x = $a();
            yield from [sprintf('Identity for OR with %s', $x ? 'true' : 'false') => [p\_or(false)($x), $x]];
            yield from [sprintf('Identity for AND with %s', $x ? 'true' : 'false') => [p\_and(true)($x), $x]];
            yield from [sprintf('Annihilator for OR with %s', $x ? 'true' : 'false') => [p\_or(true)($x), true]];
            yield from [sprintf('Annihilator for AND with %s', $x ? 'true' : 'false') => [p\_and(false)($x), false]];
            yield from [sprintf('Idempotence of OR with %s', $x ? 'true' : 'false') => [p\_or($x)($x), $x]];
            yield from [sprintf('Idempotence of AND with %s', $x ? 'true' : 'false') => [p\_and($x)($x), $x]];
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
