<?php


namespace Pitchart\Phunktional\Tests;


use PHPUnit\Framework\TestCase;
use Pitchart\Phunktional as p;
use Pitchart\Phunktional\String as s;

class StringTest extends TestCase
{
    use p\Tests\Mixins\String\CaseConvertion,
        p\Tests\Mixins\String\Pad,
        p\Tests\Mixins\String\Split,
        p\Tests\Mixins\String\Trim,
        p\Tests\Mixins\String\Verify
    ;

    const EMOJI = '💩';

    const EMOJI_CODE = "\u{1F4A9}";

    public function setUp()
    {
        ini_set('mbstring.internal_encoding','UTF-8');
    }

    /**
     * @param int $length
     * @param string $string
     *
     * @dataProvider lengthProvider
     */
    public function test_computes_string_length(int $length, string $string)
    {
        self::assertEquals($length, s\length()($string));
    }

    public function lengthProvider()
    {
        return [
            [11, '  foo bar  '],
            [1, 'f'],
            [0, ''],
            [7, 'fôô bàř'],
            [1, self::EMOJI],
            [1, self::EMOJI_CODE],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     *
     * @dataProvider toAsciiProvider
     */
    public function test_converts_into_ascii(string $expected, string $string)
    {
        self::assertEquals($expected, s\to_ascii()($string));
    }

    public function toAsciiProvider()
    {
        return [
            ['  foo bar  ', '  foo bar  '],
            ['foo bar', 'fôô bàř'],
            [' FOO_bar ', ' FÒÔ_bàř '],
            [self::EMOJI, self::EMOJI],
            [self::EMOJI_CODE, self::EMOJI_CODE],
        ];
    }
    /**
     * @param string $expected
     * @param string $string
     *
     * @dataProvider toSlugProvider
     */
    public function test_converts_into_slug(string $expected, string $string, $delimiter = '-')
    {
        self::assertEquals($expected, s\to_slug($delimiter)($string));
    }

    public function toSlugProvider()
    {
        return [
            ['foo-bar', '  foo bar  '],
            ['foo-bar', 'fôô bàř'],
            ['foo-bar', 'foo -.-"-...bar'],
            ['foo-bar', '..& foo -.-"-.$.;bar'],
            ['foo-bar', ' FÒÔ_bàř '],
            ['perevirka-radka', 'перевірка рядка'],
            ['user-host', 'user@host'],
            ['numbers-1234', 'numbers 1234'],
            ['a-string-with-underscores', 'A_string with_underscores'],
            ['a_string_with_underscores', 'A_string with_underscores', '_'],
            ['', self::EMOJI],
            ['', self::EMOJI_CODE],
        ];
    }

    /**
     * @param $function
     * @dataProvider stringFunctionsBuildersProvider
     */
    public function test_has_superior_order_function_builder_for($function)
    {
        self::assertTrue(is_callable($function));
    }

    public function stringFunctionsBuildersProvider()
    {
        yield from ['length' => [s\length()]];
        yield from ['length constant' => [(s\length)()]];
        yield from ['to_lower' => [s\to_lower()]];
        yield from ['to_lower constant' => [(s\to_lower)()]];
        yield from ['to_upper' => [s\to_upper()]];
        yield from ['to_upper constant' => [(s\to_upper)()]];
        yield from ['to_lc_first' => [s\to_lc_first()]];
        yield from ['to_lc_first constant' => [(s\to_lc_first)()]];
        yield from ['to_uc_first' => [s\to_uc_first()]];
        yield from ['to_uc_first constant' => [(s\to_uc_first)()]];
        yield from ['to_ascii' => [s\to_ascii()]];
        yield from ['to_ascii constant' => [(s\to_ascii)()]];
        yield from ['to_slug' => [s\to_slug()]];
        yield from ['to_slug constant' => [(s\to_slug)()]];
        yield from ['html_encode' => [s\html_encode()]];
        yield from ['html_encode constant' => [(s\html_encode)()]];
        yield from ['html_decode' => [s\html_decode()]];
        yield from ['html_decode constant' => [(s\html_decode)()]];
        yield from ['substr' => [s\substr(2)]];
        yield from ['substr constant' => [(s\substr)(2)]];
        yield from ['firsts' => [s\firsts(3)]];
        yield from ['firsts constant' => [(s\firsts)(3)]];
        yield from ['prefix' => [s\prefix('test')]];
        yield from ['prefix constant' => [(s\prefix)('test')]];
        yield from ['suffix' => [s\suffix('test')]];
        yield from ['suffix constant' => [(s\suffix)('test')]];
        yield from ['insert' => [s\insert('test', 5)]];
        yield from ['insert constant' => [(s\insert)('test', 5)]];
        yield from ['trim' => [s\trim()]];
        yield from ['trim constant' => [(s\trim)()]];
        yield from ['trim_left' => [s\trim_left()]];
        yield from ['trim_left constant' => [(s\trim_left)()]];
        yield from ['trim_right' => [s\trim_right()]];
        yield from ['trim_right constant' => [(s\trim_right)()]];
        yield from ['pad_left' => [s\pad_left(3)]];
        yield from ['pad_left constant' => [(s\pad_left)(3)]];
        yield from ['pad_right' => [s\pad_right(3)]];
        yield from ['pad_right constant' => [(s\pad_right)(3)]];
        yield from ['pad_both' => [s\pad_both(3)]];
        yield from ['pad_both constant' => [(s\pad_both)(3)]];
        yield from ['wrap' => [s\wrap('test')]];
        yield from ['wrap constant' => [(s\wrap)('test')]];
        yield from ['ensure_left' => [s\ensure_left('test')]];
        yield from ['ensure_left constant' => [(s\ensure_left)('test')]];
        yield from ['ensure_right' => [s\ensure_right('test')]];
        yield from ['ensure_right constant' => [(s\ensure_right)('test')]];
        yield from ['split' => [s\split('/.*/')]];
        yield from ['split constant' => [(s\split)('/.*/')]];
        yield from ['chunk' => [s\chunk(3)]];
        yield from ['chunk constant' => [(s\chunk)(3)]];
        yield from ['change' => [s\change('foo', 'bar')]];
        yield from ['change constant' => [(s\change)('foo', 'bar')]];
        yield from ['replace' => [s\replace('/foo/', 'bar')]];
        yield from ['replace constant' => [(s\replace)('/foo/', 'bar')]];
        yield from ['replace_with_callback' => [s\replace_with_callback('/foo/', function (string $found) { return '';})]];
        yield from ['replace_with_callback constant' => [(s\replace_with_callback)('/foo/', function (string $found) { return '';})]];
        yield from ['matches' => [s\matches('/foo/')]];
        yield from ['matches constant' => [(s\matches)('/foo/')]];
        yield from ['contains' => [s\contains('foo')]];
        yield from ['contains constant' => [(s\contains)('foo')]];
        yield from ['contains_any' => [s\contains_any(['foo', 'bar'])]];
        yield from ['contains_any constant' => [(s\contains_any)(['foo', 'bar'])]];
        yield from ['contains_same_as' => [s\contains_same_as('foo')]];
        yield from ['contains_same_as constant' => [(s\contains_same_as)('foo')]];
        yield from ['starts_with' => [s\starts_with('foo')]];
        yield from ['starts_with constant' => [(s\starts_with)('foo')]];
        yield from ['starts_with_any' => [s\starts_with_any(['foo', 'bar'])]];
        yield from ['starts_with_any constant' => [(s\starts_with_any)(['foo', 'bar'])]];
        yield from ['starts_same_as' => [s\starts_same_as('foo')]];
        yield from ['starts_same_as constant' => [(s\starts_same_as)('foo')]];
        yield from ['ends_with' => [s\ends_with('foo')]];
        yield from ['ends_with constant' => [(s\ends_with)('foo')]];
        yield from ['ends_with_any' => [s\ends_with_any(['foo', 'bar'])]];
        yield from ['ends_with_any constant' => [(s\ends_with_any)(['foo', 'bar'])]];
        yield from ['ends_same_as' => [s\ends_same_as('foo')]];
        yield from ['ends_same_as constant' => [(s\ends_same_as)('foo')]];
    }
}
