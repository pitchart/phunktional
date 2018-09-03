<?php

namespace Pitchart\Phunktional\Tests\Mixins\String;

use Pitchart\Phunktional\String as s;

trait Split
{
    public function test_chunking_string_into_array_of_substring_with_invalid_length_throws_exception()
    {
        self::expectException(\InvalidArgumentException::class);
        self::expectExceptionMessage(sprintf('%s(): $length must be greater than 0, %d given', s\chunk, -1));
        s\chunk(-1, -1)('FÒÔ bàřs');
    }

    /**
     * @param array $expected
     * @param int $length
     * @param string $string
     * @param int $limit
     *
     * @dataProvider chunksProvider
     */
    public function test_chunks_string_into_array_of_substrings(array $expected, int $length, string $string, int $limit = -1)
    {
        self::assertEquals($expected, s\chunk($length, $limit)($string));
    }

    public function chunksProvider()
    {
        return [
            [['FÒ', 'Ô ', 'bà', 'řs'], 2,'FÒÔ bàřs'],
            [['FÒ', 'Ô '], 2,'FÒÔ bàřs', 2],
            [['FÒÔ bàřs'], 15,'FÒÔ bàřs'],
        ];
    }

    public function test_can_iterate_over_a_string_chars()
    {
        self::assertEquals(['F', 'Ò', 'Ô', ' ', 'b', 'à', 'ř', 's'], s\iterate()('FÒÔ bàřs'));
    }

    public function test_can_split_a_string_into_an_array_using_a_pattern()
    {
        self::assertEquals(['FÒÔ', 'bàř', 'fìzz'], s\split('[\s\t]+')('FÒÔ    bàř	fìzz'));
    }

    /**
     * @dataProvider linesProvider()
     */
    public function test_extracts_test_lines(array $expected, string $string)
    {
        $result = s\lines()($string);
        self::assertInternalType('array', $result);
        for ($i = 0; $i < count($expected); $i++) {
            $this->assertEquals($expected[$i], $result[$i]);
        }
    }
    public function linesProvider()
    {
        return [
            [[], ""],
            [[''], "\r\n"],
            [['foo', 'bar'], "foo\nbar"],
            [['foo', 'bar'], "foo\rbar"],
            [['foo', 'bar'], "foo\r\nbar"],
            [['foo', '', 'bar'], "foo\r\n\r\nbar"],
            [['foo', 'bar', ''], "foo\r\nbar\r\n"],
            [['', 'foo', 'bar'], "\r\nfoo\r\nbar"],
            [['fòô', 'bàř'], "fòô\nbàř"],
            [['fòô', 'bàř'], "fòô\rbàř"],
            [['fòô', 'bàř'], "fòô\n\rbàř"],
            [['fòô', 'bàř'], "fòô\r\nbàř"],
            [['fòô', '', 'bàř'], "fòô\r\n\r\nbàř"],
            [['fòô', 'bàř', ''], "fòô\r\nbàř\r\n"],
            [['', 'fòô', 'bàř'], "\r\nfòô\r\nbàř"],
        ];
    }
}
