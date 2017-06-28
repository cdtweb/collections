<?php declare(strict_types=1);

namespace Cdtweb\Collection;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use Serializable;
use JsonSerializable;

/**
 * Collection
 *
 * @package Cdtweb\Collection
 */
class Collection implements CollectionInterface, Countable, ArrayAccess, IteratorAggregate, Serializable, JsonSerializable
{
    /**
     * Array of items.
     *
     * @var array $items
     */
    protected $items = [];

    /**
     * Collection constructer.
     *
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    ///////////////////////////////////
    // Magic Methods

    public function __set($key, $value)
    {
        $this->set($key, $value);
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __isset($key)
    {
        return $this->has($key);
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
     */
    public function set($key, $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * Get item(s) from collection. Return $default if item not found.
     *
     * @param string|integer|array $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (is_array($key)) {
            // Get multiple items by their key
            $items = [];
            foreach ($key as $k) {
                $items[$k] = isset($this->items[$k]) ? $this->items[$k] : $default;
            }

            return $items;
        } else {
            // Get a single item by its key
            return isset($this->items[$key]) ? $this->items[$key] : $default;
        }
    }

    /**
     * Pluck an item from the collection. Return $default if item not found.
     *
     * @param string|integer $key
     * @param mixed $default
     * @return mixed
     */
    public function pluck($key, $default = null)
    {
        $value = $this->get($key, $default);

        $this->delete($key);

        return $value;
    }

    /**
     * Alias for toArray()
     *
     * @return array
     */
    public function all(): array
    {
        return $this->toArray();
    }

    /**
     * Get item keys as array.
     *
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->items);
    }

    /**
     * Get item values as array.
     *
     * @return array
     */
    public function values(): array
    {
        return array_values($this->items);
    }

    /**
     * Check if collection has item.
     *
     * @param string|integer $key
     * @return boolean
     */
    public function has($key): bool
    {
        return isset($this->items[$key]) || array_key_exists($key, $this->items);
    }

    /**
     * Delete item from collection.
     *
     * @param string|integer $key
     * @return void
     */
    public function delete($key): void
    {
        unset($this->items[$key]);
    }

    /**
     * Empty collection.
     *
     * @return void
     */
    public function destroy(): void
    {
        $this->items = [];
    }

    /**
     * Get collection as array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * Get collection JSON string.
     *
     * @return string
     */
    public function toJson(): string
    {
        return json_encode($this);
    }

    ///////////////////////////////////
    // IteratorAggregate Methods

    public function getIterator()
    {
        foreach ($this->items as $key => $value) {
            yield $key => $value;
        }
    }

    ///////////////////////////////////
    // Countable Methods

    public function count()
    {
        return count($this->items);
    }

    ///////////////////////////////////
    // ArrayAccess Methods

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        return $this->delete($offset);
    }

    ///////////////////////////////////
    // JsonSerializable Methods

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    ///////////////////////////////////
    // Serializable Methods

    public function serialize()
    {
        return serialize($this->items);
    }

    public function unserialize($serialized)
    {
        $this->items = unserialize($serialized);
    }
}
