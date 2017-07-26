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
            [new \ArrayIterator(['a', 'b', 'c']), ['a', 'b', 'c']],
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

    /**
     * Data provider for iterableToArray() test
     *
     * return array
     */
    public static function iterableToArrayProvider()
    {
        return [
            [['a' => 'A', 'b' => 'B', 'c' => 'C'],                     ['a' => 'A', 'b' => 'B', 'c' => 'C']],
            [new \ArrayIterator(['a' => 'A', 'b' => 'B', 'c' => 'C']), ['a' => 'A', 'b' => 'B', 'c' => 'C']],
        ];
    }

    /**
     * @dataProvider iterableToArrayProvider
     */
    public function testIterableToArray($input, $expected)
    {
        $actual = \WildWolf\Cache\Utils::iterableToArray($input);
        $this->assertSame($expected, $actual);
    }

    /**
     * Data provider for relativeTtl() test
     *
     * return array
     */
    public function relativeTtlProvider()
    {
        return [
            [new \DateInterval('PT10S'), 10],
            [5,                           5],
            [null,                     null],
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
