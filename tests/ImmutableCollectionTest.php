<?php declare(strict_types=1);

namespace Cdtweb\Collection;

use PHPUnit\Framework\TestCase;

class ImmutableCollectionTest extends TestCase
{
    protected $collection;

    protected function setUp()
    {
        $this->collection = new ImmutableCollection();
    }

    ///////////////////////////////////
    // Tests

    /**
     * @covers ImmutableCollection::make
     */
    public function testMake()
    {
        $items_1 = ['key1' => 'val1'];
        $items_2 = ['key2' => 'val2'];
        $items_3 = ['key3' => 'val3'];
        $collection = ImmutableCollection::make($items_1, $items_2, $items_3);
        $this->assertInstanceOf(ImmutableCollection::class, $collection);
    }

    /**
     * @covers ImmutableCollection::set
     * @expectedException \Cdtweb\Collection\ImmutableCollectionException
     */
    public function testSet()
    {
        $this->collection->set('hello', 'world');
    }

    /**
     * @covers ImmutableCollection::pluck
     * @expectedException \Cdtweb\Collection\ImmutableCollectionException
     */
    public function testPluck()
    {
        $collection = new ImmutableCollection(['hello' => 'world']);
        $collection->pluck('hello');
    }

    /**
     * @covers ImmutableCollection::delete
     * @expectedException \Cdtweb\Collection\ImmutableCollectionException
     */
    public function testDelete()
    {
        $collection = new ImmutableCollection(['hello' => 'world']);
        $collection->delete('hello');
    }

    /**
     * @covers ImmutableCollection::destroy
     * @expectedException \Cdtweb\Collection\ImmutableCollectionException
     */
    public function testDestroy()
    {
        $collection = new ImmutableCollection(['hello' => 'world']);
        $collection->destroy();
    }

    /**
     * @covers ImmutableCollection::__set
     * @expectedException \Cdtweb\Collection\ImmutableCollectionException
     */
    public function testMagicSet()
    {
        $collection = new ImmutableCollection(['hello' => 'world']);

        // Test __set()
        $collection['key1'] = 'value1';
    }

    /**
     * @covers ImmutableCollection::__unset
     * @expectedException \Cdtweb\Collection\ImmutableCollectionException
     */
    public function testMagicUnset()
    {
        $collection = new ImmutableCollection(['hello' => 'world']);
        unset($collection['hello']);
    }
}
