<?php

namespace Pitchart\Phunktional\Tests\Mixins\Comparison;

use Pitchart\Phunktional\Comparison as comp;

trait Equality
{
    public function test_equality_is_true_for_same_values()
    {
        self::assertTrue(comp\equals(12)(12));
    }

    public function test_equality_is_false_for_distinct_values()
    {
        self::assertFalse(comp\equals(12)(6));
    }
}
