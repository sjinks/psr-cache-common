<?php

namespace WildWolf\Cache;

use WildWolf\Cache\Validator;

abstract class Utils
{
    /**
     * @param iterable $keys
     * @return array
     */
    public static function keysToArray($keys) : array
    {
        Validator::validateIterable($keys);

        $k = [];
        foreach ($keys as $key) {
            Validator::validateKey($key);
            $k[] = $key;
        }

        return $k;
    }

    /**
     * @param iterable $values
     * @return array
     */
    public static function iterableToArray($values) : array
    {
        Validator::validateIterable($values);

        $retval = [];
        foreach ($values as $key => $value) {
            if (!is_int($key)) {
                Validator::validateKey($key);
            }

            $retval[$key] = $value;
        }

        return $retval;
    }

    /**
     * @param \DateInterval|int|null $ttl
     * @return int|null
     */
    public static function relativeTtl($ttl)
    {
        Validator::validateTtl($ttl);

        if ($ttl instanceof \DateInterval) {
            $now  = new \DateTime('now');
            $then = clone $now;
            $then->add($ttl);
            $ttl  = $then->getTimestamp() - $now->getTimestamp();
        }

        return $ttl;
    }
}
