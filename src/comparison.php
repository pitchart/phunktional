<?php

namespace Pitchart\Phunktional;

const equals = '\Pitchart\Phunktional\equals';
const different = '\Pitchart\Phunktional\different';
const lt = '\Pitchart\Phunktional\lt';
const lte = '\Pitchart\Phunktional\lte';
const gt = '\Pitchart\Phunktional\gt';
const gte = '\Pitchart\Phunktional\gte';
const even = '\Pitchart\Phunktional\even';
const odd = '\Pitchart\Phunktional\odd';

/**
 * @param $value
 *
 * @return \Closure
 */
function equals($value) {
    return function ($compared) use ($value) {
        return $compared === $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function different($value) {
    return function ($compared) use ($value) {
        return $compared !== $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function lt($value) {
    return function ($compared) use ($value) {
        return $compared < $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function lte($value) {
    return function ($compared) use ($value) {
        return $compared <= $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function gt($value) {
    return function ($compared) use ($value) {
        return $compared > $value;
    };
}

/**
 * @param $value
 *
 * @return \Closure
 */
function gte($value) {
    return function ($compared) use ($value) {
        return $compared >= $value;
    };
}

/**
 * @return \Closure
 */
function even() {
    return function ($compared) {
        return $compared % 2 == 0;
    };
}

/**
 * @return \Closure
 */
function odd() {
    return function ($compared) {
        return $compared % 2 != 0;
    };
}
