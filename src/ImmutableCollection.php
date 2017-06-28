<?php declare(strict_types=1);

namespace Cdtweb\Collection;

/**
 * ImmutableCollection
 *
 * @package Cdtweb\Collection
 */
class ImmutableCollection extends Collection
{
    ///////////////////////////////////
    // Magic Methods

    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    public function __unset($key)
    {
        $this->delete($key);
    }

    ///////////////////////////////////
    // Collection Methods

    /**
     * Make collection from one or more arrays.
     *
     * @param array[] $arrays
     * @return Collection
     */
    public static function make(array ...$arrays): Collection
    {
        $items = [];
        foreach ($arrays as $arr) {
            $items += $arr;
        }
        return new self($items);
    }

    /**
     * Add item to collection.
     *
     * @param string|integer $key
     * @param mixed $value
     * @return void
     * @throws ImmutableCollectionException
     */
    public function set($key, $value): void
    {
        throw new ImmutableCollectionException('Collection is immutable.');
    }

    /**
     * Pluck an item from the collection. Return $default if item not found.
     *
     * @param string|integer $key
     * @param mixed $default
     * @return mixed
     * @throws ImmutableCollectionException
     */
    public function pluck($key, $default = null)
    {
        throw new ImmutableCollectionException('Collection is immutable.');
    }

    /**
     * Delete item from collection.
     *
     * @param string|integer $key
     * @return void
     * @throws ImmutableCollectionException
     */
    public function delete($key): void
    {
        throw new ImmutableCollectionException('Collection is immutable.');
    }

    /**
     * Empty collection.
     * @return void
     * @throws ImmutableCollectionException
     */
    public function destroy(): void
    {
        throw new ImmutableCollectionException('Collection is immutable.');
    }

    ///////////////////////////////////
    // ArrayAccess Methods

    public function offsetSet($offset, $value)
    {
        throw new ImmutableCollectionException('Collection is immutable.');
    }

    public function offsetUnset($offset)
    {
        throw new ImmutableCollectionException('Collection is immutable.');
    }
}
