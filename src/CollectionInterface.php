<?php declare(strict_types=1);

namespace Cdtweb\Collection;

interface CollectionInterface
{
    /**
     * Make collection from one or more arrays.
     *
     * @param array[] $arrays
     * @return Collection
     */
    public static function make(array ...$arrays): Collection;

    /**
     * Add item to collection.
     *
     * @param string|integer $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value): void;

    /**
     * Get item(s) from collection. Return $default if item not found.
     *
     * @param string|integer|array $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Pluck an item from the collection. Return $default if item not found.
     *
     * @param string|integer $key
     * @param mixed $default
     * @return mixed
     */
    public function pluck($key, $default = null);

    /**
     * Alias for toArray()
     *
     * @return array
     */
    public function all(): array;

    /**
     * Get item keys as array.
     *
     * @return array
     */
    public function keys(): array;

    /**
     * Get item values as array.
     *
     * @return array
     */
    public function values(): array;

    /**
     * Check if collection has item.
     *
     * @param string|integer $key
     * @return boolean
     */
    public function has($key): bool;

    /**
     * Delete item from collection.
     *
     * @param string|integer $key
     * @return void
     */
    public function delete($key): void;

    /**
     * Empty collection.
     *
     * @return void
     */
    public function destroy(): void;

    /**
     * Get collection as array.
     *
     * @return array
     */
    public function toArray(): array;

    /**
     * Get collection JSON string.
     *
     * @return string
     */
    public function toJson(): string;
}
