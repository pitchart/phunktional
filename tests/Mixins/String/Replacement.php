<?php

namespace Pitchart\Phunktional\Tests\Mixins\String;

use Pitchart\Phunktional\String as s;

trait Replacement
{
    /**
     * @param string $expected
     * @param string $string
     * @param int $flags
     *
     * @dataProvider htmlProvider
     */
    public function test_encodes_as_html(string $expected, string $string, $flags = ENT_COMPAT|ENT_HTML5)
    {
        self::assertEquals($expected, s\html_encode($flags)($string));
    }

    /**
     * @param string $expected
     * @param string $string
     * @param int $flags
     *
     * @dataProvider htmlProvider
     */
    public function test_decodes_html(string $string, string $expected, $flags = ENT_COMPAT|ENT_HTML5)
    {
        self::assertEquals($expected, s\html_decode($flags)($string));
    }

    public function htmlProvider()
    {
        return [
            ['&amp;', '&'],
            ['&quot;', '"'],
            ['&apos;', "'", ENT_QUOTES|ENT_HTML5],
            ['&lt;', '<'],
            ['&gt;', '>'],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param string $search
     * @param string $replacement
     *
     * @dataProvider changeProvider
     */
    public function test_replaces_in_string(string $expected, string $string, string $search, string $replacement)
    {
        self::assertEquals($expected, s\change($search, $replacement)($string));
    }

    public function changeProvider()
    {
        return [
            ['foo foo', 'foo bar', 'bar', 'foo'],
            ['foo', 'foo bar', ' bar', ''],
            ['fooffooofooofoo foobfooafoorfoo', 'foo bar', '', 'foo'],
            ['foo_bar_fizz', 'foo bar fizz', ' ', '_'],
        ];
    }

    /**
     * @param string $expected
     * @param string $string
     * @param string $search
     * @param string $replacement
     *
     * @dataProvider replaceProvider
     */
    public function test_replaces_in_string_by_regexp(string $expected, string $string, string $search, string $replacement)
    {
        self::assertEquals($expected, s\replace($search, $replacement)($string));
    }

    public function replaceProvider()
    {
        yield from $this->changeProvider();
        yield from [
            ['bar bar', 'foo foo', 'f[o]+', 'bar'],
            ['fizz fizz', 'foo bar', '[[:alpha:]]{3}', 'fizz'],
            ['o bar', 'foo bar', 'f(o)o', '\1'],
        ];
    }
}
