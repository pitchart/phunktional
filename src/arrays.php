<?php

namespace Pitchart\Phunktional;

const filter = '\Pitchart\Phunktional\filter';
const head = '\Pitchart\Phunktional\head';
const take = '\Pitchart\Phunktional\take';
const tail = '\Pitchart\Phunktional\tail';
const slice = '\Pitchart\Phunktional\slice';
const drop = '\Pitchart\Phunktional\drop';
const concat = '\Pitchart\Phunktional\concat';
const flatmap = '\Pitchart\Phunktional\flatmap';
const distinct = '\Pitchart\Phunktional\distinct';
const flatten = '\Pitchart\Phunktional\flatten';
const reduce = '\Pitchart\Phunktional\reduce';
const intersect = '\Pitchart\Phunktional\intersect';
const diff = '\Pitchart\Phunktional\diff';
const union = '\Pitchart\Phunktional\union';
const map = '\Pitchart\Phunktional\map';
const reject = '\Pitchart\Phunktional\reject';
const sort = '\Pitchart\Phunktional\sort';

/**
 * Runs a boolean function on each element and only puts those that pass into the output.
 *
 * @param callable $filter
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/filter.html
 */
function filter(callable $filter)
{
    return function (array $array) use ($filter) {
        return \array_values(\array_filter($array, $filter));
    };
}

function head()
{
    return function (array $array) {
        return \reset($array);
    };
}

/**
 * A form of slice that returns the first n elements
 *
 * @param int $size
 *
 * @return \Closure
 *
 * @see slice()
 */
function take(int $size)
{
    return function (array $array) use ($size) {
        return \array_slice($array, 0, $size);
    };
}

/**
 * A form of slice that returns all elements but first
 *
 * @param int $size
 *
 * @return \Closure
 *
 * @see slice()
 */
function tail()
{
    return function (array $array) {
        return \array_slice($array, 1);
    };
}

/**
 * Creates a function that returns a sub-sequence of the list between the given $start and $start + size positions
 *
 * @param int $start
 * @param int $size
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/slice.html
 */
function slice(int $start, int $size)
{
    return function (array $array) use ($start, $size) {
        return \array_slice($array, $start, $size);
    };
}

/**
 * A form of slice that returns all but the first n elements
 *
 * @param $size
 *
 * @return \Closure
 *
 * @see slice()
 */
function drop($size)
{
    return function (array $array) use ($size) {
        return \array_slice($array, $size);
    };
}

/**
 * Concatenates collections into a single collection
 *
 * @param array $collection
 * @param \array[] ...$collections
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/concat.html
 */
function concat(array $collection, array ...$collections)
{
    $collections = \count($collections) > 0 ? \array_merge([$collection], $collections) : [$collection];
    return function (array $array) use ($collections) {
        return \array_merge($array, ...$collections);
    };
}

/**
 * Maps a function over a collection and flatten the result by one-level
 *
 * @param callable $mapping
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/flat-map.html
 */
function flatmap(callable $mapping)
{
    return function (array $array) use ($mapping) {
        return \array_reduce(\array_map($mapping, $array), function (array $carry, $item) {
            return \array_merge($carry, \is_array($item) ? $item : [$item]);
        }, []);
    };
}

/**
 * Removes duplicate elements
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/distinct.html
 */
function distinct()
{
    return function (array $array) {
        return \array_values(\array_unique($array));
    };
}

/**
 * Removes nesting from a collection
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/flatten.html
 */
function flatten()
{
    return function (array $array) {
        return \array_reduce($array, function ($carry, $item) {
            return \is_array($item) ? \array_merge($carry, flatten()($item)) : \array_merge($carry, [$item]);
        }, []);
    };
}

/**
 * Uses the supplied function to combine the input elements, often to a single output value
 *
 * @param callable $reducer
 * @param $into
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/reduce.html
 */
function reduce(callable $reducer, $into)
{
    return function (array $array) use ($reducer, $into) {
        return \array_reduce($array, $reducer, $into);
    };
}

/**
 * Retains elements that are also in the supplied collection
 *
 * @param array $collection
 * @param callable|null $comparator
 * @param \array[] ...$collections
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/intersection.html
 */
function intersect(array $collection, callable $comparator = null, array ...$collections)
{
    $collections = \count($collections) > 0 ? \array_merge([$collection], $collections) : [$collection];
    if ($comparator !== null) {
        return function (array $array) use ($collections, $comparator) {
            return \array_values(\array_uintersect($array, ...\array_merge($collections, [$comparator])));
        };
    }
    return function (array $array) use ($collections) {
        return \array_values(\array_intersect($array, ...$collections));
    };
}

/**
 * Remove the contents of the supplied lists from the pipeline
 *
 * @param array $collection
 * @param callable|null $comparator
 * @param \array[] ...$collections
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/difference.html
 */
function diff(array $collection, ?callable $comparator = null, array ...$collections)
{
    $collections = \count($collections) > 0 ? \array_merge([$collection], $collections) : [$collection];
    if ($comparator !== null) {
        return function (array $array) use ($collections, $comparator) {
            return \array_values(\array_udiff($array, ...\array_merge($collections, [$comparator])));
        };
    }
    return function (array $array) use ($collections) {
        return \array_values(\array_diff($array, ...$collections));
    };
}

/**
 * Returns elements in this or the supplied collections, removing duplicates
 *
 * @param array $collection
 * @param \array[] ...$collections
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/union.html
 */
function union(array $collection, array ...$collections)
{
    $collections = \count($collections) > 0 ? \array_merge([$collection], $collections) : [$collection];
    return function (array $array) use ($collections) {
        return distinct()(\array_merge($array, ...$collections));
    };
}

/**
 * Applies given mapping function to each element of input and puts result in output
 *
 * @param callable $mapping
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/map.html
 */
function map(callable $mapping)
{
    return function (array ...$arrays) use ($mapping) {
        return \array_map($mapping, ...$arrays);
    };
}

/**
 * Inverse of filter, returning elements that do not match the predicate $filter
 *
 * @param callable $filter
 *
 * @return \Closure
 *
 * @see filter()
 */
function reject(callable $filter)
{
    return function (array $array) use ($filter) {
        return \array_filter($array, function ($item) use ($filter) {
            return !$filter($item);
        });
    };
}

/**
 * Output is sorted copy of input based on supplied comparator
 *
 * @param callable $function
 *
 * @return \Closure
 *
 * @link https://martinfowler.com/articles/collection-pipeline/sort.html
 */
function sort(callable $comparator)
{
    return function (array $array) use ($comparator) {
        \usort($array, $comparator);
        return $array;
    };
}

