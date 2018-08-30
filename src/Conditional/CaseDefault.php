<?php

namespace Pitchart\Phunktional\Conditional;

final class CaseDefault
{
    final public function __construct()
    {

    }

    public function __invoke($value)
    {
        return new self();
    }
}
