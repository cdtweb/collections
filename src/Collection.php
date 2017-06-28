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
class Collection implements Countable, ArrayAccess, IteratorAggregate, Serializable, JsonSerializable
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
     * Make a collection from one or more arrays.
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
     * Add an item to the collection.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->items[$key] = $value;
    }

    /**
     * Get an item from the collection. Returns $default if item cannot be found.
     *
     * Passing an array of item keys for the value of $key will result in multiple
     * items being returned. Keys that are missing from the collection will be
     * returned with a value of $default.
     *
     * @param mixed $key
     * @param mixed $default
     * @return mixed Will return $default if cannot find item
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
     * Pluck an item from the collection. Returns $default if item cannot be found.
     *
     * @param string $key
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
     * Gets all of the items in the collection as an array.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->toArray();
    }

    /**
     * Gets keys for all of the items in the collection.
     *
     * @return array
     */
    public function keys(): array
    {
        return array_keys($this->items);
    }

    /**
     * Gets values for all of the items in the collection.
     *
     * @return array
     */
    public function values(): array
    {
        return array_values($this->items);
    }

    /**
     * Checks for existence of an item in the collection.
     *
     * @param string $key
     * @return boolean
     */
    public function has($key): bool
    {
        return isset($this->items[$key]);
    }

    /**
     * Deletes an item from the collection.
     *
     * @param string $key
     */
    public function delete($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Delete all items in collection.
     */
    public function destroy()
    {
        $this->items = [];
    }

    /**
     * Get collection as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->items;
    }

    /**
     * Get collection as JSON.
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
