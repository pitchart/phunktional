<?php

namespace Pitchart\Phunktional\Tests\Mixins\String;

use Pitchart\Phunktional\Tests\StringTest;
use Pitchart\Phunktional\String as s;

trait Verify
{
    /**
     * @param bool $expected
     * @param string $string
     * @param string $glue
     * @param bool $caseSensitive
     *
     * @dataProvider containsProvider
     */
    public function tests_determines_that_a_string_contains_a_chunk(bool $expected, string $string, string $glue, bool $caseSensitive = true)
    {
        self::assertEquals(($expected && $caseSensitive), s\contains($glue)($string));
    }

    /**
     * @param bool $expected
     * @param string $string
     * @param string $glue
     * @param bool $caseSensitive
     *
     * @dataProvider containsProvider
     */
    public function tests_determines_that_a_string_contains_same_as_a_chunk(bool $expected, string $string, string $glue, bool $caseSensitive = true)
    {
        self::assertEquals($expected, s\contains_same_as($glue)($string));
    }

    public function containsProvider()
    {
        return [
            [true, 'foo bars', 'foo bar'],
            [true, 'FOO bars', 'foo bar', false],
            [true, 'FOO bars', 'foo BAR', false],
            [true, 'FÒÔ bàřs', 'fòô bàř', false],
            [true, 'fòô bàřs', 'fòô BÀŘ', false],
            [true, 'foo bar', 'bar'],
            [false, 'foo bar', 'bor'],
            [false, 'foo bar', 'foo bars'],
            [false, 'FOO bar', 'foo bars'],
            [true, 'FOO bars', 'foo BAR', false],
            [true, 'FÒÔ bàřs', 'fòô bàř', false],
            [true, 'fòô bàřs', 'fòô BÀŘ', false],
            [true, StringTest::EMOJI.'poo bar', StringTest::EMOJI],
            [true, StringTest::EMOJI.'poo bar', StringTest::EMOJI_CODE],
            [true, StringTest::EMOJI_CODE.'poo bar', StringTest::EMOJI],
            [true, StringTest::EMOJI_CODE.'poo bar', StringTest::EMOJI_CODE],
            [true, 'foo bars', ' bars'],
            [true, 'FOO BARS', ' bars', false],
            [true, 'FOO bars', ' BARS', false],
            [true, 'FÒÔ bàřs', ' bàřs'],
            [true, 'fòô bàřs', ' BÀŘS', false],
            [true, 'foo bar', 'bar'],
            [false, 'foo bar', ' bars'],
            [false, 'FOO bar', ' bars'],
            [true, 'FOO bars', ' BARS', false],
            [true, 'fòô bàřs', ' bàŘS', false],
            [true, 'fòô bàřs', ' BÀŘS', false],
            [true, 'poo bar'.StringTest::EMOJI, StringTest::EMOJI],
            [true, 'poo bar'.StringTest::EMOJI, StringTest::EMOJI_CODE],
            [true, 'poo bar'.StringTest::EMOJI_CODE, StringTest::EMOJI],
            [true, 'poo bar'.StringTest::EMOJI_CODE, StringTest::EMOJI_CODE],
            [true, 'foo bars fizz', ' bars'],
            [true, 'FOO BARS fizz', ' bars', false],
            [true, 'FOO bars fizz', ' BARS', false],
            [true, 'FÒÔ bàřs fizz', ' bàřs'],
            [true, 'fòô bàřs fizz', ' BÀŘS', false],
            [true, 'foo bar fizz', 'bar'],
            [false, 'foo bar fizz', ' bars'],
            [false, 'FOO bar fizz', ' bars'],
            [true, 'FOO bars fizz', ' BARS', false],
            [true, 'fòô bàřs fizz', ' bàŘS', false],
            [true, 'fòô bàřs fizz', ' BÀŘS', false],
            [true, 'poo bar fizz'.StringTest::EMOJI, StringTest::EMOJI],
            [true, 'poo bar fizz'.StringTest::EMOJI, StringTest::EMOJI_CODE],
            [true, 'poo bar fizz'.StringTest::EMOJI_CODE, StringTest::EMOJI],
            [true, 'poo bar fizz'.StringTest::EMOJI_CODE, StringTest::EMOJI_CODE],
        ];
    }


    /**
     * @param bool $expected
     * @param string $string
     * @param string $glue
     * @param bool $caseSensitive
     *
     * @dataProvider startsWithProvider
     */
    public function test_determines_that_a_string_starts_with_a_glue(bool $expected, string $string, string $glue, bool $caseSensitive = true)
    {
        self::assertEquals(($expected && $caseSensitive), s\starts_with($glue)($string));
    }

    /**
     * @param bool $expected
     * @param string $string
     * @param string $glue
     * @param bool $caseSensitive
     *
     * @dataProvider startsWithProvider
     */
    public function test_determines_that_a_string_starts_same_as_a_glue(bool $expected, string $string, string $glue, bool $caseSensitive = true)
    {
        self::assertEquals($expected, s\starts_same_as($glue)($string));
    }

    public function startsWithProvider()
    {
        return [
            [true, 'foo bars', 'foo bar'],
            [true, 'FOO bars', 'foo bar', false],
            [true, 'FOO bars', 'foo BAR', false],
            [true, 'FÒÔ bàřs', 'fòô bàř', false],
            [true, 'fòô bàřs', 'fòô BÀŘ', false],
            [false, 'foo bar', 'bar'],
            [false, 'foo bar', 'foo bars'],
            [false, 'FOO bar', 'foo bars'],
            [true, 'FOO bars', 'foo BAR', false],
            [true, 'FÒÔ bàřs', 'fòô bàř', false],
            [true, 'fòô bàřs', 'fòô BÀŘ', false],
            [true, StringTest::EMOJI.'poo bar', StringTest::EMOJI],
            [true, StringTest::EMOJI.'poo bar', StringTest::EMOJI_CODE],
            [true, StringTest::EMOJI_CODE.'poo bar', StringTest::EMOJI],
            [true, StringTest::EMOJI_CODE.'poo bar', StringTest::EMOJI_CODE],
        ];
    }

    /**
     * @param bool $expected
     * @param string $string
     * @param string $glue
     * @param bool $caseSensitive
     *
     * @dataProvider endsWithProvider
     */
    public function test_determines_that_a_string_ends_with_a_glue(bool $expected, string $string, string $glue, bool $caseSensitive = true)
    {
        self::assertEquals(($expected && $caseSensitive), s\ends_with($glue)($string));
    }

    /**
     * @param bool $expected
     * @param string $string
     * @param string $glue
     * @param bool $caseSensitive
     *
     * @dataProvider endsWithProvider
     */
    public function test_determines_that_a_string_ends_same_as_a_glue(bool $expected, string $string, string $glue, bool $caseSensitive = true)
    {
        self::assertEquals($expected, s\ends_same_as($glue)($string));
    }

    public function endsWithProvider()
    {
        return [
            [true, 'foo bars', ' bars'],
            [true, 'FOO BARS', ' bars', false],
            [true, 'FOO bars', ' BARS', false],
            [true, 'FÒÔ bàřs', ' bàřs'],
            [true, 'fòô bàřs', ' BÀŘS', false],
            [true, 'foo bar', 'bar'],
            [false, 'foo bar', ' bars'],
            [false, 'FOO bar', ' bars'],
            [true, 'FOO bars', ' BARS', false],
            [true, 'fòô bàřs', ' bàŘS', false],
            [true, 'fòô bàřs', ' BÀŘS', false],
            [true, 'poo bar'.StringTest::EMOJI, StringTest::EMOJI],
            [true, 'poo bar'.StringTest::EMOJI, StringTest::EMOJI_CODE],
            [true, 'poo bar'.StringTest::EMOJI_CODE, StringTest::EMOJI],
            [true, 'poo bar'.StringTest::EMOJI_CODE, StringTest::EMOJI_CODE],
        ];
    }
}
