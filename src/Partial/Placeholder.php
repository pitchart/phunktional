<?php

namespace Pitchart\Phunktional\Partial;

final class Placeholder
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function get()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function shift(array &$args, $position)
    {
        if (\count($args) === 0) {
            throw new ArgumentCountError(
                \sprintf('Cannot resolve parameter placeholder at position %d. Missing function argument.', $position)
            );
        }
        return \array_shift($args);
    }

    public static function resolve(array &$stored, array &$invoked)
    {
        foreach ($stored as $position => &$param) {
            if ($param instanceof Placeholder) {
                $param = $param->shift($invoked, $position);
            }
        }
    }
}
