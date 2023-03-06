<?php

namespace Atournayre\Helper\Assert;

use Doctrine\Common\Collections\Collection;
use function sprintf;

class Assert extends \Webmozart\Assert\Assert
{
    /**
     * @param array  $array
     * @param string $expectedClass
     * @param string $message
     *
     * @return void
     */
    public static function isListOf(array $array, string $expectedClass, string $message = ''): void
    {
        $message = $message ?: sprintf('Expected list - non-associative array of %s.', $expectedClass);
        static::isList($array, $message);
        static::allIsInstanceOf($array, $expectedClass, $message);
    }

    /**
     * @param array  $array
     * @param string $expectedClass
     * @param string $message
     *
     * @return void
     */
    public static function isMapOf(array $array, string $expectedClass, string $message = ''): void
    {
        $message = $message ?: sprintf('Expected map - associative array with string keys of %s.', $expectedClass);
        static::isMap($array, $message);
        static::allIsInstanceOf($array, $expectedClass, $message);
    }

    /**
     * @param Collection $collection
     * @param string     $expectedClass
     * @param string     $message
     *
     * @return void
     */
    public static function isCollectionOf(Collection $collection, string $expectedClass, string $message = ''): void
    {
        static::allIsInstanceOf($collection->toArray(), $expectedClass, $message);
    }
}
