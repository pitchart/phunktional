<?php

namespace Pitchart\Phunktional\Tests\Mixins\String;

use Pitchart\Phunktional\String as s;

trait Concatenation
{
    /**
     * @param $expected
     * @param string $string
     * @param string $suffix
     * @param \string[] ...$suffixes
     *
     * @dataProvider concatenationProvider
     */
    public function test_concatenates_strings($expected, string $string, string $glue, string $suffix, string ...$suffixes)
    {
        self::assertEquals($expected, s\concat($glue, $suffix, ...$suffixes)($string));
    }

    public function concatenationProvider()
    {
        return [
            ['fôô', 'fôô', '', ''],
            ['fôôbàř', 'fôô', '', 'bàř'],
            ['fôôbàzbàř', 'fôô', 'bàz', 'bàř'],
            ['fôôbàřbàz', 'fôô', '', 'bàř', 'bàz'],
            ['fôôbàřfizzbuzz', 'fôô', '', 'bàř', 'fizz', 'buzz'],
            ['fôôbàzbàřbàzfizzbàzbuzz', 'fôô', 'bàz', 'bàř', 'fizz', 'buzz'],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param string $prefix
     * @dataProvider prefixProvider
     */
    public function test_prefixes_strings(string $expected, string $string, string $prefix)
    {
        self::assertEquals($expected, s\prefix($prefix)($string));
    }

    public function prefixProvider()
    {
        return [
            ['fôô', 'fôô', ''],
            ['fôô', '', 'fôô'],
            ['bàřfôô', 'fôô', 'bàř'],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param string $suffix
     * @dataProvider suffixProvider
     */
    public function test_suffixes_strings(string $expected, string $string, string $suffix)
    {
        self::assertEquals($expected, s\suffix($suffix)($string));
    }

    public function suffixProvider()
    {
        return [
            ['fôô', 'fôô', ''],
            ['fôô', '', 'fôô'],
            ['fôôbàř', 'fôô', 'bàř'],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param string $prefix
     * @dataProvider ensureleftProvider
     */
    public function test_ensures_strings_prefix(string $expected, string $string, string $prefix)
    {
        self::assertEquals($expected, s\ensure_left($prefix)($string));
    }

    public function ensureleftProvider()
    {
        return [
            ['fôô', 'fôô', ''],
            ['fôô', '', 'fôô'],
            ['fôô', 'fôô', 'fôô'],
            ['bàřfôô', 'fôô', 'bàř'],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param string $suffix
     * @dataProvider ensureRightProvider
     */
    public function test_ensures_strings_suffix(string $expected, string $string, string $suffix)
    {
        self::assertEquals($expected, s\ensure_right($suffix)($string));
    }

    public function ensureRightProvider()
    {
        return [
            ['fôô', 'fôô', ''],
            ['fôô', '', 'fôô'],
            ['fôô', 'fôô', 'fôô'],
            ['fôôbàř', 'fôô', 'bàř'],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param string $suffix
     * @dataProvider insertionProvider
     */
    public function test_inserts_into_strings(string $expected, string $string, string $insertion, $position)
    {
        self::assertEquals($expected, s\insert($insertion, $position)($string));
    }

    public function insertionProvider()
    {
        return [
            ['fôô', 'fôô', '', 0],
            ['fôô', '', 'fôô', 0],
            ['fôôbàř', 'fôô', 'bàř', 3],
            ['bàřfôô', 'fôô', 'bàř', 0],
            ['fôbàřô', 'fôô', 'bàř', 2],
            ['fôôbàř', 'fôô', 'bàř', 10],
            ['fôbàřô', 'fôô', 'bàř', function (string $string) { return s\position('ô')($string) + 1;} ],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param string $wrap
     * @dataProvider wrapProvider
     */
    public function test_wraps_strings(string $expected, string $string, string $wrap)
    {
        self::assertEquals($expected, s\wrap($wrap)($string));
    }

    public function wrapProvider()
    {
        return [
            ['fôô', 'fôô', ''],
            ['fôôfôô', '', 'fôô'],
            ['bàřfôôbàř', 'fôô', 'bàř'],
        ];
    }
}
