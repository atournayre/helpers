<?php

namespace Atournayre\Helper\Tests\Collection;

use Atournayre\Helper\Collection\TypedCollectionImmutable;
use PHPUnit\Framework\TestCase;

class TypedCollectionTest extends TestCase
{
    /**
     * @covers \Atournayre\Helper\Collection\TypedCollectionImmutable::fromList
     * @return void
     */
    public function testFromList(): void
    {
        $list = [];
        $list[] = new \DateTime();

        $collection = TypedCollectionImmutable::fromList($list, \DateTime::class);

        static::assertInstanceOf(\DateTime::class, $collection->first());
    }

    /**
     * @covers \Atournayre\Helper\Collection\TypedCollectionImmutable::fromList
     * @return void
     */
    public function testFromListThrowAnExceptionIfArrayIsMap(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected list - non-associative array of DateTime.');

        $map = [];
        $map['a'] = new \DateTime();

        TypedCollectionImmutable::fromList($map, \DateTime::class);
    }

    /**
     * @covers \Atournayre\Helper\Collection\TypedCollectionImmutable::fromList
     * @return void
     */
    public function testFromListThrowAnExceptionIfElementIsWrongType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected list - non-associative array of DateTime.');

        $list = [];
        $list[] = new \stdClass();

        TypedCollectionImmutable::fromList($list, \DateTime::class);
    }

    /**
     * @covers \Atournayre\Helper\Collection\TypedCollectionImmutable::fromMap
     * @return void
     */
    public function testFromMap(): void
    {
        $map = [];
        $map['a'] = new \DateTime();

        $collection = TypedCollectionImmutable::fromMap($map, \DateTime::class);

        static::assertInstanceOf(\DateTime::class, $collection->first());
    }

    /**
     * @covers \Atournayre\Helper\Collection\TypedCollectionImmutable::fromMap
     * @return void
     */
    public function testFromMapThrowAnExceptionIfArrayIsList(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected map - associative array with string keys of DateTime.');

        $list = [];
        $list[] = new \DateTime();

        TypedCollectionImmutable::fromMap($list, \DateTime::class);
    }

    /**
     * @covers \Atournayre\Helper\Collection\TypedCollectionImmutable::fromMap
     * @return void
     */
    public function testFromMapThrowAnExceptionIfElementIsWrongType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected map - associative array with string keys of DateTime.');

        $map = [];
        $map['a'] = new \stdClass();

        TypedCollectionImmutable::fromMap($map, \DateTime::class);
    }

    /**
     * @covers \Atournayre\Helper\Collection\TypedCollectionImmutable::set
     * @return void
     */
    public function testSetElementToCollection(): void
    {
        $map = [];
        $map['a'] = new \DateTime();

        $collection = TypedCollectionImmutable::fromMap($map, \DateTime::class);

        $collectionNew = TypedCollectionImmutable::set($collection, 'b', new \DateTime());

        static::assertCount(1, $collection);
        static::assertCount(2, $collectionNew);
    }

    /**
     * @covers \Atournayre\Helper\Collection\TypedCollectionImmutable::add
     * @return void
     */
    public function testAddElementToCollection(): void
    {
        $list = [];
        $list[] = new \DateTime();

        $collection = TypedCollectionImmutable::fromList($list, \DateTime::class);

        $collectionNew = TypedCollectionImmutable::add($collection, new \DateTime());

        static::assertCount(1, $collection);
        static::assertCount(2, $collectionNew);
    }

    /**
     * @covers \Atournayre\Helper\Collection\TypedCollectionImmutable::add
     * @return void
     */
    public function testAddElementToCollectionThrowExceptionIfArrayKeysContainsString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected list - non-associative array.');

        $map = [];
        $map['a'] = new \DateTime();

        $collection = TypedCollectionImmutable::fromMap($map, \DateTime::class);
        TypedCollectionImmutable::add($collection, new \DateTime());
    }

    /**
     * @covers \Atournayre\Helper\Collection\TypedCollectionImmutable::set
     * @return void
     */
    public function testSetElementToMapThrowExceptionIfKeyIsInteger(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Adding element to collection (map) using integer key is not supported.');

        $map = [];
        $map['a'] = new \DateTime();

        $collection = TypedCollectionImmutable::fromMap($map, \DateTime::class);
        TypedCollectionImmutable::set($collection, 0, new \DateTime());
    }

    /**
     * @covers \Atournayre\Helper\Collection\TypedCollectionImmutable::set
     * @return void
     */
    public function testSetElementToListThrowExceptionIfKeyIsString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Adding element to collection (list) using string key is not supported.');

        $list = [];
        $list[] = new \DateTime();

        $collection = TypedCollectionImmutable::fromList($list, \DateTime::class);
        TypedCollectionImmutable::set($collection, 'a', new \DateTime());
    }
}
