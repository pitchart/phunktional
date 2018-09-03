<?php


namespace Pitchart\Phunktional\Tests\Mixins\String;

use Pitchart\Phunktional\String as s;

trait Pad
{
    /**
     * @param string $expected
     * @param string $string
     * @param int $length
     * @param string $padStr
     *
     * @dataProvider padLeftProvider()
     */
    public function test_pads_on_left_side(string $expected, string $string, int $length, string $padStr = ' ')
    {
        self::assertEquals($expected, s\pad_left($length, $padStr)($string));
    }

    public function padLeftProvider()
    {
        return [
            // length <= str
            ['foo bar', 'foo bar', -1],
            ['foo bar', 'foo bar', 7],
            ['fòô bàř', 'fòô bàř', 7],

            ['  foo bar', 'foo bar', 9, ' '],
            ['_*foo bar', 'foo bar', 9, '_*'],
            ['¬ø¬fòô bàř', 'fòô bàř', 10, '¬ø'],

        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param int $length
     * @param string $padStr
     *
     * @dataProvider padRightProvider()
     */
    public function test_pads_on_right_side(string $expected, string $string, int $length, string $padStr = ' ')
    {
        self::assertEquals($expected, s\pad_right($length, $padStr)($string));
    }

    public function padRightProvider()
    {
        return [
            // length <= str
            ['foo bar', 'foo bar', -1],
            ['foo bar', 'foo bar', 7],
            ['fòô bàř', 'fòô bàř', 7],
            // right
            ['foo bar  ', 'foo bar', 9],
            ['foo bar_*', 'foo bar', 9, '_*'],
            ['fòô bàř¬ø¬', 'fòô bàř', 10, '¬ø'],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param int $length
     * @param string $padStr
     *
     * @dataProvider padBothProvider()
     */
    public function test_pads_on_both_sides(string $expected, string $string, int $length, string $padStr = ' ')
    {
        self::assertEquals($expected, s\pad_both($length, $padStr)($string));
    }

    public function padBothProvider()
    {
        return [
            // length <= str
            ['foo bar', 'foo bar', -1],
            ['foo bar', 'foo bar', 7],
            ['fòô bàř', 'fòô bàř', 7],
            // both
            ['foo bar ', 'foo bar', 8, ' ', 'both'],
            ['¬fòô bàř¬ø', 'fòô bàř', 10, '¬ø', 'both', 'UTF-8'],
            ['¬øfòô bàř¬øÿ', 'fòô bàř', 12, '¬øÿ', 'both', 'UTF-8']
        ];
    }
}
