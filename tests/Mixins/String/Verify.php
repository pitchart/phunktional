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
    public function tests_verifies_that_a_string_contains_a_chunk(bool $expected, string $string, string $glue, bool $caseSensitive = true)
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
    public function tests_verifies_that_a_string_contains_same_as_a_chunk(bool $expected, string $string, string $glue, bool $caseSensitive = true)
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
     * @dataProvider containsAnyProvider
     */
    public function tests_verifies_that_a_string_contains_any_of_provided_glue(bool $expected, string $string, array $glues)
    {
        self::assertEquals($expected, s\contains_any($glues)($string));
    }

    public function containsAnyProvider()
    {
        return [
            [true, 'foo bars', ['foo bar']],
            [false, 'FOO bars', ['foo bar']],
            [false, 'FOO bars', ['foo BAR']],
            [false, 'FÒÔ bàřs', ['fòô bàř']],
            [false, 'fòô bàřs', ['fòô BÀŘ']],
            [true, 'foo bar', ['bar']],
            [false, 'foo bar', ['bor']],
            [false, 'foo bar', ['foo bars']],
            [false, 'FOO bar', ['foo bars']],
            [false, 'FOO bars', ['foo BAR']],
            [false, 'FÒÔ bàřs', ['fòô bàř']],
            [false, 'fòô bàřs', ['fòô BÀŘ']],
            [true, StringTest::EMOJI.'poo bar', [StringTest::EMOJI]],
            [true, StringTest::EMOJI.'poo bar', [StringTest::EMOJI_CODE]],
            [true, StringTest::EMOJI_CODE.'poo bar', [StringTest::EMOJI]],
            [true, StringTest::EMOJI_CODE.'poo bar', [StringTest::EMOJI_CODE]],
            [true, 'foo bars', [' bars']],
            [false, 'FOO BARS', [' bars']],
            [false, 'FOO bars', [' BARS']],
            [true, 'FÒÔ bàřs', [' bàřs']],
            [false, 'fòô bàřs', [' BÀŘS']],
            [true, 'foo bar', ['bar']],
            [false, 'foo bar', [' bars']],
            [false, 'FOO bar', [' bars']],
            [false, 'FOO bars', [' BARS']],
            [false, 'fòô bàřs', [' bàŘS']],
            [false, 'fòô bàřs', [' BÀŘS']],
            [true, 'poo bar'.StringTest::EMOJI, [StringTest::EMOJI]],
            [true, 'poo bar'.StringTest::EMOJI, [StringTest::EMOJI_CODE]],
            [true, 'poo bar'.StringTest::EMOJI_CODE, [StringTest::EMOJI]],
            [true, 'poo bar'.StringTest::EMOJI_CODE, [StringTest::EMOJI_CODE]],
            [true, 'foo bars fizz', [' bars']],
            [false, 'FOO BARS fizz', [' bars']],
            [false, 'FOO bars fizz', [' BARS']],
            [true, 'FÒÔ bàřs fizz', [' bàřs']],
            [false, 'fòô bàřs fizz', [' BÀŘS']],
            [true, 'foo bar fizz', ['bar']],
            [false, 'foo bar fizz', [' bars']],
            [false, 'FOO bar fizz', [' bars']],
            [true, 'FOO bars fizz', [' BARS', 'bars']],
            [true, 'fòô bàřs fizz', ['bàŘS', 'fizz']],
            [false, 'fòô bàřs fizz', [' BÀŘS']],
            [true, 'poo bar fizz'.StringTest::EMOJI, [StringTest::EMOJI]],
            [true, 'poo bar fizz'.StringTest::EMOJI, [StringTest::EMOJI_CODE]],
            [true, 'poo bar fizz'.StringTest::EMOJI_CODE, [StringTest::EMOJI]],
            [true, 'poo bar fizz'.StringTest::EMOJI_CODE, [StringTest::EMOJI_CODE]],
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
    public function test_verifies_that_a_string_starts_with_a_glue(bool $expected, string $string, string $glue, bool $caseSensitive = true)
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
    public function test_verifies_that_a_string_starts_same_as_a_glue(bool $expected, string $string, string $glue, bool $caseSensitive = true)
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
     * @dataProvider startsWithAnyProvider
     */
    public function test_verifies_that_a_string_starts_with_any_of_provided_glues(bool $expected, string $string, array $glues)
    {
        self::assertEquals($expected, s\starts_with_any($glues)($string));
    }

    public function startsWithAnyProvider()
    {
        return [
            [true, 'foo bars', ['foo bar']],
            [false, 'FOO bars', ['foo bar']],
            [false, 'FOO bars', ['foo BAR']],
            [false, 'FÒÔ bàřs', ['fòô bàř']],
            [false, 'fòô bàřs', ['fòô BÀŘ']],
            [false, 'foo bar', ['bar']],
            [false, 'foo bar', ['foo bars']],
            [false, 'FOO bar', ['foo bars']],
            [false, 'FOO bars', ['foo BAR']],
            [false, 'FÒÔ bàřs', ['fòô bàř']],
            [false, 'fòô bàřs', ['fòô BÀŘ']],
            [true, StringTest::EMOJI.'poo bar', [StringTest::EMOJI]],
            [true, StringTest::EMOJI.'poo bar', [StringTest::EMOJI_CODE]],
            [true, StringTest::EMOJI_CODE.'poo bar', [StringTest::EMOJI]],
            [true, StringTest::EMOJI_CODE.'poo bar', [StringTest::EMOJI_CODE]],
            [false, 'foo', ['po', 'pow', 'powwwww']]
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
    public function test_verifies_that_a_string_ends_with_a_glue(bool $expected, string $string, string $glue, bool $caseSensitive = true)
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
    public function test_verifies_that_a_string_ends_same_as_a_glue(bool $expected, string $string, string $glue, bool $caseSensitive = true)
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

    /**
     * @param bool $expected
     * @param string $string
     * @param string $glue
     * @param bool $caseSensitive
     *
     * @dataProvider endsWithAnyProvider
     */
    public function test_verifies_that_a_string_ends_with_any_of_provided_glues(bool $expected, string $string, array $glues)
    {
        self::assertEquals($expected, s\ends_with_any($glues)($string));
    }

    public function endsWithAnyProvider()
    {
        return [
            [true, 'foo bars', [' bars']],
            [false, 'FOO BARS', [' bars']],
            [false, 'FOO bars', [' BARS']],
            [true, 'FÒÔ bàřs', [' bàřs']],
            [false, 'fòô bàřs', [' BÀŘS']],
            [true, 'foo bar', ['bar']],
            [false, 'foo bar', [' bars']],
            [false, 'FOO bar', [' bars']],
            [false, 'FOO bars', [' BARS']],
            [false, 'fòô bàřs', [' bàŘS']],
            [false, 'fòô bàřs', [' BÀŘS']],
            [true, 'poo bar'.StringTest::EMOJI, [StringTest::EMOJI]],
            [true, 'poo bar'.StringTest::EMOJI, [StringTest::EMOJI_CODE]],
            [true, 'poo bar'.StringTest::EMOJI_CODE, [StringTest::EMOJI]],
            [true, 'poo bar'.StringTest::EMOJI_CODE, [StringTest::EMOJI_CODE]],
            [false, 'foo', ['po', 'pow', 'powwwww']]
        ];
    }

    /**
     * @param bool $expected
     * @param string $string
     * @param string $pattern
     *
     * @dataProvider matchesProvider
     */
    public function test_verifies_that_a_string_matches_a_pattern(bool $expected, string $string, string $pattern, $options = 'msr')
    {
        self::assertEquals($expected, s\matches($pattern, $options)($string));
    }

    public function matchesProvider()
    {
        return [
            [true, '', ''],
            [true, 'foo', 'f[o]+'],
            [false, 'FOO', 'f[o]+'],
            [true, 'FOO', 'f[o]+', 'i'],
            [false, 'FÒÔ', 'f[o]+', 'i'],
            [true, 'FÒÔ', '[[:alpha:]]{3}'],
        ];
    }
}
