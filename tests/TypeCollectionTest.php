<?php declare(strict_types=1);

namespace Cdtweb\Collection;

use PHPUnit\Framework\TestCase;

class TypeCollectionTest extends TestCase
{
    ///////////////////////////////////
    // Tests

    /**
     * @covers TypeCollection::make
     * @expectedException \Cdtweb\Collection\TypeCollectionException
     */
    public function testMake()
    {
        TypeCollection::make([1, 2, 3]);
    }

    /**
     * @covers TypeCollection::set
     */
    public function testSettingTypes()
    {
        $testData = [
            TypeCollection::STRING => [
                'pass' => [
                    'key1' => 'val1',
                    'key2' => 'val2',
                ],
                'fail' => 100,
            ],
            TypeCollection::INTEGER => [
                'pass' => [
                    'key1' => 1,
                    'key2' => 2,
                ],
                'fail' => 'hello, world',
            ],
            TypeCollection::BOOLEAN => [
                'pass' => [
                    'key1' => true,
                    'key2' => false,
                ],
                'fail' => 'hello, world',
            ],
            TypeCollection::DOUBLE => [
                'pass' => [
                    'key1' => 1.0,
                    'key2' => 1e7,
                ],
                'fail' => 100,
            ],
            TypeCollection::ARRAY => [
                'pass' => [
                    'key1' => [],
                    'key2' => [1,2,3],
                ],
                'fail' => 'hello, world',
            ],
            TypeCollection::OBJECT => [
                'pass' => [
                    'key1' => new \stdClass,
                    'key2' => function () {
                    },
                    'key3' => new Collection(),
                ],
                'fail' => 'hello, world',
            ],
            TypeCollection::NULL => [
                'pass' => [
                    'key1' => null,
                    'key2' => null,
                ],
                'fail' => 'hello, world',
            ],
            '\stdClass' => [
                'pass' => [
                    'key1' => new \stdClass,
                    'key2' => new \stdClass,
                ],
                'fail' => new Collection(),
            ]
        ];

        foreach ($testData as $type => $data) {
            $collection = new TypeCollection($type, $data['pass']);
            $this->assertTrue($collection->has('key1'));
            $this->assertTrue($collection->has('key2'));
            try {
                $collection->set('fail', $data['fail']);
            } catch (\Exception $e) {
                $this->assertInstanceOf(TypeCollectionException::class, $e);
                $eCollection = $e->getCollection();
                $this->assertFalse($eCollection->has('fail'));
            }
        }
    }
}
