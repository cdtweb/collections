<?php declare(strict_types=1);

namespace Cdtweb\Collection;

use PHPUnit\Framework\TestCase;

class CollectionTest extends TestCase
{
    protected $collection;

    protected $basicCollection = [
        'key1' => 'val1',
        'key2' => 'val2',
        'key3' => 'val3',
        'key4' => 'val4',
    ];

    protected function setUp()
    {
        $this->collection = new Collection;
    }

    ///////////////////////////////////
    // Data providers

    public function collectionItemsProvider()
    {
        return [
            ['key1', 'val1'],
            ['key2', 'val2'],
            ['key3', 'val3'],
            ['key4', 'val4'],
        ];
    }

    ///////////////////////////////////
    // Tests

    /**
     * @covers Collection::make
     */
    public function testMake()
    {
        $items_1 = ['key1' => 'val1'];
        $items_2 = ['key2' => 'val2'];
        $items_3 = ['key3' => 'val3'];
        $collection = Collection::make($items_1, $items_2, $items_3);
        $this->assertTrue($collection->has('key1'));
        $this->assertTrue($collection->has('key2'));
        $this->assertTrue($collection->has('key3'));
    }

    /**
     * @covers Collection::count
     */
    public function testEmpty()
    {
        $this->assertTrue($this->collection->count() == 0);
    }

    /**
     * @covers       Collection::set, Collection:get
     * @dataProvider collectionItemsProvider
     */
    public function testSet($key, $value)
    {
        $this->collection->set($key, $value);
        $this->assertEquals($value, $this->collection->get($key));
    }

    /**
     * @covers       Collection::has
     * @dataProvider collectionItemsProvider
     */
    public function testHas($key, $value)
    {
        $this->collection->set($key, $value);
        $this->assertTrue($this->collection->has($key));
    }

    /**
     * @covers       Collection::pluck
     * @dataProvider collectionItemsProvider
     */
    public function testPluck($key, $value)
    {
        $this->collection->set($key, $value);
        $plucked = $this->collection->pluck($key);
        $this->assertEquals($plucked, $value);
        $this->assertFalse($this->collection->has($key));
    }

    /**
     * @covers       Collection::all, Collection::toArray, Collection::keys, Collection::values
     * @dataProvider collectionItemsProvider
     */
    public function testToArray($key, $value)
    {
        $this->collection->set($key, $value);
        $arr = $this->collection->toArray();
        $keys = $this->collection->keys();
        $values = $this->collection->values();

        $this->assertTrue(is_array($arr));
        $this->assertEquals($arr[$key], $value);
        $this->assertEquals($keys, array_keys($arr));
        $this->assertEquals($values, array_values($arr));
    }

    /**
     * @covers       Collection::toJson
     * @dataProvider collectionItemsProvider
     */
    public function testToJson($key, $value)
    {
        $this->collection->set($key, $value);
        $json = json_encode($this->collection);

        $this->assertEquals($json, $this->collection->toJson());
    }

    /**
     * @covers       Collection::delete, Collection::count
     * @dataProvider collectionItemsProvider
     */
    public function testDelete($key, $value)
    {
        $this->collection->set($key, $value);
        $this->assertTrue($this->collection->count() == 1);
        $this->collection->delete($key);
        $this->assertFalse($this->collection->get($key, false));
    }

    /**
     * @covers       Collection::destroy, Collection::count
     * @dataProvider collectionItemsProvider
     */
    public function testDestroy($key, $value)
    {
        $this->collection->set($key, $value);
        $this->assertTrue($this->collection->count() == 1);
        $this->collection->destroy();
        $this->assertTrue($this->collection->count() == 0);
    }

    /**
     * @covers       Collection::getIterator
     * @dataProvider collectionItemsProvider
     */
    public function testGetIterator($key, $value)
    {
        $this->collection->set($key, $value);
        $this->assertEquals(iterator_to_array($this->collection->getIterator()), $this->collection->toArray());
    }

    /**
     * @covers       Collection::jsonSerialize
     * @dataProvider collectionItemsProvider
     */
    public function testJsonEncode($key, $value)
    {
        $this->collection->set($key, $value);
        $json = json_encode($this->collection);
        $this->assertEquals(json_decode($json, true), $this->collection->toArray());
    }

    /**
     * @covers Collection::serialize, Collection::unserialize
     */
    public function testSerialize()
    {
        $data = [
            'key1' => 'value1',
            'key2' => 'value2'
        ];

        $collection1 = new Collection($data);
        $serializedCollection = serialize($collection1);
        $collection2 = unserialize($serializedCollection);
        $this->assertEquals($collection1, $collection2);
    }

    /**
     * @covers Collection::__set, Collection::__get, Collection::__isset, Collection::__unset
     */
    public function testMagicMethods()
    {
        $collection = new Collection;

        $collection['key1'] = 'value1';

        $this->assertTrue($collection->has('key1'));
        $this->assertEquals($collection->get('key1'), 'value1');
        $this->assertEquals($collection['key1'], 'value1');

        unset($collection['key1']);
        $this->assertFalse($collection->has('key1'));
    }

    /**
     * @covers Collection::get
     */
    public function testGetMultipleItems()
    {
        $collection = new Collection(['key1' => 'value1', 'key2' => 'value2']);
        $values = $collection->get(['key1', 'key2', 'key3']);

        $this->assertTrue(array_key_exists('key1', $values) && $values['key1'] == 'value1');
        $this->assertTrue(array_key_exists('key2', $values) && $values['key2'] == 'value2');

        // Assert the key3 equals the default (null)
        $this->assertTrue(array_key_exists('key3', $values) && $values['key3'] == null);
    }
}
