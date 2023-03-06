<?php

namespace Atournayre\Helper\Collection;

use Atournayre\Helper\Assert\Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class TypedCollectionImmutable
{
    public static function fromList(array $array, string $expectedClass): Collection
    {
        Assert::isListOf($array, $expectedClass);
        return new ArrayCollection($array);
    }

    public static function fromMap(array $array, string $expectedClass): Collection
    {
        Assert::isMapOf($array, $expectedClass);
        return new ArrayCollection($array);
    }

    public static function add(Collection $collection, mixed $element): Collection
    {
        Assert::elementTypeMatchFirstElementOfCollection($element, $collection);

        $collection = clone $collection;
        $collection->add($element);
        return $collection;
    }

    public static function set(Collection $collection, string $key, mixed $value): Collection
    {
        Assert::elementTypeMatchFirstElementOfCollection($value, $collection);

        $collection = clone $collection;
        $collection->set($key, $value);
        return $collection;
    }
}
