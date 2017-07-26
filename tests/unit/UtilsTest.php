<?php

namespace WildWolf\Tests;

class UtilsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Data provider for keysToArray() test
     *
     * return array
     */
    public static function keysToArrayProvider()
    {
        return [
            [['a', 'b', 'c'],                     ['a', 'b', 'c']],
            [new \ArrayIterator(['a', 'b', 'c']), ['a', 'b', 'c']]
        ];
    }

    /**
     * @dataProvider keysToArrayProvider
     */
    public function testKeysToArray($input, $expected)
    {
        $actual = \WildWolf\Cache\Utils::keysToArray($input);
        $this->assertSame($expected, $actual);
    }

    public function relativeTtlProvider()
    {
        return [
            [new \DateInterval('PT10S'), 10],
            [5,                           5],
            [null,                     null]
        ];
    }

    /**
     * @dataProvider relativeTtlProvider
     */
    public function testRelativeTtl($input, $expected)
    {
        $actual = \WildWolf\Cache\Utils::relativeTtl($input);
        $this->assertSame($expected, $actual);
    }
}
