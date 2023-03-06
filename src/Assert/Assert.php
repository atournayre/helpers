<?php

namespace Atournayre\Helper\Assert;

use Doctrine\Common\Collections\Collection;
use Webmozart\Assert\InvalidArgumentException;
use function sprintf;

class Assert extends \Webmozart\Assert\Assert
{
    /**
     * @param array  $array
     * @param string $expectedClass
     * @param string $message
     *
     * @return void
     *
     * @throws InvalidArgumentException
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
     *
     * @throws InvalidArgumentException
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
     *
     * @throws InvalidArgumentException
     */
    public static function isCollectionOf(Collection $collection, string $expectedClass, string $message = ''): void
    {
        static::allIsInstanceOf($collection->toArray(), $expectedClass, $message);
    }

    /**
     * @param mixed      $element
     * @param Collection $collection
     *
     * @return void
     *
     * @throws InvalidArgumentException
     */
    public static function elementTypeMatchFirstElementOfCollection(mixed $element, Collection $collection): void
    {
        if ($collection->isEmpty()) {
            return;
        }

        $expectedClass = \get_class($collection->first());
        Assert::isInstanceOf($element, $expectedClass);
    }
}
