<?php

namespace Pitchart\Phunktional;

/**
 * Class Pipeline
 *
 * @package Pitchart\Phunktional
 *
 * @author Julien VITTE <vitte.julien@gmail.fr>
 */
class Pipeline
{
    /**
     * @var Composition
     */
    private $composition;

    /**
     * @var mixed
     */
    private $value;

    /**
     * Pipeline constructor.
     *
     * @param null $value
     * @param Composition|null $composition
     */
    public function __construct($value = null, Composition $composition = null)
    {
        $this->composition = $composition ?? new Composition();
        $this->value = $value;
    }

    /**
     * @param \callable[] ...$callable
     *
     * @return Pipeline
     */
    public function bind(callable ...$callable)
    {
        $callable[] = $this->composition;
        return new self($this->value, new Composition(...$callable));
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->process($this->value);
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function process($value)
    {
        return $this->composition->__invoke($value);
    }

    /**
     * @return mixed
     */
    public function __invoke($value = null)
    {
        if ($value === null && $this->value) {
            return $this->get();
        }
        return $this->process($value);
    }

}
