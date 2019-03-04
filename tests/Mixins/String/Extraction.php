<?php

namespace Pitchart\Phunktional\Tests\Mixins\String;

use Pitchart\Phunktional\String as s;

trait Extraction
{
    /**
     * @param string $expected
     * @param string $string
     * @param int $length
     *
     * @dataProvider atProvider
     */
    public function test_extracts_single_character(string $expected, string $string, int $position)
    {
        self::assertEquals($expected, s\at($position)($string));
    }

    public function atProvider()
    {
        return [
            ['f', 'fòô bàřs fizz', 0],
            [' ', 'fòô bàřs fizz', 3],
            ['f', 'fòô bàřs fizz', 9],
            ['z', 'fòô bàřs fizz', -1],
            ['', 'fòô bàřs fizz', 42],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param int $length
     *
     * @dataProvider substrProvider
     */
    public function test_extracts_characters(string $expected, string $string, int $start, int $length = null)
    {
        self::assertEquals($expected, s\substr($start, $length)($string));
    }

    public function substrProvider()
    {
        return [
            ['fòô bàřs fizz', 'fòô bàřs fizz', 0],
            ['fòô bàřs fizz', 'fòô bàřs fizz', 0, 13],
            [' bàřs fizz', 'fòô bàřs fizz', 3],
            ['bàřs', 'fòô bàřs fizz', 4, 4],
            ['z', 'fòô bàřs fizz', -1],
            ['', 'fòô bàřs fizz', 42],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param int $length
     *
     * @dataProvider firstsProvider
     */
    public function test_extracts_firsts_n_characters(string $expected, string $string, int $length)
    {
        self::assertEquals($expected, s\firsts($length)($string));
    }

    public function firstsProvider()
    {
        return [
            ['', 'fòô bàřs fizz', 0],
            ['fòô bàřs fizz', 'fòô bàřs fizz', 13],
            ['fòô', 'fòô bàřs fizz', 3],
            ['', 'fòô bàřs fizz', -1],
            ['fòô bàřs fizz', 'fòô bàřs fizz', 42],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param int $length
     *
     * @dataProvider lastsProvider
     */
    public function test_extracts_lasts_n_characters(string $expected, string $string, int $length)
    {
        self::assertEquals($expected, s\lasts($length)($string));
    }

    public function lastsProvider()
    {
        return [
            ['', 'fòô bàřs fizz', 0],
            ['fòô bàřs fizz', 'fòô bàřs fizz', 13],
            ['izz', 'fòô bàřs fizz', 3],
            ['', 'fòô bàřs fizz', -1],
            ['fòô bàřs fizz', 'fòô bàřs fizz', 42],
        ];
    }


}
