<?php

namespace Atournayre\Helper\Collection;

use Webmozart\Assert\Assert;

class TypedCollection
{
    private function __construct() {}

    /**
     * @param array  $collection
     * @param string $expectedClass
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function createMap(array $collection, string $expectedClass): array
    {
        $map = [];
        foreach ($collection as $key => $value) {
            Assert::string($key);
            Assert::isInstanceOf($value, $expectedClass);
            $map[$key] = $value;
        }
        return $map;
    }

    /**
     * @param array  $collection
     * @param string $expectedClass
     *
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function createList(array $collection, string $expectedClass): array
    {
        $list = [];
        foreach ($collection as $key => $value) {
            Assert::integer($key);
            Assert::isInstanceOf($value, $expectedClass);
            $list[$key] = $value;
        }
        return $list;
    }
}
