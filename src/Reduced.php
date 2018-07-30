<?php

namespace Pitchart\Phunktional;

class Reduced
{
    private $value;

    /**
     * Reduced constructor.
     *
     * @param $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
