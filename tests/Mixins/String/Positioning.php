<?php

namespace Pitchart\Phunktional\Tests\Mixins\String;

use Pitchart\Phunktional\String as s;

trait Positioning
{
    /**
     * @param int $expected
     * @param string $string
     * @param string $char
     * @param int $offset
     *
     * @dataProvider positionProvider
     */
    public function test_finds_character_first_occurence(int $expected, string $string, string $char, int $offset = 0)
    {
        self::assertEquals($expected, s\position($char, $offset)($string));
    }

    public function positionProvider()
    {
        return [
            [0, 'foo bar', 'f'],
            [1, 'foo bar', 'o'],
            [2, 'foo bar', 'o', 2],
        ];
    }

    /**
     * @param int $expected
     * @param string $string
     * @param string $char
     * @param int $offset
     *
     * @dataProvider lastPositionProvider
     */
    public function test_finds_character_last_occurence(int $expected, string $string, string $char, int $offset = 0)
    {
        self::assertEquals($expected, s\last_position($char, $offset)($string));
    }

    public function lastPositionProvider()
    {
        return [
            [0, 'foo bar', 'f'],
            [2, 'foo bar', 'o'],
            [2, 'foo bar', 'o', 2],
            [0, 'foo bar', 'z'],
        ];
    }

}
