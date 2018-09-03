<?php


namespace Pitchart\Phunktional\Tests\Mixins\String;

use Pitchart\Phunktional\String as s;
use Pitchart\Phunktional\Tests\StringTest;

trait CaseConvertion
{
    /**
     * @param string $expected
     * @param string $string
     *
     * @dataProvider toLowerCaseProvider
     */
    public function test_converts_to_lower_case(string $expected, string $string)
    {
        self::assertEquals($expected, s\to_lower()($string));
    }

    public function toLowerCaseProvider()
    {
        return [
            ['foo bar', 'FOO BAR'],
            [' foo_bar ', ' FOO_bar '],
            ['fòô bàř', 'FÒÔ BÀŘ'],
            [' fòô_bàř ', ' FÒÔ_bàř '],
            ['αυτοκίνητο', 'ΑΥΤΟΚΊΝΗΤΟ'],
            [StringTest::EMOJI, StringTest::EMOJI],
            [StringTest::EMOJI, StringTest::EMOJI_CODE],
            [StringTest::EMOJI_CODE, StringTest::EMOJI],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     *
     * @dataProvider toLowerCaseFirstProvider
     */
    public function test_converts_first_character_to_lower_case(string $expected, string $string)
    {
        self::assertEquals($expected, s\to_lc_first()($string));
    }

    public function toLowerCaseFirstProvider()
    {
        return [
            ['fOO BAR', 'FOO BAR'],
            [' FOO_bar ', ' FOO_bar '],
            ['fÒÔ BÀŘ', 'FÒÔ BÀŘ'],
            [' FÒÔ_bàř ', ' FÒÔ_bàř '],
            ['αΥΤΟΚΊΝΗΤΟ', 'ΑΥΤΟΚΊΝΗΤΟ'],
            [StringTest::EMOJI, StringTest::EMOJI],
            [StringTest::EMOJI, StringTest::EMOJI_CODE],
            [StringTest::EMOJI_CODE, StringTest::EMOJI],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     *
     * @dataProvider toUpperCaseProvider
     */
    public function test_converts_to_upper_case(string $expected, string $string)
    {
        self::assertEquals($expected, s\to_upper()($string));
    }

    public function toUpperCaseProvider()
    {
        return [
            ['FOO BAR', 'foo bar'],
            [' FOO_BAR ', ' FOO_bar '],
            ['FÒÔ BÀŘ', 'fòô bàř'],
            [' FÒÔ_BÀŘ ', ' FÒÔ_bàř '],
            ['ΑΥΤΟΚΊΝΗΤΟ', 'αυτοκίνητο'],
            [StringTest::EMOJI, StringTest::EMOJI],
            [StringTest::EMOJI, StringTest::EMOJI_CODE],
            [StringTest::EMOJI_CODE, StringTest::EMOJI],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     *
     * @dataProvider toUpperCaseFirstProvider
     */
    public function test_converts_first_character_to_upper_case(string $expected, string $string)
    {
        self::assertEquals($expected, s\to_uc_first()($string));
    }

    public function toUpperCaseFirstProvider()
    {
        return [
            ['Foo bar', 'foo bar'],
            [' FOO_bar ', ' FOO_bar '],
            ['Fòô bàř', 'fòô bàř'],
            [' FÒÔ_bàř ', ' FÒÔ_bàř '],
            ['Αυτοκίνητο', 'αυτοκίνητο'],
            [StringTest::EMOJI, StringTest::EMOJI],
            [StringTest::EMOJI, StringTest::EMOJI_CODE],
            [StringTest::EMOJI_CODE, StringTest::EMOJI],
        ];
    }

    /**
     * @dataProvider camelizeProvider()
     */
    public function testCamelize(string $expected, string $string)
    {
        $result = s\to_camel_case()($string);

        self::assertEquals($expected, $result);
    }

    public function camelizeProvider()
    {
        return [
            ['camelCase', 'CamelCase'],
            ['camelCase', 'Camel-Case'],
            ['camelCase', 'camel case'],
            ['camelCase', 'camel -case'],
            ['camelCase', 'camel - case'],
            ['camelCase', 'camel_case'],
            ['camelCTest', 'camel c test'],
            ['stringWith1Number', 'string_with1number'],
            ['stringWith22Numbers', 'string-with-2-2 numbers'],
            ['dataRate', 'data_rate'],
            ['backgroundColor', 'background-color'],
            ['yesWeCan', 'yes_we_can'],
            ['mozSomething', '-moz-something'],
            ['carSpeed', '_car_speed_'],
            ['serveHTTP', 'ServeHTTP'],
            ['1Camel2Case', '1camel2case'],
            ['camelΣase', 'camel σase'],
            ['στανιλCase', 'Στανιλ case'],
            ['σamelCase', 'σamel  Case']
        ];
    }

    /**
     * @dataProvider underscoredProvider()
     */
    public function test_converts_into_snake_case(string $expected, string $string)
    {
        $this->assertEquals($expected, s\to_snake_case()($string));
    }
    public function underscoredProvider()
    {
        return [
            ['test_case', 'testCase'],
            ['test_case', 'Test-Case'],
            ['test_case', 'test case'],
            ['test_case', 'test -case'],
            ['_test_case', '-test - case'],
            ['test_case', 'test_case'],
            ['test_c_test', '  test c test'],
            ['test_u_case', 'TestUCase'],
            ['test_c_c_test', 'TestCCTest'],
            ['string_with1number', 'string_with1number'],
            ['string_with_2_2_numbers', 'String-with_2_2 numbers'],
            ['1test2case', '1test2case'],
            ['yes_we_can', 'yesWeCan'],
            ['test_σase', 'test Σase', 'UTF-8'],
            ['στανιλ_case', 'Στανιλ case', 'UTF-8'],
            ['σash_case', 'Σash  Case', 'UTF-8']
        ];
    }
}
