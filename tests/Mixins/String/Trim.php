<?php

namespace Pitchart\Phunktional\Tests\Mixins\String;

use Pitchart\Phunktional\String as s;

trait Trim
{
    /**
     * @param string $expected
     * @param string $str
     * @param string|null $chars
     *
     * @dataProvider trimProvider()
     */
    public function test_trims_on_both_sides(string $expected, string $str, string $chars = null)
    {
        self::assertEquals($expected, s\trim($chars)($str));
    }

    public function trimProvider()
    {
        return [
            ['foo   bar', '  foo   bar  '],
            ['foo bar', ' foo bar'],
            ['foo bar', 'foo bar '],
            ['foo bar', "\n\t foo bar \n\t"],
            ['fòô   bàř', '  fòô   bàř  '],
            ['fòô bàř', ' fòô bàř'],
            ['fòô bàř', 'fòô bàř '],
            [' foo bar ', "\n\t foo bar \n\t", "\n\t"],
            ['fòô bàř', "\n\t fòô bàř \n\t", null],
            ['fòô', ' fòô ', null], // narrow no-break space (U+202F)
            ['fòô', '  fòô  ', null], // medium mathematical space (U+205F)
            ['fòô', '           fòô', null] // spaces U+2000 to U+200A
        ];
    }

    /**
     * @param string $expected
     * @param string $str
     * @param string|null $chars
     *
     * @dataProvider trimLeftProvider()
     */
    public function test_trims_on_left_side(string $expected, string $str, string $chars = null)
    {
        self::assertEquals($expected, s\trim_left($chars)($str));
    }

    public function trimLeftProvider()
    {
        return [
            ['foo   bar  ', '  foo   bar  '],
            ['foo bar', ' foo bar'],
            ['foo bar ', 'foo bar '],
            ["foo bar \n\t", "\n\t foo bar \n\t"],
            ['fòô   bàř  ', '  fòô   bàř  '],
            ['fòô bàř', ' fòô bàř'],
            ['fòô bàř ', 'fòô bàř '],
            ['foo bar', '--foo bar', '-'],
            ['fòô bàř', 'òòfòô bàř', 'ò'],
            ["fòô bàř \n\t", "\n\t fòô bàř \n\t", null],
            ['fòô ', ' fòô ', null], // narrow no-break space (U+202F)
            ['fòô  ', '  fòô  ', null], // medium mathematical space (U+205F)
            ['fòô', '           fòô', null] // spaces U+2000 to U+200A
        ];
    }

    /**
     * @param string $expected
     * @param string $str
     * @param string|null $chars
     *
     * @dataProvider trimRightProvider()
     */
    public function testTrimRight(string $expected, string $str, string $chars = null)
    {
        self::assertEquals($expected, s\trim_right($chars)($str));
    }

    public function trimRightProvider()
    {
        return [
            ['  foo   bar', '  foo   bar  '],
            ['foo bar', 'foo bar '],
            [' foo bar', ' foo bar'],
            ["\n\t foo bar", "\n\t foo bar \n\t"],
            ['  fòô   bàř', '  fòô   bàř  '],
            ['fòô bàř', 'fòô bàř '],
            [' fòô bàř', ' fòô bàř'],
            ['foo bar', 'foo bar--', '-'],
            ['fòô bàř', 'fòô bàřòò', 'ò'],
            ["\n\t fòô bàř", "\n\t fòô bàř \n\t", null],
            [' fòô', ' fòô ', null], // narrow no-break space (U+202F)
            ['  fòô', '  fòô  ', null], // medium mathematical space (U+205F)
            ['fòô', 'fòô           ', null] // spaces U+2000 to U+200A
        ];
    }


}
