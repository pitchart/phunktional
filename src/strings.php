<?php

namespace Pitchart\Phunktional\String;

use function Pitchart\Phunktional\pipe;
const length = __NAMESPACE__.'\length';
const to_lower = __NAMESPACE__.'\to_lower';
const to_upper = __NAMESPACE__.'\to_upper';
const to_lc_first = __NAMESPACE__.'\to_lc_first';
const to_uc_first = __NAMESPACE__.'\to_uc_first';
const to_ascii = __NAMESPACE__.'\to_ascii';
const to_slug = __NAMESPACE__.'\to_slug';
const html_encode = __NAMESPACE__.'\html_encode';
const html_decode = __NAMESPACE__.'\html_decode';
const substr = __NAMESPACE__.'\substr';
const firsts = __NAMESPACE__.'\firsts';
const lasts = __NAMESPACE__.'\lasts';
const prefix = __NAMESPACE__.'\prefix';
const suffix = __NAMESPACE__.'\suffix';
const insert = __NAMESPACE__.'\insert';
const trim = __NAMESPACE__.'\trim';
const trim_left = __NAMESPACE__.'\trim_left';
const trim_right = __NAMESPACE__.'\trim_right';
const pad_left = __NAMESPACE__.'\pad_left';
const pad_right = __NAMESPACE__.'\pad_right';
const pad_both = __NAMESPACE__.'\pad_both';
const wrap = __NAMESPACE__.'\wrap';
const ensure_left = __NAMESPACE__.'\ensure_left';
const ensure_right = __NAMESPACE__.'\ensure_right';
const split = __NAMESPACE__.'\split';
const chunk = __NAMESPACE__.'\chunk';
const iterate = __NAMESPACE__.'\iterate';
const change = __NAMESPACE__.'\change';
const replace = __NAMESPACE__.'\replace';
const replace_with_callback = __NAMESPACE__.'\replace_with_callback';
const matches = __NAMESPACE__.'\matches';
const contains = __NAMESPACE__.'\contains';
const contains_any = __NAMESPACE__.'\contains_any';
const contains_same_as = __NAMESPACE__.'\contains_same_as';
const starts_with = __NAMESPACE__.'\starts_with';
const starts_with_any = __NAMESPACE__.'\starts_with_any';
const starts_same_as = __NAMESPACE__.'\starts_same_as';
const ends_with = __NAMESPACE__.'\ends_with';
const ends_with_any = __NAMESPACE__.'\ends_with_any';
const ends_same_as = __NAMESPACE__.'\ends_same_as';

/**
 * @return \Closure(string $string):  int
 */
function length()
{
    return function (string $string) {
        return \mb_strlen($string);
    };
}

/**
 * @return \Closure(string $string): string
 */
function to_lower()
{
    return function (string $string) {
        return \mb_strtolower($string);
    };
}

/**
 * @return \Closure(string $string): string
 */
function to_upper()
{
    return function (string $string) {
        return \mb_strtoupper($string);
    };
}

/**
 * @return \Closure(string $string): string
 */
function to_lc_first()
{
    return function (string $string) {
        return \mb_strtolower(\mb_substr($string, 0, 1)).\mb_substr($string, 1);
    };
}

/**
 * @return \Closure(string $string): string
 */
function to_uc_first()
{
    return function (string $string) {
        return \mb_strtoupper(\mb_substr($string, 0, 1)).\mb_substr($string, 1);
    };
}

/**
 * @return \Closure(string $string): string
 */
function to_camel_case()
{
    return function (string $string) {
        return pipe()
            ->bind(trim())
            ->bind(replace('/^[-_]+/', ''))
            ->bind(function (string $string) {
                return preg_replace_callback(
                    '/[-_\s]+(.)?/u',
                    function ($match) {
                        if (isset($match[1])) {
                            return \mb_strtoupper($match[1]);
                        }
                        return '';
                    },
                    $string
                );
            })
            ->bind(function (string $string) {
                return preg_replace_callback(
                    '/[\d]+(.)?/u',
                    function ($match) {
                        return \mb_strtoupper($match[0]);
                    },
                    $string
                );
            })
            ->bind(to_lc_first())
            ->process($string)
        ;
    };
}

/**
 * @return \Closure(string $string): string
 */
function to_upper_camel_case()
{
    return function (string $string) {
        return to_uc_first()(to_camel_case()($string));
    };
}

/**
 * @return \Closure(string $string): string
 */
function to_snake_case()
{
    return function (string $string) {
        return pipe()
            ->bind(trim())
            ->bind(replace('\B([A-Z])', '-\1'))
            ->bind(to_lower())
            ->bind(replace('[-_\s]+', '_'))
            ->process($string)
        ;

    };
}

/**
 * @return \Closure(string $string): string
 */
function to_ascii()
{
    return function (string $string) {
        return \Transliterator::createFromRules(':: Any-Latin; :: Latin-ASCII; :: NFD; :: [:Nonspacing Mark:] Remove; :: NFC;', \Transliterator::FORWARD)
            ->transliterate($string)
        ;
    };
}

/**
 * @param string $delimiter
 *
 * @return \Closure(string $string): string
 */
function to_slug($delimiter = '-')
{
    return function (string $string) use ($delimiter) {
        $return = pipe()
            ->bind(to_ascii())
            ->bind(function (string $string) use ($delimiter) {
                return \preg_replace("/[^a-zA-Z\d\s-_".preg_quote($delimiter)."]/u", ' ', $string);
            })
            ->bind(trim())
            ->bind(to_lower())
            ->bind(replace('[-_\s]+', $delimiter))
            ->process($string)
        ;
        return $return;
    };
}

/**
 * @param $flags
 *
 * @return \Closure(string $string): string
 */
function html_encode(int $flags = ENT_COMPAT | ENT_HTML401)
{
    return function ($string) use ($flags) {
        return htmlentities($string, $flags);
    };
}

/**
 * @param $flags
 *
 * @return \Closure(string $string): string
 */
function html_decode(int $flags = ENT_COMPAT | ENT_HTML401)
{
    return function ($string) use ($flags) {
        return html_entity_decode($string, $flags);
    };
}

/**
 * @param int $start
 * @param int|null $length
 *
 * @return \Closure(string $string): string
 */
function substr(int $start, int $length = null)
{
    return function (string $string) use ($start, $length) {
        return \mb_substr($string, $start, $length);
    };
}

/**
 * @param int $index
 *
 * @return \Closure
 */
function at(int $index)
{
    return function (string $string) use ($index){
        return \mb_substr($string, $index, 1);
    };
}

/**
 * @param string $char
 * @param int $offset
 *
 * @return \Closure(string $string):  int
 */
function position(string $char, int $offset = 0)
{
    return function (string $string) use ($char, $offset) {
        return \mb_strpos($string, $char, $offset);
    };
}

/**
 * @param string $char
 * @param int $offset
 *
 * @return \Closure(string $string):  int
 */
function last_position(string $char, int $offset = 0)
{
    return function (string $string) use ($char, $offset) {
        return \mb_strrpos($string, $char, $offset);
    };
}

/**
 * @param int $n
 *
 * @return \Closure(string $string): string
 */
function firsts(int $length)
{
    return function (string $string) use ($length) {
        if ($length < 0) {
            return '';
        }
        return \mb_substr($string, 0, $length);
    };
}

/**
 * @param int $length
 *
 * @return \Closure(string $string): string
 */
function lasts(int $length)
{
    return function (string $string) use ($length) {
        if ($length < 0) {
            return '';
        }
        return \mb_substr($string, 0, $length);
    };
}

/**
 * @param string $prefix
 *
 * @return \Closure(string $string): string
 */
function prefix(string $prefix)
{
    return function (string $string) use ($prefix) {
        return $prefix.$string;
    };
}

/**
 * @param string $suffix
 *
 * @return \Closure(string $string): string
 */
function suffix(string $suffix)
{
    return function (string $string) use ($suffix) {
        return $string.$suffix;
    };
}

/**
 * @param string $chunk
 * @param $index
 *
 * @return \Closure(string $string): string
 */
function insert(string $chunk, $index)
{
    return function (string $string) use ($chunk, $index) {
        if (is_callable($index)) {
            $index = $index($string);
        }
        $index = (int) $index;
        $length = \mb_strlen($string);
        if ($index > $length) {
            return $string;
        }
        $start = \mb_substr($string, 0, $index);
        $end = \mb_substr($string, $index, $length);
        return $start . $chunk . $end;
    };
}

/**
 * @param string|null $mask
 *
 * @return \Closure(string $string): string
 */
function trim(string $mask = null)
{
    $mask = ($mask) ? \preg_quote($mask) : '[:space:]';
    return replace("^[$mask]+|[$mask]+\$", '');
}

/**
 * @param string|null $mask
 *
 * @return \Closure(string $string): string
 */
function trim_left(string $mask = null)
{
    $mask = ($mask) ? \preg_quote($mask) : '[:space:]';
    return replace("^[$mask]+", '');
}

/**
 * @param string|null $mask
 *
 * @return \Closure(string $string): string
 */
function trim_right(string $mask = null)
{
    $mask = ($mask) ? \preg_quote($mask) : '[:space:]';
    return replace("[$mask]+\$", '');
}

/**
 * @param int $length
 * @param string $glue
 *
 * @return \Closure(string $string): string
 *
 * @link http://www.php.net/manual/en/function.str-pad.php#89754
 */
function pad_left(int $length, string $glue = '')
{
    return function (string $string) use ($length, $glue) {
        $stringLength = \mb_strlen($string);
        if ($length <= 0 || $length <= $stringLength) {
            return $string;
        }
        $leftSize = $length - $stringLength;
        $leftPadding = \mb_substr(\str_repeat($glue, \ceil(($length - $stringLength / $length))), 0, $leftSize);
        return $leftPadding.$string;
    };
}

/**
 * @param int $length
 * @param string $glue
 *
 * @return \Closure(string $string): string
 *
 * @link http://www.php.net/manual/en/function.str-pad.php#89754
 */
function pad_right(int $length, string $glue = '')
{
    return function (string $string) use ($length, $glue) {
        $stringLength = \mb_strlen($string);
        if ($length <= 0 || $length <= $stringLength) {
            return $string;
        }
        $rightSize = $length - $stringLength;
        $rightPadding = \mb_substr(\str_repeat($glue, \ceil(($length - $stringLength / $length))), 0, $rightSize);
        return $string.$rightPadding;
    };
}

/**
 * @param int $length
 * @param string $glue
 *
 * @return \Closure(string $string): string
 *
 * @link http://www.php.net/manual/en/function.str-pad.php#89754
 */
function pad_both(int $length, string $glue = '')
{
    return function (string $string) use ($length, $glue) {
        $stringLength = \mb_strlen($string);
        if ($length <= 0 || $length <= $stringLength) {
            return $string;
        }

        $leftSize = \floor(($length - $stringLength) / 2);
        $leftPadding = \mb_substr(\str_repeat($glue, \ceil(($length - $stringLength / $length))), 0, $leftSize);

        $rightSize = \ceil(($length - $stringLength) / 2);
        $rightPadding = \mb_substr(\str_repeat($glue, \ceil(($length - $stringLength / $length))), 0, $rightSize);

        return \implode('', [$leftPadding, $string, $rightPadding]);
    };
}

/**
 * @param string $glue
 *
 * @return \Closure(string $string): string
 */
function wrap(string $glue)
{
    return function (string $string) use ($glue) {
        return \implode('', [$glue, $string, $glue]);
    };
}

/**
 * @param string $glue
 *
 * @return \Closure(string $string): string
 */
function ensure_left(string $glue)
{
    return function (string $string) use ($glue) {
        if (!starts_with($glue)($string)) {
            return $glue.$string;
        }
        return $string;
    };
}

/**
 * @param string $glue
 *
 * @return \Closure(string $string): string
 */
function ensure_right(string $glue)
{
    return function (string $string) use ($glue) {
        if (!ends_with($glue)($string)) {
            return $string.$glue;
        }
        return $string;
    };
}

/**
 * @param string $pattern
 * @param int $limit
 *
 * @return \Closure(string $string):  []
 */
function split(string $pattern, int $limit = -1)
{
    return function (string $string) use ($pattern, $limit) {
        return \mb_split($pattern, $string, $limit);
    };
}

/**
 * @param int $length
 * @param int $limit
 *
 * @return \Closure(string $string):  []
 *
 * @throws \InvalidArgumentException
 */
function chunk(int $length, int $limit = -1)
{
    if ($length <= 0) {
        throw new \InvalidArgumentException(sprintf('%s(): $length must be greater than 0, %d given', __FUNCTION__, $length));
    }

    return function (string $string) use ($length, $limit) {
        $strlength = \mb_strlen($string);
        $chunks = [];
        $start = 0;
        while ($start < $strlength) {
            $chunks[] = mb_substr($string, $start, $length);
            $start += $length;
            if ($limit > 0 && count($chunks) >= $limit) {
                return $chunks;
            }
        }
        return $chunks;
    };
}

/**
 * @return \Closure(string $string):  []
 */
function lines()
{
    return function (string $string) {
        return split('[\n\r]{1,2}')($string);
    };
}

/**
 * @return \Closure(string $string):  []
 */
function iterate()
{
    return function (string $string) {
        return preg_split('//u', $string, null, PREG_SPLIT_NO_EMPTY);
    };
}

/**
 * @param string $search
 * @param string $replacement
 *
 * @return \Closure(string $string): string
 */
function change(string $search, string $replacement)
{
    return function (string $string) use ($search, $replacement) {
        return replace(\preg_quote($search), $replacement)($string);
    };
}

/**
 * @param string $pattern
 * @param string $replacement
 * @param string $options
 *
 * @return \Closure(string $string): string
 */
function replace(string $pattern, string $replacement, $options = 'msr')
{
    return function (string $string) use ($pattern, $replacement, $options) {
        return \mb_ereg_replace($pattern, $replacement, $string, $options);
    };
}

/**
 * @param string $pattern
 * @param callable $function
 * @param string $options
 *
 * @return \Closure(string $string): string
 */
function replace_with_callback(string $pattern, callable $function, $options = 'msr')
{
    return function (string $string) use ($pattern, $function, $options) {
        return \mb_ereg_replace_callback($pattern, $function, $string, $options);
    };
}

/**
 * @param string $pattern
 * @param string $options
 *
 * @return \Closure(string $string):  boolean
 */
function matches(string $pattern, string $options = 'msr')
{
    return function (string $string) use ($pattern, $options) {
        return \mb_ereg_match($pattern, $string, $options);
    };
}

/**
 * @param string $chunk
 *
 * @return \Closure(string $string):  boolean
 */
function contains(string $chunk)
{
    return function (string $string) use ($chunk) {
        return (\mb_strpos($string, $chunk) !== false);
    };
}

/**
 * @param string $chunk
 *
 * @return \Closure(string $string):  boolean
 */
function contains_same_as(string $chunk)
{
    return function (string $string) use ($chunk) {
        return (\mb_stripos($string, $chunk) !== false);
    };
}

/**
 * @param array $chunks
 *
 * @return \Closure(string $string):  boolean
 */
function contains_any(array $chunks)
{
    return function (string $string) use ($chunks) {
        return \array_reduce($chunks, function ($carry, string $item) use ($string) {
            return $carry || contains($item)($string);
        }, false);
    };
}

/**
 * @param string $chunk
 *
 * @return \Closure(string $string):  boolean
 */
function starts_with(string $chunk)
{
    return function (string $string) use ($chunk) {
        $start =  \mb_substr($string, 0, \mb_strlen($chunk));
        return $start === $chunk;
    };
}

/**
 * @param array $chunks
 *
 * @return \Closure(string $string):  boolean
 */
function starts_with_any(array $chunks)
{
    return function (string $string) use ($chunks) {
        return \array_reduce($chunks, function ($carry, string $item) use ($string) {
            return $carry || starts_with($item)($string);
        }, false);
    };
}

/**
 * @param string $chunk
 *
 * @return \Closure(string $string):  boolean
 */
function starts_same_as(string $chunk)
{
    return function (string $string) use ($chunk) {
        $start =  \mb_substr($string, 0, \mb_strlen($chunk));
        return \mb_strtolower($start) === \mb_strtolower($chunk);
    };
}

/**
 * @param string $chunk
 *
 * @return \Closure(string $string):  boolean
 */
function ends_with(string $chunk)
{
    return function (string $string) use ($chunk) {
        $end =  \mb_substr($string, \mb_strlen($string) - \mb_strlen($chunk));
        return $end === $chunk;
    };
}

/**
 * @param array $chunks
 *
 * @return \Closure(string $string):  boolean
 */
function ends_with_any(array $chunks)
{
    return function (string $string) use ($chunks) {
        return \array_reduce($chunks, function (bool $carry, string $item) use ($string) {
            return $carry || ends_with($item)($string);
        }, false);
    };
}

/**
 * @param string $chunk
 *
 * @return \Closure(string $string):  boolean
 */
function ends_same_as(string $chunk)
{
    return function (string $string) use ($chunk) {
        $end =  \mb_substr($string, \mb_strlen($string) - \mb_strlen($chunk));
        return \mb_strtolower($end) === \mb_strtolower($chunk);
    };
}
