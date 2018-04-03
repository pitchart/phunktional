<?php

namespace Pitchart\Phunktional;

/**
 * @param $value
 * @param \callable[] ...$functions
 *
 * @return Pipeline
 */
function pipe($value = null, callable ...$functions)
{
    return new Pipeline($value, new Composition(...\array_reverse($functions)));
}
