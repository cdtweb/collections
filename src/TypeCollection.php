<?php declare(strict_types=1);

namespace Cdtweb\Collection;

/**
 * TypeCollection
 *
 * @package Cdtweb\Collection
 */
class TypeCollection extends Collection
{
    /**
     * Type constants
     */
    public const INTEGER = 'integer';
    public const STRING = 'string';
    public const BOOLEAN = 'boolean';
    public const DOUBLE = 'double';
    public const FLOAT = self::DOUBLE;
    public const ARRAY = 'array';
    public const OBJECT = 'object';
    public const NULL = 'null';

    /**
     * @var mixed
     */
    protected $type;

    /**
     * TypeCollection constructor.
     *
     * @param mixed $type
     * @param array $items
     */
    public function __construct($type, array $items = [])
    {
        $this->type = $type;
        parent::__construct($items);
    }

    /**
     * This method is not available for TypeCollection.
     *
     * @throws \BadMethodCallException
     * @param \array[] ...$arrays
     * @return Collection
     */
    public static function make(array ...$arrays): Collection
    {
        throw new TypeCollectionException('Cannot make collection of TypeCollection. Use `new TypeCollection` instead.');
    }

    /**
     * Add item to collection.
     *
     * @throws TypeCollectionException
     * @param int|string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value): void
    {
        if (is_object($value) && !is_a($value, $this->type)) {
            throw new TypeCollectionException("Invalid value; Expected instance of {$this->type}.", $this);
        } elseif (gettype($value) != $this->type) {
            throw new TypeCollectionException("Invalid value; Expected type of {$this->type}.", $this);
        }
        parent::set($key, $value);
    }
}
