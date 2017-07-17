<?php

class PsrCacheCommonTest extends PHPUnit\Framework\TestCase
{
    public function testCacheItem()
    {
        $this->assertTrue(class_exists('WildWolf\\Cache\\CacheItem', true));

        $item = new WildWolf\Cache\CacheItem('key');
        $this->assertEquals('key', $item->getKey());
        $this->assertNull($item->get());
        $this->assertNull($item->expires());
        $this->assertFalse($item->isHit());

        $item->set('value');
        $this->assertEquals('value', $item->get());
        $this->assertNull($item->expires());
        $this->assertFalse($item->isHit());

        $item->set('4');
        $this->assertEquals('4', $item->get());
        $this->assertNotSame(4, $item->get());

        $when = \DateTime::createFromFormat('U', time() + 10);
        $item->expiresAt($when);
        $this->assertEquals($when, $item->expires());

        $item->expiresAfter(false);
        $this->assertNull($item->expires());

        $item->setIsHit(true);
        $this->assertTrue($item->isHit());
    }

    public function testInvalidArgumentException()
    {
        $this->assertTrue(class_exists('WildWolf\\Cache\\InvalidArgumentException', true));

        $e = new WildWolf\Cache\InvalidArgumentException;
        $this->assertInstanceOf(Psr\Cache\InvalidArgumentException::class, $e);
        $this->assertInstanceOf(Psr\SimpleCache\InvalidArgumentException::class, $e);
    }

    /**
     * Data provider for invalid keys.
     *
     * @return array
     */
    public static function invalidKeys()
    {
        return [
            [true],
            [false],
            [null],
            [2],
            [2.5],
            ['{str'],
            ['rand{'],
            ['rand{str'],
            ['rand}str'],
            ['rand(str'],
            ['rand)str'],
            ['rand/str'],
            ['rand\\str'],
            ['rand@str'],
            ['rand:str'],
            [new \stdClass()],
            [['array']],
        ];
    }

    /**
     * @expectedException \Psr\Cache\InvalidArgumentException
     * @dataProvider invalidKeys
     */
    public function testValidateKey($key)
    {
        WildWolf\Cache\Validator::validateKey($key);
    }

    /**
     * Data provider for invalid TTLs.
     *
     * @return array
     */
    public static function invalidTTLs()
    {
        return [
            [true],
            [false],
            [2.5],
            ['str'],
            [new \stdClass()],
            [['array']],
        ];
    }

    /**
     * @expectedException \Psr\Cache\InvalidArgumentException
     * @dataProvider invalidTTLs
     */
    public function testValidateBadTtl($ttl)
    {
        WildWolf\Cache\Validator::validateTtl($ttl);
    }

    /**
     * Data provider for good TTLs.
     *
     * @return array
     */
    public static function validTTLs()
    {
        return [
            [null],
            [0],
            [1],
            [new \DateInterval('PT10S')],
        ];
    }

    /**
     * @dataProvider validTTLs
     */
    public function testValidateGoodTtl($ttl)
    {
        WildWolf\Cache\Validator::validateTtl($ttl);
        $this->assertTrue(true);
    }

    /**
     * Data provider for iterables.
     *
     * @return array
     */
    public static function goodIterables()
    {
        return [
            [[]],
            [new \ArrayIterator([1, 2, 3])],
        ];
    }

    /**
     * @dataProvider goodIterables
     */
    public function testValidateIterable($item)
    {
        WildWolf\Cache\Validator::validateIterable($item);
        $this->assertTrue(true);
    }

    /**
     * Data provider for non-iterables.
     *
     * @return array
     */
    public static function badIterables()
    {
        return [
            [null],
            [true],
            [false],
            [1],
            [2.5],
            ['string'],
            [new \stdClass()],
        ];
    }

    /**
     * @expectedException \Psr\Cache\InvalidArgumentException
     * @dataProvider badIterables
     */
    public function testValidateNonIterable($item)
    {
        WildWolf\Cache\Validator::validateIterable($item);
        $this->assertTrue(true);
    }
}
