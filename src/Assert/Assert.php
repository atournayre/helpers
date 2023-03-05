<?php

namespace Atournayre\Helper\Assert;

class Assert extends \Webmozart\Assert\Assert
{
    /**
     * @param array  $collection
     * @param string $expectedClass
     * @param string $message
     *
     * @return void
     */
    public static function isListOf(array $collection, string $expectedClass, string $message = ''): void
    {
        $message = $message ?: sprintf('Expected list - non-associative array of %s.', $expectedClass);
        static::isList($collection, $message);
        static::allIsInstanceOf($collection, $expectedClass, $message);
    }

    /**
     * @param array  $collection
     * @param string $expectedClass
     * @param string $message
     *
     * @return void
     */
    public static function isMapOf(array $collection, string $expectedClass, string $message = ''): void
    {
        $message = $message ?: sprintf('Expected map - associative array with string keys of %s.', $expectedClass);
        static::isMap($collection, $message);
        static::allIsInstanceOf($collection, $expectedClass, $message);
    }
}
